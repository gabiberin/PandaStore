<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function country() {
        return $this->belongsTo('App\Country', 'country_code', 'code');
    }

    public function orders() {
        return $this->hasMany('App\Order', 'user_id', 'user_id');
    }
}
