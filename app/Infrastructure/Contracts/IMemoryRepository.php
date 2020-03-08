<?php
namespace App\Infrastructure\Contracts;
/**
 * Interface IMemoryStoreRepository
 * @package App\Infrastructure\Contracts
 */
interface IMemoryRepository
{
    /**
     * @param $listKey
     * @param $item
     * @return mixed
     */
    public function addItemToList($listKey, $item);

    /**
     * @param $listKey
     * @param $item
     * @return mixed
     */
    public function removeItemFromList($listKey, $item);

    /**
     * @param $listKey
     * @return mixed
     */
    public function getAllListItems($listKey);

    /**
     * @param $key
     * @param $field
     * @param $value
     * @return mixed
     */
    public function addFieldToObject($key, $field, $value);

    /**
     * @param $key
     * @param $field
     * @return mixed
     */
    public function getFieldValueFromObject($key, $field);
}
