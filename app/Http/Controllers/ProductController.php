<?php

namespace App\Http\Controllers;

use App\Domain\Entities\VendingMachine;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\GetProductRequest;
use App\Infrastructure\Contracts\IMemoryRepository;
use Illuminate\Http\JsonResponse;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    private $repo;

    /**
     * ProductController constructor.
     * @param IMemoryRepository $inMemoryRepository
     */
    public function __construct(IMemoryRepository $inMemoryRepository)
    {
        $this->repo = $inMemoryRepository;
    }

    /**
     * @param AddProductRequest $request
     * @return JsonResponse
     */
    public function addNewProduct(AddProductRequest $request)
    {
        //All the validation for request parameters is already completed via AddInventoryItemRequest Validator,
        // now we can directly pass these params into the business logic
        $vendingMachine = VendingMachine::createWithRepository($this->repo);
        $output = $vendingMachine->addProductToInventory($request->input("item_name"), $request->input("item_price"), $request->input("item_count"));
        return response()->json(array("results"=>$output), $output===true ? JsonResponse::HTTP_OK : JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param $name
     * @return JsonResponse
     */
    public function getProduct($name)
    {
        $vendingMachine = VendingMachine::createWithRepository($this->repo);
        $output = $vendingMachine->getProduct($name);

        return response()->json(array("results"=>$output),JsonResponse::HTTP_OK);
    }
}
