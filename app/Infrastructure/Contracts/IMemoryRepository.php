<?php
namespace App\Infrastructure\Contracts;
/**
 * Interface IMemoryStoreRepository
 * @package App\Infrastructure\Contracts
 */
interface IMemoryRepository
{

    public function addItemToList($listKey, $item);

    public function removeItemsFromList($listKey, $items);

    public function getAllListItems($listKey);

    public function addFieldToObject($key, $field, $value);

    public function getFieldValueFromObject($key, $field);

    public function addMultipleItemsToList($listKey, $items);
}
