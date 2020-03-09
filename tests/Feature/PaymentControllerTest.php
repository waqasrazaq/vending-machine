<?php

namespace Tests\Feature;
use App\Infrastructure\Repositories\RedisMemoryRepository;
use Illuminate\Http\JsonResponse;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    protected function setUp():void
    {
        parent::setUp();
    }

    public function testInsertMoney()
    {
        $response = $this->json('post', '/api/payments', ["coin"=>0.05]);
        $response->assertStatus(200);
        $response->assertJsonFragment(["results"=>true]);
    }

    public function testInsertMoneyWithInvalidCoins()
    {
        $response = $this->json('post', '/api/payments', ["coin"=>76]);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([config('common.error_payment_coin_value')]);
    }

    public function testGetAddedMoney()
    {
        $this->json('post', '/api/payments', ["coin"=>0.05]);
        $this->json('post', '/api/payments', ["coin"=>0.05]);
        $this->json('post', '/api/payments', ["coin"=>0.05]);

        $response = $this->json('get', '/api/payments');
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertGreaterThanOrEqual(3, sizeof($response["results"]));
    }

    public static function tearDownAfterClass(): void
    {
        $redis = new RedisMemoryRepository();
        $redis->removeItemsFromList('current_coins', [0.05,0.05,0.05,0.05]);
        parent::tearDownAfterClass();
    }
}
