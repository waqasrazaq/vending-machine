<?php
namespace App\Infrastructure\Repositories;

use App\Infrastructure\Contracts\IMemoryRepository;
use Illuminate\Support\Facades\Redis;
use Exception;

/**
 * Class RedisMemoryRepository
 * @package App\Infrastructure\Repositories
 */
class RedisMemoryRepository implements IMemoryRepository
{
    /**
     * @param $listKey
     * @param $item
     * @return bool
     */
    public function addItemToList($listKey, $item)
    {
        try {
            Redis::lPush($listKey, $item);
        } catch (Exception $e) {
            return false;
        }
        return true;

    }

    /**
     * @param $listKey
     * @param $item
     * @return bool
     */
    public function removeItemFromList($listKey, $item)
    {
        try {
            Redis::lPush($listKey, $item);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @param $listKey
     * @return bool
     */
    public function getAllListItems($listKey) {
        try {
            return Redis::lRange($listKey, 0, -1);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $key
     * @param $field
     * @param $value
     * @return bool|mixed
     */
    public function addFieldToObject($key, $field, $value)
    {
        try {
            Redis::hSet($key, $field, $value);
        } catch(Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @param $key
     * @param $field
     * @return mixed|null
     */
    public function getFieldValueFromObject($key, $field)
    {
        try {
            return Redis::hGet($key, $field);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param $listKey
     * @param $items
     * @return bool
     */
    public function addMultipleItemsToList($listKey, $items)
    {
        try {
            for($i=0; $i<sizeof($items); $i++) {
                Redis::lPush($listKey, $items[$i]);
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}
