@extends('master.app')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <span class="m-0 font-weight-bold text-primary">Tambah Produk</span>
    </div>
    <div class="card-body">
        <form action="{{ route('product.update',$product->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="product_name">Nama Produk</label>
                <input type="text" class="form-control" id="product_name" placeholder="Masukan nama kategori"
                    name="product_name" value="{{ $product->product_name }}">
            </div>
            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" class="form-control" id="price" placeholder="Masukan nama kategori" name="price"
                    value="{{ $product->price }}">
            </div>
            <div class=" form-group">
                <label for="stock">Stok</label>
                <input type="number" class="form-control" id="stock" placeholder="Masukan nama kategori" name="stock"
                    value="{{ $product->stock }}">
            </div>
            <div class=" form-group">
                <label for="category_id">Kategori</label>
                <select class="form-control" id="category_id" name="category_id">
                    @foreach ($categories as $item)
                    @if ($item->id == $product->category_id)
                    <option value="{{ $item->id }}" selected>{{ $item->category_name }}</option>
                    @continue
                    @endif
                    <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@endsection
