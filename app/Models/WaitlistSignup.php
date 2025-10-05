<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class WaitlistSignup extends Model
{
    /** @use HasFactory<\Database\Factories\WaitlistSignupFactory> */
    use HasFactory;

    protected $guarded = [];

    public $incrementing = false;

    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'confirmed_at' => 'datetime',
        ];
    }

    public function confirm(): void
    {
        $this->forceFill([
            'confirmed_at' => Carbon::now(),
        ])->save();
    }
}
