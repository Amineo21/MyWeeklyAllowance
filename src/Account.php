<?php

/**
 * MyWeeklyAllowance - Classe de Gestion de Compte
 * 
 * Cette classe gère un portefeuille virtuel pour les adolescents.
 * Les parents peuvent déposer de l'argent, enregistrer des dépenses et fixer des allocations hebdomadaires.
 * 
 * @package MyWeeklyAllowance
 * @author Ahmed
 * @version 1.0.0
 */

namespace MyWeeklyAllowance;

/**
 * Classe Account
 * 
 * Représente le compte de portefeuille virtuel d'un adolescent avec suivi des transactions.
 * 
 * @package MyWeeklyAllowance
 */
class Account
{
    private string $name;
    private string $email;
    private float $balance = 0.00;
    private float $weeklyAllowance = 0.00;
    private array $transactionHistory = [];

    // ============ CONSTRUCTEUR ============
    
    /**
     * Construit un nouveau compte
     * 
     * @param string $name Le nom de l'adolescent
     * @param string $email L'adresse email de l'adolescent
     */
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    // ============ ACCESSEURS ============
    
    /**
     * Récupère le nom du titulaire du compte
     * 
     * @return string Le nom
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Récupère l'email du titulaire du compte
     * 
     * @return string L'adresse email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Récupère le solde actuel du compte
     * 
     * @return float Le solde actuel
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * Récupère le montant de l'allocation hebdomadaire
     * 
     * @return float L'allocation hebdomadaire
     */
    public function getWeeklyAllowance(): float
    {
        return $this->weeklyAllowance;
    }

    /**
     * Récupère l'historique des transactions
     * 
     * @return array Tableau de toutes les transactions avec type, montant et horodatage
     */
    public function getTransactionHistory(): array
    {
        return $this->transactionHistory;
    }

    // ============ DEPOT D'ARGENT ============
    
    /**
     * Dépose de l'argent sur le compte
     * 
     * @param float $amount Le montant à déposer
     * @throws \InvalidArgumentException Si le montant est négatif ou nul
     * @return void
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
     * Retire de l'argent du compte
     * 
     * @param float $amount Le montant à retirer
     * @throws \InvalidArgumentException Si le montant est négatif, nul ou dépasse le solde
     * @return void
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
     * Définit le montant de l'allocation hebdomadaire
     * 
     * @param float $amount Le montant de l'allocation hebdomadaire
     * @throws \InvalidArgumentException Si le montant est négatif
     * @return void
     */
    public function setWeeklyAllowance(float $amount): void
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('L\'allocation hebdomadaire ne peut pas être négative');
        }

        $this->weeklyAllowance = $amount;
    }

    /**
     * Reçoit l'allocation hebdomadaire (l'ajoute au solde)
     * 
     * @return void
     */
    public function receiveWeeklyAllowance(): void
    {
        $this->balance += $this->weeklyAllowance;
        $this->recordTransaction('allowance', $this->weeklyAllowance);
    }

    // ============ HISTORIQUE DES TRANSACTIONS ============
    
    /**
     * Enregistre une transaction dans l'historique
     * 
     * @param string $type Le type de transaction (dépôt, retrait, allocation)
     * @param float $amount Le montant de la transaction
     * @return void
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
