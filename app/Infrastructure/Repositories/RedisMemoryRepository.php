<?php
namespace App\Infrastructure\Repositories;

use App\Infrastructure\Contracts\IMemoryRepository;
use Illuminate\Support\Facades\Redis;

/**
 * Class RedisMemoryRepository
 * @package App\Infrastructure\Repositories
 */
class RedisMemoryRepository implements IMemoryRepository
{
    /**
     * @param $listKey
     * @param $item
     * @return mixed|void
     */
    public function addItemToList($listKey, $item)
    {
        Redis::lPush($listKey, $item);
    }

    /**
     * @param $listKey
     * @param $item
     * @return mixed|void
     */
    public function removeItemFromList($listKey, $item)
    {
        Redis::lPush($listKey, $item);
    }

    /**
     * @param $listKey
     * @return mixed
     */
    public function getAllListItems($listKey) {
        return Redis::lRange($listKey, 0, -1);
    }

    /**
     * @param $key
     * @param $field
     * @param $value
     * @return mixed|void
     */
    public function addFieldToObject($key, $field, $value)
    {
        Redis::hSet($key, $field, $value);
    }

    /**
     * @param $key
     * @param $field
     * @return mixed
     */
    public function getFieldValueFromObject($key, $field) {
        return Redis::hGet($key, $field);
    }
}
