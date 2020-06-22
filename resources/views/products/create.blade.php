<h1>New Products</h1>

<form method="POST" action="/products">　<!--productsフォルダに送信 -->
    {{ csrf_field() }}<!--外部からのリクエストを弾くセキュリティ対策 -->
    <input type="text" name="name"><!-- 商品名を記入-->
    <textarea name="description"></textarea><!-- 商品説明を記入-->
    <input type="number" name="price"><!-- 値段を記入-->
    <select name="category_id"><!-- カテゴリーを選択-->
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    <button type="submit">Create</button><!-- 送信-->
</form>

<a href = "/products">Buck</a>
