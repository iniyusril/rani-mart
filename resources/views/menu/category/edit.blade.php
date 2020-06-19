@extends('master.app')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <span class="m-0 font-weight-bold text-primary">Edit Kategori</span>
    </div>
    <div class="card-body">
        <form action="{{ route('category.update',$category->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="categoryName">Nama Kategori</label>
                <input type="text" class="form-control" id="categoryName" placeholder="Masukan nama kategori"
                    name="category_name" value="{{ $category->category_name }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
