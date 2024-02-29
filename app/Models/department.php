<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class department extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    protected $hidden = [

        'created_at',
        'updated_at',
    ];


// Department has many Users
public function users(): HasMany {
    // This will use 'department_id' in the 'users' table to find related users
    return $this->hasMany(User::class, 'department_id');
}

}
