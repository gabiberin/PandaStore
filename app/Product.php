<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'product_categories');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
}
