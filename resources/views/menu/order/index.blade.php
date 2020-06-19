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
                    <span>@{{ result.product_name }}</span>
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
                <button class="btn btn-sm btn-primary" @click="bayar()">Bayar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    let app = new Vue({
        el : '#app',
        data: {
            keywords:'',
            results:[],
            carts:[],
            qty:1
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
            axios({
            method: 'post',
            url: '/api/order',
            data: this.carts
            }).then(function (response) {
                // your action after success
                console.log(response);
            })
            .catch(function (error) {
            // your action on error success
                console.log(error);
            });
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
