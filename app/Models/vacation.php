<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vacation extends Model
{
    use HasFactory;


    protected $fillable = [
        'create_date',
        'stating',
        'ending',
        'days',
        'type',
        'state',
        'user_id',
        'comments'
    ];


    public  function user() {
        return $this->belongsTo(User::class);
    }
}

