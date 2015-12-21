<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GamePlay extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tiger_user_id', 'goat_user_id'];
}
