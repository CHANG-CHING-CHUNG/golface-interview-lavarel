<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    protected $fillable = [
        'player',
        'value',
    ];

    protected $casts = [
        'value' => 'integer',
    ];

    public function game(): BelongsTo
    {
        $this->belongsTo(Game::class);
    }
}
