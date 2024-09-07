<?php

namespace App\Services;

use App\Models\Transaction;
use App\Services\Exceptions\Rent\AlreadyBuyException;
use App\Services\Exceptions\Rent\AlreadyRentedException;
use App\Services\Exceptions\Rent\MaximumRentTimeException;
use App\Services\Exceptions\Rent\ValidatePaginationException;
use Carbon\Carbon;

class RentService
{
    public function checkAlreadyBuy($item)
    {
        if ($item->isAlreadyBuyed()) {
            throw new AlreadyBuyException();
        }
    }

    public function checkAlreadyRented($item)
    {
        if ($item->isAlreadyRented()) {
            throw new AlreadyRentedException();
        }
    }

    public function checkPaginator($paginate){
        if($paginate < 1){
            throw new ValidatePaginationException();
        }
    }

    public function buy($user, $item)
    {
        $this->checkAlreadyBuy($item);

        $this->checkAlreadyRented($item);

        return Transaction::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'type' => 'buy',
            'unique_code' => $this->generateUniqueCode($item),
        ]);
    }

    public function rent($user, $item, $duration)
    {
        $this->checkAlreadyBuy($item);

        $transaction = Transaction::where('item_id', $item->id)
            ->where('type', 'rent')
            ->where('rent_end', '>', Carbon::now())
            ->first();

        if(!is_null($transaction)){

            $date_start = Carbon::parse($transaction->rent_start);
            $date_end = Carbon::parse($transaction->rent_end);
            $hoursDifference = $date_start->diffInHours($date_end);

            if(($hoursDifference + $duration) > 24){
                throw new MaximumRentTimeException();
            }

            $date_end->addHours($duration);
            $transaction->rent_end = $date_end;
            $transaction->save();

            return $transaction;
        }else{
            if($duration > 24){
                throw new MaximumRentTimeException();
            }
            $rentStart = Carbon::now();
            $rentEnd = $rentStart->addHours($duration);

            return Transaction::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'type' => 'rent',
                'rent_start' => $rentStart,
                'rent_end' => $rentEnd,
                'unique_code' => $this->generateUniqueCode($item),
            ]);
        }
    }

    private function generateUniqueCode($item)
    {
        return strtoupper(md5($item->id . time()));
    }

    public function getTransactionHistory($user, $paginate = 0)
    {
        $transactions = Transaction::where('user_id', $user->id)
            ->with('item');

        if($paginate > 0){
            $this->checkPaginator($paginate);

            return $transactions->paginate($paginate, );
        }else{
            return $transactions->get();
        }
    }
}

