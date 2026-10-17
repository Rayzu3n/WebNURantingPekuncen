<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use App\Support\NikProtection;

/**
 * @property Carbon $birth_date
 */
class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'member_number',
        'nik',
        'nik_hash',
        'birth_place',
        'birth_date',
        'gender',
        'phone',
        'address',
        'photo',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'nik' => 'encrypted',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Member $member): void {
            if ($member->isDirty('nik') && filled($member->nik)) {
                $member->nik_hash = NikProtection::fingerprint($member->nik);
            }
        });
    }

    public static function fingerprint(?string $nik): string
    {
        return NikProtection::fingerprint($nik);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
