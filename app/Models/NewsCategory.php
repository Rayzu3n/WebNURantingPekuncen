<?php

namespace App\Models;

use Database\Factories\NewCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsCategory extends Model
{
    /** @use HasFactory<\Database\Factories\NewCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'category_id');
    }
}
