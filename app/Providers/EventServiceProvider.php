<?php

namespace App\Providers;

use App\Events\Registered;
use App\Listeners\CreateUserRegisteredWallet;
use App\Models\Transaction;
use App\Models\User;
use App\Observers\TransactionObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            CreateUserRegisteredWallet::class
        ]


    ];

    protected $observers = [
        User::class => UserObserver::class,
        Transaction::class => TransactionObserver::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
