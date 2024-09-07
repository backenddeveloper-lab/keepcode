<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'item_id', 'type', 'rent_start', 'rent_end', 'unique_code'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
