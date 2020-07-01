<?php

namespace App\Http\Controllers;

use App\Review;
use App\Product;//ここで、Productモデルが使用できるようにする。
use Illuminate\Support\Facades\Auth;//現在レビューしているユーザー情報をここで取り扱う
use Illuminate\Http\Request;

class ReviewController extends Controller//レビュー投稿のみなので、storeアクション以外は削除
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product, Request $request)//商品のデータを、$product変数で受け取る。
    {
        $review = new Review();//新しいレビューデータを作成
        $review->content = $request->input('content');//requestの内容を各カラムに保存
        $review->product_id = $product->id;
        $review->user_id = Auth::user()->id;
        $review->save();
        
        return redirect()->route('products.show', $product);
    }
}
