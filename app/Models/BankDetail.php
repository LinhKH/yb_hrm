<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;

    protected $table = 'bank_detail';
    protected $primaryKey = 'bank_id';

    protected $fillable = [
        'employee_id',
        'acc_name',
        'acc_no',
        'bank_name',
        'ifsc_code',
        'branch_location',
        'pan_number'
    ];
}
