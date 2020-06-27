@extends('master.app')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <span class="m-0 font-weight-bold text-primary">Hasil Penjualan</span>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Jumlah Produk Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $index = 0;
                                @endphp
                                @foreach($data as $item)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->sale_product}}</td>
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
