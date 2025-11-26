<?php

namespace MyWeeklyAllowance;

class Account
{
    private string $name;
    private string $email;
    private float $balance = 0.00;
    private float $weeklyAllowance = 0.00;
    private array $transactionHistory = [];

    // ============ CONSTRUCTEUR ============
    
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    // ============ GETTERS ============
    
    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getWeeklyAllowance(): float
    {
        return $this->weeklyAllowance;
    }

    public function getTransactionHistory(): array
    {
        return $this->transactionHistory;
    }

    // ============ DEPOT D'ARGENT ============
    
    /**
     * Déposer de l'argent sur le compte
     * 
     * @param float $amount Le montant à déposer
     * @throws InvalidArgumentException Si le montant est négatif ou zéro
     */
    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Le montant du dépôt doit être positif');
        }

        $this->balance += $amount;
        $this->recordTransaction('deposit', $amount);
    }

    // ============ RETRAIT/DEPENSE ============
    
    /**
     * Retirer de l'argent du compte
     * 
     * @param float $amount Le montant à retirer
     * @throws InvalidArgumentException Si le montant est négatif, zéro ou supérieur au solde
     */
    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Le montant du retrait doit être positif');
        }

        if ($amount > $this->balance) {
            throw new \InvalidArgumentException('Solde insuffisant pour cette transaction');
        }

        $this->balance -= $amount;
        $this->recordTransaction('withdrawal', $amount);
    }

    // ============ ALLOCATION HEBDOMADAIRE ============
    
    /**
     * Définir l'allocation hebdomadaire
     * 
     * @param float $amount Le montant de l'allocation
     * @throws InvalidArgumentException Si le montant est négatif
     */
    public function setWeeklyAllowance(float $amount): void
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('L\'allocation hebdomadaire ne peut pas être négative');
        }

        $this->weeklyAllowance = $amount;
    }

    /**
     * Recevoir l'allocation hebdomadaire
     */
    public function receiveWeeklyAllowance(): void
    {
        $this->balance += $this->weeklyAllowance;
        $this->recordTransaction('allowance', $this->weeklyAllowance);
    }

    // ============ HISTORIQUE DES TRANSACTIONS ============
    
    /**
     * Enregistrer une transaction dans l'historique
     * 
     * @param string $type Le type de transaction (deposit, withdrawal, allowance)
     * @param float $amount Le montant de la transaction
     */
    private function recordTransaction(string $type, float $amount): void
    {
        $this->transactionHistory[] = [
            'type' => $type,
            'amount' => $amount,
            'timestamp' => date('Y-m-d H:i:s'),
        ];
    }
}
