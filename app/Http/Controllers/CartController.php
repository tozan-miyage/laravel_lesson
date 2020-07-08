<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// カート機能を使えるようにした
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
// 直接データベースからデータを取得
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Cartクラスのユーザー内容を格納
        $cart = Cart::instance(Auth::user()->id)->content();
        // 初期化
        $total = 0;

        foreach ($cart as $c) {
            // totalにカートの数量と値段をかけた金額を格納
            $total += $c->qty * $c->price;
        }

        return view('carts.index', compact('cart', 'total'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ユーザーIDを元にデータを作成
        Cart::instance(Auth::user()->id)->add(//追加
            [
                'id' => $request->_token, 
                'name' => $request->name, 
                'qty' => $request->qty, 
                'price' => $request->price, 
                'weight' => $request->weight, 
            ] 
        );

        return redirect()->route('products.show', $request->get('id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // ショッピングカートのデータを取得
        $cart = DB::table('shoppingcart')->where('instance', Auth::user()->id)->where('identifier', $count)->get();

        return view('carts.show', compact('cart'));
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {//deleteがリクエストされたら
        if ($request->input('delete')) {
            //instanceを削除してね（リクエストされたIDを元に、削除・追加を行う
            Cart::instance(Auth::user()->id)->remove($request->input('id'));
        } else {
            Cart::instance(Auth::user()->id)->update($request->input('id'), $request->input('qty'));
        }

        return redirect()->route('carts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Request $request)
    {
        // shoppingcartテーブルから取得したユーザーインスタンスを格納
        $user_shoppingcarts = DB::table('shoppingcart')->where('instance', Auth::user()->id)->get();
        //$user_shoppingcartsの数量を格納
        $count = $user_shoppingcarts->count();
        // 追加
        $count += 1;
        // 商品情報をデータベースに保存
        Cart::instance(Auth::user()->id)->store;
        // データ更新　shoppingcartの
        DB::table('shoppingcart')->where('instance', Auth::user()->id)->where('number', null)->update(['number' => $count, 'buy_flag' => true]);

        Cart::instance(Auth::user()->id)->destroy();

        return redirect()->route('carts.index');
    }
}
