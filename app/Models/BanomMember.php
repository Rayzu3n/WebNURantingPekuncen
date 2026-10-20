<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BanomMember extends Model
{
    protected $fillable = ['position', 'name', 'sort_order'];

    protected function casts(): array
    {
        return ['sort_order' => 'integer'];
    }

    public function banom(): BelongsTo
    {
        return $this->belongsTo(Banom::class);
    }
}
