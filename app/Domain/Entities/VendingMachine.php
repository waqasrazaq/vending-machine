<?php

namespace App\Domain\Entities;

use App\Infrastructure\Contracts\IMemoryRepository;

/**
 * Class VendingMachine
 * @package App\Domain\Entities
 */
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
        return $this->inMemoryStore->addItemToList('current_coins', $money);
    }

    /**
     * @return mixed
     */
    public function getAddedMoney()
    {
        return $this->inMemoryStore->getAllListItems("current_coins");
    }

    /**
     * @param $item_name
     * @param $price
     * @param $count
     * @return bool
     */
    public function addProductToInventory($item_name, $price, $count)
    {
        $item_price_output = $this->inMemoryStore->addFieldToObject("items_".$item_name, "item_price", $price);
        $item_count_output = $this->inMemoryStore->addFieldToObject("items_".$item_name, "item_count", $count);

        return $item_price_output && $item_count_output;
    }

    /**
     * @param $coins
     * @return mixed
     */
    public function addCoinsToWallet($coins)
    {
        return $this->inMemoryStore->addMultipleItemsToList('available_change', $coins);
    }

    /**
     * @param $productName
     * @return string
     */
    public function getProduct($productName)
    {
        $productCount = $this->inMemoryStore->getFieldValueFromObject("items"."_".$productName, "item_count");
        $productPrice = $this->inMemoryStore->getFieldValueFromObject("items"."_".$productName, "item_price");
        $insertedCoins = $this->getAddedMoney();
        $totalInsertedAmount = array_sum($insertedCoins);

        if ($totalInsertedAmount>0 && $productCount!=false && $productCount>0) {
            if ($totalInsertedAmount==$productPrice) { // Where inserted amount is exactly equal to the product price
                $this->inMemoryStore->addFieldToObject("items"."_".$productName, "item_count", $productCount-1);
                $this->inMemoryStore->removeItemsFromList("current_coins", $insertedCoins);
                return $productName;
            } else if ($totalInsertedAmount>$productPrice)  {
                $amountToReturn = $totalInsertedAmount-$productPrice;
                $availableChange = $this->inMemoryStore->getAllListItems('available_change');
                $changeToReturn = $this->calculateChange(array_merge($insertedCoins, $availableChange), $amountToReturn, 0);
                if ($changeToReturn!=null && sizeof($changeToReturn)>0) {
                    $this->inMemoryStore->addFieldToObject("items"."_".$productName, "item_count", $productCount-1);
                    $this->inMemoryStore->addMultipleItemsToList("available_change", $insertedCoins);
                    $this->inMemoryStore->removeItemsFromList("available_change", $changeToReturn);
                    $this->inMemoryStore->removeItemsFromList("current_coins", $insertedCoins);
                    return implode(", ", $changeToReturn).", ".$productName;
                } else  {
                    return config('common.error_not_enough_change');
                }
            } else {
                return config('common.error_not_enough_amount');
            }
        } else {
            return config('common.error_not_enough_amount_inventory');
        }
    }

    /**
     * @param $coins
     * @param $change
     * @param $start
     * @return array|null
     */
    private function calculateChange($coins, $change, $start)
    {
        for ($i= $start; $i < sizeof($coins); $i++) {
            $coin = $coins[$i];
            if ($coin <= 0 || $coin > $change) continue;;

            $remainder = fmod($change, $coin);
            if ($remainder >= $change) continue;

            $matches = [$coin];
            $changeLeft = $change - $coin;
            $changeLeft=round($changeLeft, 2);

            if ($changeLeft==0) return $matches;

            $subCalc = $this->calculateChange($coins, $changeLeft, $i + 1);
            if ($subCalc == null) continue;
            $matches = array_merge($matches, $subCalc);
            return $matches;
        }
        return null;
    }

}
