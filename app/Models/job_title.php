<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class job_title extends Model
{
    use HasFactory;
    protected $fillable = [
        'departments_id',
        'title',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function users(): HasMany {
        return $this->hasMany(User::class, 'job_titles_id');
    }
}
