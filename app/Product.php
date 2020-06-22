<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()//紐づける先のモデル名で、メソッドを呼び出すことで紐付ける
    {
        return $this->belongsTo('App\Category');//複数あるカテゴリのうち、一つを商品に保存する形beLongsTo
    }
}