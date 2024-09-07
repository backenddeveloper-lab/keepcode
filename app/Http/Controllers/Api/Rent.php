<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\RentService;
use App\Models\Item;
use App\Http\Controllers\Controller;

class Rent extends Controller
{
    protected $rentService;

    public function __construct(RentService $rentService)
    {
        $this->rentService = $rentService;
    }

    public function buy(Request $request, Item $item)
    {
        return $this->send(
            $this->rentService->buy($request->user(), $item)
        );
    }

    public function rent(Request $request, Item $item)
    {
        $duration = $request->input('duration', 4);

        return $this->send(
            $this->rentService->rent(
                $request->user(),
                $item,
                $duration
            )
        );
    }


    public function transactionHistory(Request $request)
    {
        return $this->send(
            $this->rentService->getTransactionHistory($request->user(), $request->per_page ?? 1)
        );
    }

    public function itemStatus(Request $request, Item $item)
    {
        return $this->send([
            'item' => $item,
            'buyed' => $item->isAlreadyBuyed(),
            'rented' => $item->isAlreadyRented()
        ]);
    }

}
