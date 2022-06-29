<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_carts', function (Blueprint $table) {
            $table->id();
            $table->string('cart_number', 64)->unique();
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade')->onUpdate('cascade');
            $table->string('cvv2', 16);
            $table->timestamp('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_carts');
    }
};
