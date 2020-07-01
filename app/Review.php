<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function product()//紐づける先のモデル名で呼び出せる
{
    return $this->belongsTo('App\Product');//商品との関連性を
}

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
