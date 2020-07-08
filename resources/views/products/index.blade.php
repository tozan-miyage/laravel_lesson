@extends('layouts.app')<!-- app.blade.phpをレイアウトとして使っている-->
@section('content')

<div class="row">
    <div class="col-2">

        @component('components.sidebar',['categories' => $categories, 'major_category_names' => $major_category_names])
        @endcomponent<!-- 連想配列でcomponentへ変数を渡すことができる-->
    </div>
    <div class="col-9">
        <div class="container">
            @if ($category !== null)
            <a href="/">トップ</a> > <a href="#">{{ $category->major_category_name }}</a> > {{ $category->name }}
            <h1>{{ $category->name }}の商品一覧{{ $products->count() }}件</h1>
            
            <form method="GET" action="{{ route('products.index') }}" class="form-inline">
                <input type="hidden" name="category" value="{{ $category->id }}">
                並び替え
                <select name="sort" onChange="this.form.submit();" class="form-inline ml-2">
                    @foreach($sort as $key =>$value)
                    @if ($sorted == $value)
                    <option value="{{ $value }}" selected>{{ $key }}</option>
                    @else
                    <option value="{{ $value }}">{{ $key }}</option>
                    @endif
                @endforeach
                </select>
            </form>
            @endif
        </div>
        <div class="container mt-4">
            <div class="row w-100">
                @foreach($products as $product)
                <div class="col-3">
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ asset('img/dummy.png') }}" class="img-thumbnail"><!--{{ asset('img/dummy.png')}} でpubricディレクトリ内の画像やcSSなどを読み取っている。-->
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <p class="samazon-product-label mt-2">
                                {{$product->name}}<br>
                                <label>￥{{$product->price}}</label>
                                <br>
                                <a href="{{route('products.show', $product)}}">Show</a>
                                <a href="{{route('products.edit', $product)}}">edit</a> 
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="{{route('products.create')}}">New</a> 
        </div>
        {{ $products->links() }}
    </div>
</div>
@endsection