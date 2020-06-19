@extends('master.app')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <span class="m-0 font-weight-bold text-primary">Kategori</span>
        <a href="{{ route('category.create') }}" class="btn btn-primary btn-icon-split float-right btn-sm">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Kategori</span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Kategori</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $index = 0;
                                @endphp
                                @foreach($categories as $item)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $item->category_name }}</td>
                                    <td>
                                        <form action="{{ route('category.destroy',$item->id) }}" method="POST">

                                            <a href="{{ route('category.edit',$item->id ) }}" class="mr-3">
                                                <i class="fa fa-pencil-square-o text-warning" aria-hidden="true"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
