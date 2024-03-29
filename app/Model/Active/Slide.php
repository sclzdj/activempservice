<?php

namespace App\Model\Active;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'title',
      'pic',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

}
