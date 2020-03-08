<?php

namespace App\Http\Controllers;

use App\Domain\Entities\VendingMachine;
use App\Http\Requests\AddInventoryItemRequest;
use App\Infrastructure\Contracts\IMemoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    private $repo;
    public function __construct(IMemoryRepository $inMemoryRepository)
    {
        $this->repo = $inMemoryRepository;
    }

    public function addNewItem(AddInventoryItemRequest $request)
    {
        //All the validation for request parameters is already completed via AddInventoryItemRequest Validator,
        // now we can directly pass these params into the business logic
        $vendingMachine = VendingMachine::createWithRepository($this->repo);
        $output = $vendingMachine->addItemToInventory($request->input("item_name"), $request->input("item_price"), $request->input("item_count"));

        return response()->json(array("results"=>$output), $output===true ? JsonResponse::HTTP_OK : JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
