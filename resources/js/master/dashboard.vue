<script setup>
    import MasterLayout from '../layoutsPage/Master.vue';
    import InputSearch from '../atoms/InputSearch.vue';
</script>

<script>
import axios from 'axios';
import moment, { now } from 'moment';
import { reactive, ref } from 'vue';

export default {
    components: {
        InputSearch,
    },
    data() {
        return {
            searchValue: reactive({ value: '' }),
            searchValueLog: reactive({ value: '' }),
            dataId: '',
            dataEmail: '',
            dataNama: '',
            pageLastCatat: 0,
            pageNowCatat: 0,
            pageLastStok: 0,
            pageNowStok: 0,
            catats: ref([]),
            stoks: ref([]),
            stokscount: [],
            headercount: [],
            totalQty: 0,
            totalTrans: 0,
            tunaiTrans: 0,
            kembalianTrans: 0,
            idOrder: 0,
            tglCreated: new Date(),
            namaPegawai: '',
            pageLast: 0,
            pageNow: 0,
            Nomor: 0,
            totalDataTransaksi: 0,
            totalHargaTransaksi: 0,
            historys: ref([]),
            details: ref([]),
            historyDetail: reactive({ id: '' }),
        };
    },
    created() {
        this.dataId = localStorage.getItem('id');
        this.dataEmail = localStorage.getItem('emailLogin');
        this.dataNama = localStorage.getItem('username');
    },
    mounted() {
        this.showTablePencatatan()
        this.showTableStok()
        this.showTableStokCount()
        this.showTableHeaderCount()
        this.showTable()
    },
    methods: {
        decrementPageFrom(){
            if(this.pageNow <= this.pageLast){
                this.pageNow--;
            }
            axios
                .get('api/v1/transaksi/datariwayat?page='+this.pageNow)
                .then((res) => {
                    this.historys.values = res.data.data
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        incrementPageFrom(){
            if(this.pageLast > this.pageNow){
                this.pageNow++;
            }
            axios
                .get('api/v1/transaksi/datariwayat?page='+this.pageNow)
                .then((res) => {
                    this.historys.values = res.data.data
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        decrementPageFromCatat(){
            if(this.searchValueLog.value != ''){  
                if(this.pageNowCatat <= this.pageLastCatat){
                    this.pageNowCatat--;
                }
                axios
                    .post('api/v1/master/stoklogsearch?page='+this.pageNowCatat,this.searchValueLog)
                    .then((res) => {
                        this.catats.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageNowCatat <= this.pageLastCatat){
                    this.pageNowCatat--;
                }
                axios
                    .get('api/v1/master/catatanstok?page='+this.pageNowCatat)
                    .then((res) => {
                        this.catats.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }
        },
        incrementPageFromCatat(){
            if(this.searchValueLog.value != ''){
                if(this.pageLastCatat > this.pageNowCatat){
                    this.pageNowCatat++;
                }
                axios
                    .post('api/v1/master/stoklogsearch?page='+this.pageNowCatat,this.searchValueLog)
                    .then((res) => {
                        this.catats.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageLastCatat > this.pageNowCatat){
                    this.pageNowCatat++;
                }
                axios
                    .get('api/v1/master/catatanstok?page='+this.pageNowCatat)
                    .then((res) => {
                        this.catats.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }
        },
        decrementPageFromStok(){
            if(this.searchValue.value != ''){  
                if(this.pageNowStok <= this.pageLastStok){
                    this.pageNowStok--;
                }
                axios
                    .post('api/v1/master/stoksearch?page='+this.pageNowStok,this.searchValue)
                    .then((res) => {
                        this.stoks.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageNowStok <= this.pageLastStok){
                    this.pageNowStok--;
                }
                axios
                    .get('api/v1/master/stok?page='+this.pageNowStok)
                    .then((res) => {
                        this.stoks.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }
        },
        incrementPageFromStok(){
            if(this.searchValue.value != ''){  
                if(this.pageLastStok > this.pageNowStok){
                    this.pageNowStok++;
                }
                axios
                    .post('api/v1/master/stoksearch?page='+this.pageNowStok,this.searchValue)
                    .then((res) => {
                        this.stoks.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageLastStok > this.pageNowStok){
                    this.pageNowStok++;
                }
                axios
                    .get('api/v1/master/stok?page='+this.pageNowStok)
                    .then((res) => {
                        this.stoks.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }
        },
        showTablePencatatan(){
            axios
                .get('api/v1/master/catatanstok')
                .then((res) => {
                    this.catats.values = res.data.data
                    this.pageNowCatat = res.data.meta.current_page;
                    this.pageLastCatat = res.data.meta.last_page;
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        showTableStok(){
            axios
                .get('api/v1/master/stok')
                .then((res) => {
                    this.stoks.values = res.data.data
                    this.pageNowStok = res.data.meta.current_page;
                    this.pageLastStok = res.data.meta.last_page;
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        showTableStokCount(){
            axios
                .get('api/v1/master/stokdashboard')
                .then((res) => {
                    this.stokscount = res.data.data
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        showTableHeaderCount(){
            axios
                .get('api/v1/master/headertrans')
                .then((res) => {
                    this.headercount = res.data.data
                    for (let i = 0; i < this.headercount.length; i++) {
                        let dateHeader = this.headercount[i].created_at
                        let dateHeaderToFormat = moment(dateHeader).format("DD/MM/YYYY");
                        let dateHeaderToMoment = moment(dateHeaderToFormat, "DD/MM/YYYY");
                        if(moment().diff(dateHeaderToMoment, 'days') <= 0){
                            this.totalDataTransaksi += 1
                            this.totalHargaTransaksi += this.headercount[i].total_transaksi
                        }
                    }
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        showTable(){
            axios
                .get('api/v1/transaksi/datariwayat')
                .then((res) => {
                    this.historys.values = res.data.data
                    this.pageNow = res.data.meta.current_page
                    this.pageLast = res.data.meta.last_page
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split("."),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                const separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "." + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        },
        searchMethodLog(){
            axios
                .post('api/v1/master/stoklogsearch',this.searchValueLog)
                .then((res) => {
                    this.catats.values = res.data.data.data
                    this.pageNowCatat = res.data.data.current_page
                    this.pageLastCatat = res.data.data.last_page
                })
                .catch((error) => {
                    console.log(error);
            });
        },
    },
}
</script>

<template>
    <MasterLayout>
        <div class="w-100">
            <div class="w-50 mt-5 mx-auto">
                <h1 class="fs-1 text-start header-text">
                    Dashboard
                </h1>
            </div>
        </div>
        <div class="w-100 d-flex flex-row justify-content-center mb-4 pt-5">
            <div class="w-50 d-flex flex-column flex-xl-row justify-content-between justify-content-sm-between align-items-center my-4 pt-5">
                <div class="card" style="width: 18rem; height: 11.5rem;">
                    <div class="card-body text-center">
                        <div>
                            <i class="fa fa-archive fa-4x" aria-hidden="true"></i>
                            <h5 class="card-title">Total Barang Stok Kurang</h5>
                        </div>
                        <h5>{{stokscount.length}} Barang</h5>
                        <a href="#" class="card-link">More ...</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem; height: 11.5rem;">
                    <div class="card-body text-center">
                        <div>
                            <i class="fa fa-shopping-cart fa-4x" aria-hidden="true"></i>
                            <h5 class="card-title">Total Transaksi Per Hari</h5>
                        </div>
                        <h5>{{totalDataTransaksi}} Transaksi</h5>
                        <a href="#" class="card-link">More ...</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem; height: 11.5rem;">
                    <div class="card-body text-center">
                        <div>
                            <i class="fa fa-money fa-4x" aria-hidden="true"></i>
                            <h5 class="card-title">Total Pemasukan Per Hari</h5>
                        </div>
                        <h4>{{formatRupiah( totalHargaTransaksi + "" , "IDR")}},-</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabel Pencatatan Stok -->
        <div class="d-flex flex-column justify-content-center align-items-center my-4 pt-5">
            <div class="w-50 pb-1">
                <h3 class="fs-3 text-start header-text">
                    Tabel Riwayat Transaksi
                </h3>
            </div>
            <div class="w-50 py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="table-responsive">
                        <table class="table table-bordered border-dark table-hover align-middle w-100">
                            <!-- head -->
                            <thead >
                                <tr class="table-dark fw-bold text-center">
                                    <th scope="col" class="text-light">Kode Transaksi</th>
                                    <th scope="col" class="text-light">Nama Pegawai</th>
                                    <th scope="col" class="text-light">Nama Member</th>
                                    <th scope="col" class="text-light">Promo</th>
                                    <th scope="col" class="text-light">Pajak</th>
                                    <th scope="col" class="text-light">Total Qty</th>
                                    <th scope="col" class="text-light">Total Transaksi</th>
                                    <th scope="col" class="text-light">Tunai Transaksi</th>
                                    <th scope="col" class="text-light">Kembalian Transaksi</th>
                                    <th scope="col" class="text-light">Tanggal Dibuat</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider lbl-text bodtab text-center">
                            <!-- row -->
                                <tr v-for="history in historys.values" :key="history.id">
                                    <th scope="row" class="number">{{history.id}}</th>
                                    <td><span>{{history.nama_pegawai}}</span></td>
                                    <td>
                                        <span v-if="history.nama_member == null">-</span>
                                        <span v-if="history.nama_member != null">{{history.nama_member}}</span>
                                    </td>
                                    <td>
                                        <span v-if="history.fk_kode_promo == null">-</span>
                                        <span v-if="history.fk_kode_promo != null">{{history.fk_kode_promo}}</span>
                                    </td>
                                    <td>{{history.pajak}}%</td>
                                    <td>{{history.total_qty}}</td>
                                    <td>{{formatRupiah( history.total_transaksi + "", "IDR")}}</td>
                                    <td>{{formatRupiah( history.tunai_transaksi + "", "IDR")}}</td>
                                    <td>{{formatRupiah( history.kembali_transaksi + "", "IDR")}}</td>
                                    <td>{{moment(history.created_at).format('DD MMM YYYY')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li v-if="pageNow > 1" class="page-item">
                                <a class="page-link" @click="decrementPageFrom()" style="cursor:pointer">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link">{{pageNow}}</a></li>
                            <li class="page-item">
                                <a class="page-link" @click="incrementPageFrom()" style="cursor:pointer">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="w-50 pb-1 mt-5">
                <h3 class="fs-3 text-start header-text">
                    Tabel Pencatatan Pergantian Stok
                </h3>
            </div>
            <div class="w-50 pb-1">
                <div class="w-100 mb-3">
                    <label for="exampleInputEmail1" class="form-label lbl-text fs-6 fw-bold">Search</label>
                    <InputSearch v-model="searchValueLog.value" v-on:change="searchMethodLog()" />
                </div>
            </div>
            <div class="w-50 py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="table-responsive">
                        <table class="table table-bordered border-dark table-hover align-middle w-100">
                            <!-- head -->
                            <thead >
                                <tr class="table-dark fw-bold text-center">
                                    <th scope="col" class="text-light">ID</th>
                                    <th scope="col" class="text-light">Kode Stock</th>
                                    <th scope="col" class="text-light">Stok Sebelum</th>
                                    <th scope="col" class="text-light">Stok Sesudah</th>
                                    <th scope="col" class="text-light">Dibuat Oleh</th>
                                    <th scope="col" class="text-light">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider lbl-text bodtab text-center">
                            <!-- row -->
                                <tr v-for="catat in catats.values" :key="catat.id">
                                    <th scope="row" class="number">{{catat.id}}</th>
                                    <td>{{catat.fk_kode_barang}}</td>
                                    <td>{{catat.stock_sebelum}}</td>
                                    <td>{{catat.stock_sesudah}}</td>
                                    <td>{{catat.name}}</td>
                                    <td>{{moment(catat.created_at).format('DD MMM YYYY')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li v-if="pageNowCatat > 1" class="page-item">
                                <a class="page-link" @click="decrementPageFromCatat()" style="cursor:pointer">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link">{{pageNowCatat}}</a></li>
                            <li class="page-item">
                                <a class="page-link" @click="incrementPageFromCatat()" style="cursor:pointer">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="w-50 pb-1 mt-5">
                <h3 class="fs-3 text-start header-text">
                    Tabel Stok Barang Kurang
                </h3>
            </div>
            <div class="w-50 pb-1">
                <div class="w-100 mb-3">
                    <label for="exampleInputEmail1" class="form-label lbl-text fs-6 fw-bold">Search</label>
                    <InputSearch v-model="searchValue.value" v-on:change="searchMethod()" />
                </div>
            </div>
            <div class="w-50 py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="table-responsive">
                        <table class="table table-bordered border-dark table-hover align-middle w-100">
                            <!-- head -->
                            <thead >
                                <tr class="table-dark fw-bold text-center">
                                    <th scope="col" class="text-light">Kode Stock</th>
                                    <th scope="col" class="text-light">Stok</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider lbl-text bodtab text-center">
                            <!-- row -->
                                <tr v-for="stok in stoks.values" :key="stok.kode_barang">
                                    <th scope="row" class="number">{{stok.kode_barang}}</th>
                                    <td>{{stok.stock}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <ul class="pagination justify-content-center">
                            <li v-if="pageNowStok > 1" class="page-item">
                                <a class="page-link" @click="decrementPageFromStok()" style="cursor:pointer">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link">{{pageNowStok}}</a></li>
                            <li class="page-item">
                                <a class="page-link" @click="incrementPageFromStok()" style="cursor:pointer">Next</a>
                            </li>
                        </ul>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </MasterLayout>
</template>

<style scoped>
.icon{
    width: 3rem;
    height: 3rem;
}
.fntAll{
    font-family: "Inter";
    font-size: 10pt;
    font-weight: 600;
}
.pegawai, .endval{
    margin-left: 0.5rem;
}
.tgl, .end{
    margin-left: 1rem;
}
.namacont{
    margin-top: -0.75rem;
}
.nama{
    margin-left: 1rem;
}
.barang{
    margin-top: -1rem;
}
.harga{
    margin-left: 3rem;
}
.qtydansatuan{
    margin-left: 2rem;
}
.equal{
    margin-left: 5rem;
}
.jumlah{
    margin-left: 4rem;
}
.titleKembali{
    position: static;
    margin-left: 16rem;
    margin-right: 0.75rem;
}
.titleTotal{
    position: static;
    margin-left: 16.95rem;
    margin-right: 0.75rem;
}
.title{
    position: static;
    margin-left: 16.8rem;
    margin-right: 0.75rem;
}
.equals, .total{
    margin-right: 1.6rem;
}
</style>