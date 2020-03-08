<?php

namespace App\Http\Controllers;

use App\Domain\Entities\VendingMachine;
use App\Http\Requests\AddProductRequest;
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


}
