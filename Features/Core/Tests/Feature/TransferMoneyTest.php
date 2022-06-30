<?php

namespace Features\Core\Tests\Feature;

use Features\Core\Events\TransactionCompletedEvent;
use Features\Core\Models\Account;
use Features\Core\Models\CreditCart;
use Features\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TransferMoneyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_transfer_money_with_correct_information()
    {
        $this->withoutExceptionHandling();
        $amount = 500_000;

        $phone_number1 = '09145687353';
        $cart_number1 = '6037997557708709';
        $balance1 = 1_000_000;

        $phone_number2 = '09145687354';
        $cart_number2 = '6104337613803152';
        $balance2 = 5_000_000;

        [$user1, $user1Account, $user1Cart] = $this->createUserWithAccountAndCreditCart($phone_number1, $cart_number1, $balance1);
        [$user2, $user2Account, $user2Cart] = $this->createUserWithAccountAndCreditCart($phone_number2, $cart_number2, $balance2);


        $this
            ->actingAs($user1)
            ->postJson(route('v1.transfer_money'), [
                'sender_cart_number' => '6037997557708709',
                'recipient_cart_number' => '6104337613803152',
                'amount' => $amount
            ])
            ->assertOk();

        $user1Account->refresh();
        $user2Account->refresh();
        $user1Cart->refresh();

        // check balance to be correct
        $this->assertEquals($balance1 - $amount, $user1Account->balance);
        $this->assertEquals($balance2 + $amount, $user2Account->balance);

        // check transaction and wage part
        $this->assertDatabaseHas('transactions', [
            'cart_id' => $user1Cart->id,
            'amount' => $amount,
            'status' => true
        ]);
        $user1Transaction = $user1Cart->transactions()->first();
        $this->assertDatabaseHas('wages', [
            'amount' => config('core.transaction_wage'),
            'transaction_id' => $user1Transaction->id
        ]);
    }

    public function test_user_cannot_transfer_money_with_incorrect_sender_information()
    {
        $amount = 500_000;

        $phone_number1 = '09145687353';
        $cart_number1 = '6037997557708709';
        $balance1 = 1_000_000;

        [$user1, $user1Account, $user1Cart] = $this->createUserWithAccountAndCreditCart($phone_number1, $cart_number1, $balance1);


        $this
            ->actingAs($user1)
            ->postJson(route('v1.transfer_money'), [
                'sender_cart_number' => '6037997557708712',
                'recipient_cart_number' => '6104337613803152',
                'amount' => $amount
            ])
            ->assertJsonValidationErrorFor('sender_cart_number');
    }

    public function test_user_cannot_transfer_money_with_incorrect_recevier_information()
    {
        $amount = 500_000;

        $phone_number1 = '09145687353';
        $cart_number1 = '6037997557708709';
        $balance1 = 1_000_000;

        [$user1, $user1Account, $user1Cart] = $this->createUserWithAccountAndCreditCart($phone_number1, $cart_number1, $balance1);


        $this
            ->actingAs($user1)
            ->postJson(route('v1.transfer_money'), [
                'sender_cart_number' => '6037997557708709',
                'recipient_cart_number' => '61043376138031000',
                'amount' => $amount
            ])
            ->assertJsonValidationErrorFor('recipient_cart_number');
    }

    public function test_user_cannot_transfer_money_with_incorrect_amount_information()
    {
        $phone_number1 = '09145687353';
        $cart_number1 = '6037997557708709';
        $balance1 = 1_000_000;

        [$user1, $user1Account, $user1Cart] = $this->createUserWithAccountAndCreditCart($phone_number1, $cart_number1, $balance1);


        $this
            ->actingAs($user1)
            ->postJson(route('v1.transfer_money'), [
                'sender_cart_number' => '6037997557708709',
                'recipient_cart_number' => '6104337613803152',
                'amount' => 50
            ])
            ->assertJsonValidationErrorFor('amount');

        $this
            ->actingAs($user1)
            ->postJson(route('v1.transfer_money'), [
                'sender_cart_number' => '6037997557708709',
                'recipient_cart_number' => '6104337613803152',
                'amount' => 50_000_001
            ])
            ->assertJsonValidationErrorFor('amount');
    }


    private function createUserWithAccountAndCreditCart(string $phone, string $cart_number, int $balance): array
    {
        $user = User::factory()
            ->createOne([
                'phone_number' => $phone
            ]);
        $userAccount = Account::factory()
            ->createOne([
                'balance' => $balance,
                'user_id' => $user->id
            ]);

        Account::factory()
            ->has(CreditCart::factory()->count(4), 'credit_carts')
            ->count(2)
            ->create([
                'user_id' => $user->id
            ]);

        $userCart = CreditCart::factory()
            ->createOne([
                'cart_number' => $cart_number,
                'account_id' => $userAccount->id
            ]);

        CreditCart::factory()
            ->count(5)
            ->create([
                'account_id' => $userAccount->id
            ]);

        return [$user, $userAccount, $userCart];
    }
}
