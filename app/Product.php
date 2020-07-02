<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use Favoriteable, Sortable;
    public function category()//紐づける先のモデル名で、メソッドを呼び出すことで紐付ける
    {
        return $this->belongsTo('App\Category');//複数あるカテゴリのうち、一つを商品に保存する形beLongsTo
    }
    
    public function reviews()
    {
        return $this->hasMany('App\Review');//1対多の関係性をモデルに追加している。
    }
}