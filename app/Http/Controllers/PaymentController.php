<?php

namespace App\Http\Controllers;

use App\Domain\Entities\VendingMachine;
use App\Http\Requests\InsertMoneyRequest;
use App\Infrastructure\Contracts\IMemoryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class PaymentController extends Controller
{
    private $repo;
    public function __construct(IMemoryRepository $inMemoryRepository)
    {
        $this->repo = $inMemoryRepository;
    }

    /**
     * @param InsertMoneyRequest $request
     * @return JsonResponse
     */
    public function insertMoney(InsertMoneyRequest $request) {
        $coin = $request->input("coin");
        $vendingMachine = VendingMachine::createWithRepository($this->repo);
        $output = $vendingMachine->insertMoney($coin);

        return response()->json(array("results"=>$output), $output===true ? JsonResponse::HTTP_OK : JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAddedMoney(Request $request)
    {
        $vendingMachine = VendingMachine::createWithRepository($this->repo);
        $output = $vendingMachine->getAddedMoney();

        return response()->json(array("results"=>$output), $output===false ? JsonResponse::HTTP_INTERNAL_SERVER_ERROR : JsonResponse::HTTP_OK);
    }
}
