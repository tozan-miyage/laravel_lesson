<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)//作成された全ての商品を表示
    {
        $sort_query = [];
        $sorted = "";
        
        if ($request->sort !== null){
            $slices = explode(' ', $request->sort);
            $sort_query[$slices[0]] = $slices[1];
            $sorted = $request->sort;
        }
        //$products = Product::all();全ての商品データをデータベースから取得し$productsに格納
        if ($request->category !== null){
            $products = Product::where('category_id',$request->category)->sortable($sort_query)->paginate(15);
            $category = Category::find($request->category);
        }else{
            $products = Product::sortable($sort_query)->paginate(15);
            $category = null;
        }//ページネーション
        
        $sort = [
            '並び替え' => '',
            '価格の安い順' => 'price asc',
            '価格の高い順' => 'price desc',
            '出品の古い順' => 'updated_at asc',
            '出品の新しい順' => 'updated_at desc',
            ];
        
        $categories = Category::all();//変数に全カテゴリーを代入
        
        $major_category_names = Category::pluck('major_category_name')->unique();//重複部分は取り除くunique()
        
        return view('products.index',compact('products','category', 'categories','major_category_names','sort', 'sorted'));//viewへ$categoriesを
        //products.index = /samazon/resources/views/products/index.blade.phpを使用
        //compact('products') = $productsをviewへ渡す
        //viewは、/samazon/resources/views/productsフォルダを作り、index.blade.phpを作成し、編集
    }
    
        public function favorite(Product $product)
        {
            $user = Auth::user();//現在にユーザー情報を代入
            
            if($user->hasFavorited($product)){//お気に入り済みかどうかをチェック
                $user->unfavorite($product);
            }else{
                $user->favorite($product);
            }
            
            return redirect()->route('products.show', $product);
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();//データを取得
        
        return view('products.create', compact('categories')); 
        // /samazon/resources/views/products/create.blade.phpを表示する。$categoriesにデータを渡す
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)//データを受け取り、保存・更新・削除を行う
    {
        $product = new Product();//Productモデルの変数作成
        $product->name = $request->input('name');//inputされた情報を$productに代入
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->save();//保存
        
        return redirect()->route('products.show',['id' => $product->id]);//保存されたら、リダイレクト
        //表示したいview、データのidを記述する
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)//自動的に該当するデータを判別して$productに代入している。
    {
        $reviews = $product->reviews()->get();
        //商品についての全てのレビューを取得して$reviewsに格納
        
        return view('products.show', compact('product','reviews'));
        //productsフォルダの、show.blade.phpを表示する。
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)//編集する商品のデータをビューへ渡す
    {
        $categories = Category::all();
        
        return view('products.edit', compact('product', 'categories'));
        
        // return view('product.edit', compact('product'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)//変更データを更新する
    {
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->update();
        
        return redirect()->route('products.show',['id' => $product->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)//データを削除する
    {
        $product->delete();
        
        return redirect()->route('products.index');
    }
}
