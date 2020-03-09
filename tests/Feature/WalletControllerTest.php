<?php

namespace Tests\Feature;

use App\Infrastructure\Repositories\RedisMemoryRepository;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class WalletControllerTest extends TestCase
{
    public function testAddCoinsInAvailableChange()
    {
        $response = $this->json('post', '/api/changes', ["coins"=>[0.05, 0.1, 0.25, 1]]);
        $response->assertStatus(200);
        $response->assertJsonFragment(["results"=>true]);
    }

    public function testAddCoinsInAvailableChangeInvalidType()
    {
        $response = $this->json('post', '/api/changes', ["coins"=>'0.1']);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([config('common.error_wallet_coins_list')]);
    }

    public static function tearDownAfterClass(): void
    {
        $redis = new RedisMemoryRepository();
        $redis->removeItemsFromList('available_change', [0.05, 0.1, 0.25, 1]);
        parent::tearDownAfterClass();
    }
}
