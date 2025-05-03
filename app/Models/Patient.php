<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'date_of_birth',
        'type',
        'owner_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    protected static ?string $recordNameAttribute = 'name';

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }
}
