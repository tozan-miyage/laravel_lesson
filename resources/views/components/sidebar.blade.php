<div class="container">
    @foreach($major_category_names as $major_category_name)
        <h2>{{ $major_category_name }}</h2>
        @foreach($categories as $category)
            @if($category->major_category_name === $major_category_name)
            <label id="sidebar" class="samason-sidebar-category-label">
                <!--ルーティングの後に、連想配列で呼び出す変数を渡す-->
                <a href="{{ route('products.index',['category' => $category->id]) }}">{{ $category->name }}</a>
            </label>
            @endif
        @endforeach
    @endforeach
</div>