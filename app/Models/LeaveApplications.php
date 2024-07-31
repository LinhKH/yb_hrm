<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplications extends Model
{
    use HasFactory;

    protected $table = 'leave_applications';

    protected $fillable = [
        'date',
        'leave_type',
        'reason',
        'status',
        'employee_id'
    ];
}
