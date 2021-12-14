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

    protected $hidden = array('game_id');

    public function game(): BelongsTo
    {
        $this->belongsTo(Game::class);
    }
}
