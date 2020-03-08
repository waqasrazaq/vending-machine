<?php

namespace App\Domain\Entities;

use App\Infrastructure\Contracts\IMemoryRepository;
use App\Infrastructure\Repositories\RedisMemoryRepository;

class VendingMachine
{
    private  $inMemoryStore;
    private function __construct()
    {
    }

    public static function createWithRepository(IMemoryRepository $inMemoryStore)
    {
        $vendingMachine =  new VendingMachine();
        $vendingMachine->inMemoryStore = $inMemoryStore;
        return $vendingMachine;
    }

    public function insertMoney($money) {
        return $this->inMemoryStore->addItemToList(config('common.inserted_coins_key'), $money);
    }

    public function getAddedMoney()
    {
        return $this->inMemoryStore->getAllListItems(config('common.inserted_coins_key'));
    }
}
