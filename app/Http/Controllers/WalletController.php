<?php

namespace App\Http\Controllers;

use App\Domain\Entities\VendingMachine;
use App\Http\Requests\WalletAddChangeRequest;
use App\Infrastructure\Contracts\IMemoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class WalletController
 * @package App\Http\Controllers
 */
class WalletController extends Controller
{
    private $repo;

    /**
     * WalletController constructor.
     * @param IMemoryRepository $inMemoryRepository
     */
    public function __construct(IMemoryRepository $inMemoryRepository)
    {
        $this->repo = $inMemoryRepository;
    }

    /**
     * @param WalletAddChangeRequest $request
     * @return JsonResponse
     */
    public function addCoinsInAvailableChange(WalletAddChangeRequest $request)
    {
        //All the validation for request parameters is already completed via AddInventoryItemRequest Validator,
        // now we can directly pass these params into the business logic
        $vendingMachine = VendingMachine::createWithRepository($this->repo);
        $output = $vendingMachine->addCoinsToWallet($request->input("coins"));

        return response()->json(array("results"=>$output), $output===true ? JsonResponse::HTTP_OK : JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
