<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('payer_id');
            $table->uuid('receiver_id');
            $table->integer('amount');
            $table->dateTime('transaction_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
