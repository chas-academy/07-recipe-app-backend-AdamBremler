<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class List extends Model
{
    protected $fillable = [
        'name',
        'recipes',
    ];

    protected $casts = [
        'recipes' => 'array',
    ];
}
