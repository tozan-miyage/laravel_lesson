<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function products(){// 紐づける先のモデル名でメソッドを作成する
        return $this->hasMany('App\Product');//Categoryモデルから商品を引っ張ってくる
    }
}
