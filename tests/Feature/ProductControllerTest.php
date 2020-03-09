<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    public function testAddNewProduct()
    {
        $response = $this->json('post', '/api/products', ["item_name"=>"water", "item_price"=>0.65, "item_count"=>10]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJsonFragment(["results"=>true]);
    }

    public function testAddNewProductInvalidItemName()
    {
        $response = $this->json('post', '/api/products', ["item_name"=>234, "item_price"=>0.65, "item_count"=>10]);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([config("common.error_inventory_item_name_string")]);
    }

    public function testAddNewProductInvalidPrice()
    {
        $response = $this->json('post', '/api/products', ["item_name"=>"water", "item_price"=>"ss", "item_count"=>10]);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([config("common.error_inventory_item_price_numeric")]);
    }

    public function testAddNewProductNegativeCount()
    {
        $response = $this->json('post', '/api/products', ["item_name"=>"water", "item_price"=>0.65, "item_count"=>-5]);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([config("common.error_inventory_item_count_numeric")]);
    }

    public function testGetProduct()
    {
        $this->json('post', '/api/changes', ["coins"=>[0.05, 0.1, 0.25, 1]]);
        $this->json('post', '/api/payments', ["coin"=>1]);
        $response = $this->json('get', '/api/products/water');
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertRegexp('/water/', $response["results"]);
    }

}
