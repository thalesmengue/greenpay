<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
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

        $this->withoutExceptionHandling();

        $response = $this->post(route('transaction'), [
            'payer_id' => $user->id,
            'receiver_id' => $receiver->id,
            'amount' => 100
        ]);

        $response->assertStatus(201);
        $response->assertCreated();

        $this->assertDatabaseHas('transactions', [
                'payer_id' => $user->id,
                'receiver_id' => $receiver->id,
                'amount' => 100
            ]
        );
    }
}
