<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'category',
        'excerpt',
        'description',
        'location',
        'starts_at',
        'ends_at',
        'cover_image',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->where(fn (Builder $query) => $query
                ->whereNull('published_at')
                ->orWhere('published_at', '<=', now()));
    }

    public function scopeUpcomingOrOngoing(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            $query->where('starts_at', '>=', now())
                ->orWhere(fn (Builder $query) => $query
                    ->whereNotNull('ends_at')
                    ->where('ends_at', '>=', now()));
        });
    }

    public function scopeArchivedByDate(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            $query->whereNull('ends_at')->where('starts_at', '<', now())
                ->orWhere(fn (Builder $query) => $query
                    ->whereNotNull('ends_at')
                    ->where('ends_at', '<', now()));
        });
    }

    public function imageUrl(): ?string
    {
        return $this->cover_image
            ? asset('storage/'.$this->cover_image)
            : null;
    }

    public function isUpcomingOrOngoing(): bool
    {
        return ($this->starts_at && $this->starts_at->isFuture())
            || ($this->ends_at && $this->ends_at->isFuture());
    }
}
