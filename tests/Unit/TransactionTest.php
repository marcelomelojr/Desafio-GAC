<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function get_all_transactions_returns_empty_list_when_no_transactions_exist(): void
    {
        $response = $this->getJson('/api/transaction/all');

        $response->assertStatus(200);
        $response->assertJson([]);
    }

    public function get_all_transactions_returns_transactions_list(): void
    {
        // Assuming there is a way to seed or mock transactions
        $this->seedTransactions();

        $response = $this->getJson('/api/transaction/all');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'amount',
                'date',
            ]
        ]);
    }

    public function get_all_transactions_returns_error_or_invalid_route(): void
    {
        $response = $this->getJson('/api/transaction/invalid');

        $response->assertStatus(404);
    }

}
