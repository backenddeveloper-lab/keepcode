<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Item extends Model
{
    protected $fillable = ['name', 'price'];

    public function isAlreadyBuyed()
    {
        return $this->transactions()
            ->where('type', 'buy')
            ->exists();
    }

    public function isAlreadyRented()
    {
        return $this->transactions()
            ->where('type', 'rent')
            ->where('rent_end', '>', Carbon::now())
            ->exists();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
