<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;

class department extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'title',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function jobTitles(){
        return $this->hasMany(job_title::class, 'departments_id', 'id');
    }


    public function employees(){
        return $this->hasMany(User::class, 'department_id','id');
    }

}
