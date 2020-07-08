<?php

namespace App\Http\Controllers;

use App\User;

// プロダクトモデルを使用できる
use App\Product;
//Authと連携しています
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//index,show,store,create,destroyアクションは削除する
class UserController extends Controller
{
    //mypageアクションを定義
    public function mypage()
    {  //$userにuser自身の情報を格納
        $user = Auth::user();
        //$userを渡して、users.mypageを表示
        return view('users.mypage', compact('user'));
    }
    
    public function edit(User $user)
    {//$userにuser自身の情報を格納
        $user = Auth::user();
    //$user情報を渡してusers.editを表示
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = Auth::user();
//$request->input('name')が、trueだったら、$requesut->input('name')を$user->nameに格納、そうでなければ、そのまま。
        $user->name = $request->input('name') ? $request->input('name') : $user->name;
        $user->email = $request->input('email') ? $request->input('email') : $user->email;
        $user->postal_code = $request->input('postal_code') ? $request->input('postal_code') : $user->postal_code;
        $user->address = $request->input('address') ? $request->input('address') : $user->address;
        $user->phone = $request->input('phone') ? $request->input('phone') : $user->phone;
        $user->update();
//mypageを表示
        return redirect()->route('mypage');
    }
    //住所変更を定義
    public function edit_address()
    {//$userにuser自身を格納
            $user = Auth::user();
            //$userを渡して、usersフォルダのedit_addressを表示
        return view('users.edit_address', compact('user'));
    }
    // パスワード更新
    public function edit_password()
    {
        // edit_passwordをリダイレクト
        return view('users.edit_password');
        }
    //
    public function update_password(Request $request)
    {//ユーザー情報を取得
        $user = Auth::user();
     //インプットされたPWと元からあるPWが一致したら
        if ($request->input('password') == $request->input('confirm_password')) {
            //passwordを暗号化して保存
            $user->password = bcrypt($request->input('password'));
            $user->update();
        } else {
            //一致してなかったら、edit.passwordをリダイレクト
            return redirect()->route('mypage.edit_password');
        }
        // 更新したら、mypageをリダイレクト
        return redirect()->route('mypage');
    }
    // お気に入りメソッド
    public function favorite()
    {
        // ユーザーを格納
        $user = Auth::user();

        // $favoritesにユーザーのお気に入りを格納
        $favorites = $user->favorites(Product::class)->get();

        // お気に入りを変数として渡して、favorite_blade.phpをリダイレクト
        return view('users.favorite', compact('favorites'));
    }
}
