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

    /**
     * @param IMemoryRepository $inMemoryStore
     * @return VendingMachine
     */
    public static function createWithRepository(IMemoryRepository $inMemoryStore)
    {
        $vendingMachine =  new VendingMachine();
        $vendingMachine->inMemoryStore = $inMemoryStore;
        return $vendingMachine;
    }

    /**
     * @param $money
     * @return mixed
     */
    public function insertMoney($money)
    {
        return $this->inMemoryStore->addItemToList(config('common.inserted_coins_key'), $money);
    }

    /**
     * @return mixed
     */
    public function getAddedMoney()
    {
        return $this->inMemoryStore->getAllListItems(config('common.inserted_coins_key'));
    }

    /**
     * @param $item_name
     * @param $price
     * @param $count
     * @return bool
     */
    public function addItemToInventory($item_name, $price, $count)
    {
        $item_price_output = $this->inMemoryStore->addFieldToObject(config('common.available_items')."_".$item_name, "item_price", $price);
        $item_count_output = $this->inMemoryStore->addFieldToObject(config('common.available_items')."_".$item_name, "item_count", $count);

        return $item_price_output && $item_count_output;
    }
}
