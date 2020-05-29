<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    protected $table = 'containers';

    protected $fillable = [
        'name', 'capacity', 'value', 'verified'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
