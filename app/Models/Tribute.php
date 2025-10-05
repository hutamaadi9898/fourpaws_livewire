<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Tribute extends Model
{
    /** @use HasFactory<\Database\Factories\TributeFactory> */
    use HasFactory;

    protected $guarded = [];

    public $incrementing = false;

    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function markApproved(?string $moderator = null): void
    {
        $this->forceFill([
            'status' => 'approved',
            'approved_at' => Carbon::now(),
            'published_at' => Carbon::now(),
            'moderated_by' => $moderator,
            'rejected_at' => null,
        ])->save();
    }

    public function markRejected(?string $moderator = null): void
    {
        $this->forceFill([
            'status' => 'rejected',
            'rejected_at' => Carbon::now(),
            'moderated_by' => $moderator,
            'approved_at' => null,
            'published_at' => null,
        ])->save();
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
