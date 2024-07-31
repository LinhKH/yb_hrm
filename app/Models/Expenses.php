<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $table = 'expenses';
    public $timestamps = false;

    protected $fillable = [
        'item_name',
        'purchase_from',
        'purchase_date',
        'amount',
        'price_bill',
    ];
}
