<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use HasFactory;

    protected $table = 'notice_board';

    protected $fillable = [
        'title',
        'description',
        'status',
    ];
}
