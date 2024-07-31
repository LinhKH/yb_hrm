<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'image',
        'name',
        'dob',
        'gender',
        'phone',
        'address',
        'email',
        'branch',
        'department',
        'designation',
        'date_of_joining',
        'joining_salary'
    ];

    
    // get attendances
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
