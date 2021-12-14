<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = [
        'title',
        'startAt',
    ];

    // protected $casts = [
    //     'startAt' => 'integer',
    // ];

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
