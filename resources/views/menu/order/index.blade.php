@extends('master.app')
@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span class="m-0 font-weight-bold text-primary">Tambah Barang</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="product_name">Nama Barang</label>
                    <input type="text" class="form-control" id="product_name" placeholder="Masukan nama barang"
                        name="product_name" @input="search($event)" v-model="keywords">
                </div>
                <div v-for="result in results" class="alert alert-primary" role="alert" @click="tambahCart(result)">
                    <span>@{{ result.product_name }}</span> <span class="float-right">
                        <i class="fa fa-arrow-right "></i>
                    </span>
                </div>


            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span class="m-0 font-weight-bold text-primary">Keranjang Belanja</span>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Barang</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Total</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(cart,index) in carts">
                            <td>@{{ cart.product_name }}</td>
                            <td><input class="text-center" type="text" width="10px"
                                    @input="ubahQty(index,$event.target.value)" v-model="cart.qty" size="6">
                            </td>
                            <td>@{{ cart.price.toLocaleString() }}</td>
                            <td>@{{ cart.total.toLocaleString() }}</td>
                            <td><button class="btn btn-danger btn-sm" @click="hapusCart(index)">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row ml-2" v-if="carts.length != 0">
                    <div class="form-group row">
                        <label for="uang_pembayaran" class="col-sm-5 col-form-label">Pembayaran</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="uang_pembayaran" placeholder="Uang Pembayaran"
                                @input="fun_kembalian($event.target.value)" v-model="uang_pembayaran">
                        </div>
                    </div>

                </div>
                <div class="row ml-2" v-if="uang_pembayaran != null">
                    <div class="form-group row">
                        <label for="kembalian" class="col-auto col-form-label">Kembalian</label>
                        <div class="col-auto">
                            <h5 style="color: green"> Rp. @{{ kembalian.toLocaleString() }} </h5>
                        </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-primary ml-2 float-right" @click="bayar()"
                    v-if="carts.length != 0">Bayar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    let app = new Vue({
        el : '#app',
        data: {
            keywords:'',
            results:[],
            carts:[],
            qty:1,
            uang_pembayaran:null,
            kembalian:0
        },
        methods: {

        search(query) {
            if (this.keywords.length > 1) {
                axios.get('/api/search/product/'+this.keywords).then(response => {
                   this.results = response.data
                   console.log(this.results)
                })
            }else{
                this.results = []
            }
        },
        tambahCart(data){
            let obj = this.carts.find((o, i) => {
                if (o.id === data.id) {
                    let cart = this.carts[i]
                    this.ubahQty(i,++cart.qty)
                    return true; // stop searching
                }
            });
            if(!obj){
                let jumlah = 1
                let keranjang = {
                id: data.id,
                product_name: data.product_name,
                qty:jumlah,
                price: data.price,
                total: jumlah*data.price
            }
            this.carts.push(keranjang);
            console.log(this.carts)
            }
        },
        ubahQty(index,data){
            let qty = data
            this.carts[index].qty = qty
            this.carts[index].total = qty * this.carts[index].price
            console.log(this.carts)
        },
        hapusCart(index){
            this.carts.splice(index,1)
        },
        bayar(){
            console.log(this.carts)
            let kembalian = this.kembalian
            if(this.kembalian < 0 || this.uang_pembayaran <= 0 || this.uang_pembayaran == null){
                swal({
                    icon: "error",
                    text: "Jumlah uang kurang !",
                });
            }else{
                axios({
                method: 'post',
                url: '/api/order',
                data: this.carts
                }).then(function (response) {
                    // your action after success
                    console.log(response.data);
                    swal({
                        icon: "success",
                        text: "Kembalian : " + kembalian,
                    }).then(function() {
                        window.location = "/admin/order";
                    });
                })
                .catch(function (error) {
                // your action on error success
                    swal({
                        icon: "error",
                        text: "Transaksi gagal !",
                    });
                });
            }

        },
        totalPembayaran(){
            let total =  this.carts.reduce((acc,curr)=> acc + curr.total,0);
            return total
        },
        fun_kembalian(data){
            console.log(data)
            this.kembalian = this.uang_pembayaran - this.totalPembayaran()

        }
        },
        watch: {
        keywords: function (val) {
            this.search(val)
        }
    }

    })
</script>

@endsection
