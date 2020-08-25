<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class photo extends Model
{
    protected $table = 'photo';
    public $timestamps = false;
     protected $fillable = [
            'user_id','photo',
        ];

}
