<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'slide_count',
        'sensitivity',
        'cooldown_ms',
        'status',
    ];

    /**
     * Get the user/presenter that owns this presentation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}