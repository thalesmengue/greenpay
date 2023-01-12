<?php

namespace Tests\Feature;

use App\Exceptions\TransactionException;
use App\Exceptions\UserException;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_make_a_successfull_transaction(): void
    {
        $user = User::factory()->has(Wallet::factory()->state(['balance' => 200]))->create();
        $receiver = User::factory()->has(Wallet::factory()->state(['balance' => 0]))->state(['role' => 'shopkeeper'])->create();

        Passport::actingAs($user);

        Http::fake([
            'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6' => Http::response([
                'message' => 'Autorizado'
            ], 200)
        ]);

        Http::fake([
            'http://o4d9z.mocklab.io/notify' => Http::response([
                'message' => 'Success'
            ], 200)
        ]);

        $response = $this->post(route('transaction'), [
            'payer_id' => $user->id,
            'receiver_id' => $receiver->id,
            'amount' => 100
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertCreated();

        $transaction = $response->collect('transaction');

        $this->assertDatabaseHas('wallets', [
            'keeper_id' => $user->id,
            'balance' => 100
        ]);

        $this->assertDatabaseHas('wallets', [
            'keeper_id' => $receiver->id,
            'balance' => 100
        ]);

        $this->assertDatabaseHas('transactions', [
                'id' => $transaction['id'],
                'amount' => 100
            ]
        );
    }

    public function test_shopkeeper_cant_send_transaction(): void
    {
        $user = User::factory()->has(Wallet::factory()->state(['balance' => 200]))->state(['role' => 'shopkeeper'])->create();
        $receiver = User::factory()->has(Wallet::factory()->state(['balance' => 0]))->create();

        Passport::actingAs($user);

        $this->withoutExceptionHandling();

        $response = $this->post(route('transaction'), [
            'payer_id' => $user->id,
            'receiver_id' => $receiver->id,
            'amount' => 100,
        ]);

        $exception = UserException::cantSendTransaction();

        $response->assertUnprocessable();
        $response->assertSee($exception->getMessage());
    }
}
