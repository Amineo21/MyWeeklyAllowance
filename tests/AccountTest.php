<?php

namespace MyWeeklyAllowance\Tests;

use MyWeeklyAllowance\Account;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    private Account $account;

    protected function setUp(): void
    {
        // Arrange: Initialiser un compte avant chaque test
        $this->account = new Account('Alice', 'alice@example.com');
    }

    // ============ TEST CREATION DU COMPTE ============
    
    /**
     * Test 1: Vérifier qu'on peut créer un compte pour un ado
     * @test
     */
    public function test_create_account_with_valid_data(): void
    {
        // Arrange & Act: Le compte est créé dans setUp()
        
        // Assert: Vérifier que les données sont correctes
        $this->assertEquals('Alice', $this->account->getName());
        $this->assertEquals('alice@example.com', $this->account->getEmail());
    }

    /**
     * Test 2: Le solde initial doit être 0
     * @test
     */
    public function test_initial_balance_is_zero(): void
    {
        // Assert
        $this->assertEquals(0.00, $this->account->getBalance());
    }

    // ============ TEST DEPOT D'ARGENT ============
    
    /**
     * Test 3: Vérifier qu'on peut déposer de l'argent
     * @test
     */
    public function test_deposit_money_increases_balance(): void
    {
        // Act: Déposer 50 euros
        $this->account->deposit(50.00);
        
        // Assert: Le solde doit être 50.00
        $this->assertEquals(50.00, $this->account->getBalance());
    }

    /**
     * Test 4: Vérifier que plusieurs dépôts s'additionnent
     * @test
     */
    public function test_multiple_deposits_add_up(): void
    {
        // Act
        $this->account->deposit(30.00);
        $this->account->deposit(20.00);
        $this->account->deposit(15.50);
        
        // Assert
        $this->assertEquals(65.50, $this->account->getBalance());
    }

    /**
     * Test 5: Un dépôt négatif doit lever une exception
     * @test
     */
    public function test_negative_deposit_throws_exception(): void
    {
        // Assert: Vérifier qu'une exception est levée
        $this->expectException(\InvalidArgumentException::class);
        
        // Act: Essayer de déposer un montant négatif
        $this->account->deposit(-10.00);
    }

    /**
     * Test 6: Un dépôt de zéro doit lever une exception
     * @test
     */
    public function test_zero_deposit_throws_exception(): void
    {
        // Assert
        $this->expectException(\InvalidArgumentException::class);
        
        // Act
        $this->account->deposit(0.00);
    }

    // ============ TEST DEPENSE ============
    
    /**
     * Test 7: Vérifier qu'on peut enregistrer une dépense
     * @test
     */
    public function test_withdraw_money_decreases_balance(): void
    {
        // Arrange
        $this->account->deposit(100.00);
        
        // Act: Retirer 30 euros
        $this->account->withdraw(30.00);
        
        // Assert
        $this->assertEquals(70.00, $this->account->getBalance());
    }

    /**
     * Test 8: Vérifier que plusieurs dépenses s'additionnent
     * @test
     */
    public function test_multiple_withdrawals(): void
    {
        // Arrange
        $this->account->deposit(100.00);
        
        // Act
        $this->account->withdraw(20.00);
        $this->account->withdraw(15.50);
        
        // Assert
        $this->assertEquals(64.50, $this->account->getBalance());
    }

    /**
     * Test 9: On ne peut pas retirer plus qu'on a
     * @test
     */
    public function test_cannot_withdraw_more_than_balance(): void
    {
        // Arrange
        $this->account->deposit(50.00);
        
        // Assert
        $this->expectException(\InvalidArgumentException::class);
        
        // Act
        $this->account->withdraw(100.00);
    }

    /**
     * Test 10: Un retrait négatif doit lever une exception
     * @test
     */
    public function test_negative_withdrawal_throws_exception(): void
    {
        // Assert
        $this->expectException(\InvalidArgumentException::class);
        
        // Act
        $this->account->withdraw(-10.00);
    }

    /**
     * Test 11: Un retrait de zéro doit lever une exception
     * @test
     */
    public function test_zero_withdrawal_throws_exception(): void
    {
        // Assert
        $this->expectException(\InvalidArgumentException::class);
        
        // Act
        $this->account->withdraw(0.00);
    }

    // ============ TEST ALLOCATION HEBDOMADAIRE ============
    
    /**
     * Test 12: Vérifier qu'on peut définir une allocation hebdomadaire
     * @test
     */
    public function test_set_weekly_allowance(): void
    {
        // Act
        $this->account->setWeeklyAllowance(10.00);
        
        // Assert
        $this->assertEquals(10.00, $this->account->getWeeklyAllowance());
    }

    /**
     * Test 13: Une allocation négative doit lever une exception
     * @test
     */
    public function test_negative_allowance_throws_exception(): void
    {
        // Assert
        $this->expectException(\InvalidArgumentException::class);
        
        // Act
        $this->account->setWeeklyAllowance(-5.00);
    }

    /**
     * Test 14: On peut recevoir l'allocation hebdomadaire
     * @test
     */
    public function test_receive_weekly_allowance(): void
    {
        // Arrange
        $this->account->setWeeklyAllowance(15.00);
        
        // Act
        $this->account->receiveWeeklyAllowance();
        
        // Assert
        $this->assertEquals(15.00, $this->account->getBalance());
    }

    /**
     * Test 15: Recevoir l'allocation plusieurs fois l'ajoute au solde
     * @test
     */
    public function test_receive_multiple_weekly_allowances(): void
    {
        // Arrange
        $this->account->setWeeklyAllowance(20.00);
        
        // Act
        $this->account->receiveWeeklyAllowance();
        $this->account->receiveWeeklyAllowance();
        $this->account->receiveWeeklyAllowance();
        
        // Assert
        $this->assertEquals(60.00, $this->account->getBalance());
    }

    // ============ TEST HISTORIQUE ============
    
    /**
     * Test 16: L'historique enregistre les transactions
     * @test
     */
    public function test_transaction_history_records_deposits(): void
    {
        // Act
        $this->account->deposit(50.00);
        $this->account->deposit(30.00);
        
        // Assert
        $history = $this->account->getTransactionHistory();
        $this->assertCount(2, $history);
        $this->assertEquals('deposit', $history[0]['type']);
        $this->assertEquals(50.00, $history[0]['amount']);
    }

    /**
     * Test 17: L'historique enregistre les retraits
     * @test
     */
    public function test_transaction_history_records_withdrawals(): void
    {
        // Arrange
        $this->account->deposit(100.00);
        
        // Act
        $this->account->withdraw(25.00);
        $this->account->withdraw(15.00);
        
        // Assert
        $history = $this->account->getTransactionHistory();
        $this->assertCount(3, $history);
        $this->assertEquals('withdrawal', $history[1]['type']);
        $this->assertEquals(25.00, $history[1]['amount']);
    }

    /**
     * Test 18: L'historique enregistre les allocations reçues
     * @test
     */
    public function test_transaction_history_records_allowances(): void
    {
        // Arrange
        $this->account->setWeeklyAllowance(10.00);
        
        // Act
        $this->account->receiveWeeklyAllowance();
        $this->account->receiveWeeklyAllowance();
        
        // Assert
        $history = $this->account->getTransactionHistory();
        $this->assertCount(2, $history);
        $this->assertEquals('allowance', $history[0]['type']);
        $this->assertEquals(10.00, $history[0]['amount']);
    }

    /**
     * Test 19: Chaque transaction a une date
     * @test
     */
    public function test_transaction_history_includes_timestamp(): void
    {
        // Act
        $this->account->deposit(50.00);
        
        // Assert
        $history = $this->account->getTransactionHistory();
        $this->assertArrayHasKey('timestamp', $history[0]);
        $this->assertNotEmpty($history[0]['timestamp']);
    }
}
