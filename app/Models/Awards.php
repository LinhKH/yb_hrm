<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Awards extends Model
{
    use HasFactory;

    protected $table = 'awards';

    protected $fillable = [
        'award_name',
        'item',
        'cash_price',
        'month',
        'year',
        'employee_id'
    ];
}
