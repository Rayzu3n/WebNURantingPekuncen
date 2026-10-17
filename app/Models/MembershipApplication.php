<?php

namespace App\Models;

use App\Support\NikProtection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipApplication extends Model
{
    protected $fillable = [
        'user_id',
        'registration_number',
        'access_token_hash',
        'nik',
        'birth_place',
        'birth_date',
        'gender',
        'phone',
        'address',
        'photo',
        'status',
        'admin_note',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'nik' => 'encrypted',
            'birth_date' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (MembershipApplication $application): void {
            if ($application->isDirty('nik') && filled($application->nik)) {
                $application->nik_hash = NikProtection::fingerprint($application->nik);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
