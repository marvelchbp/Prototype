<script setup>
    import MasterLayout from '../layoutsPage/Master.vue';
</script>

<script>
import axios from 'axios';
import moment from 'moment';
import { reactive, ref } from 'vue';

export default {
    data() {
        return {
            historyDelete: reactive({ id: '', deleted_at: '' }),
            historyDetail: reactive({ id: '' }),
            errors: ref([]),
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
            historys: ref([]),
            details: ref([]),
        };
    },
    created() {
    },
    mounted() {
        this.showTable();
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
        buttonClickForModalInsert(){
            
        },
        buttonClickForModalUpdate(){
            
        },
        deleteBarang(){
            axios
                .post('api/v1/master/deletebarang',this.barangDel)
                .then((res)=> {
                    alert(res.data.message)
                    this.barangDel.kode = ''
                    this.barangDel.nama = ''
                    this.barangDel.deleted_at = ''
                    this.showTable()
                })
                .catch((err) =>{
                    console.log(err)
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
        showDetailWhenClicked(row){
            this.historyDetail.id = row.id
            this.idOrder = row.id
            this.namaPegawai = row.nama_pegawai
            this.totalQty = row.total_qty
            this.totalTrans = row.total_transaksi
            this.tunaiTrans = row.tunai_transaksi
            this.kembalianTrans = row.kembali_transaksi
            this.tglCreated = moment(row.created_at).format("DD-MM-YYYY HH:mm")
            axios
                .post('api/v1/transaksi/datadetailriwayat',this.historyDetail)
                .then((res) => {
                    this.details.values = res.data.data.detail
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
    },
};
</script>

<template>
    <MasterLayout>
        <div class="w-100">
            <div class="w-50 mt-5 mx-auto">
                <h1 class="fs-1 text-center header-text">
                    Riwayat Transaksi
                </h1>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center my-4 pt-5">
            <div class="w-75 pb-1">
                <div class="w-50 mb-3">
                    <label for="exampleInputEmail1" class="form-label lbl-text fs-6 fw-bold">Search</label>
                    <input type="text" class="form-control lbl-text" id="InputSearch" placeholder="Cari Disini.." aria-describedby="emailHelp" required>
                </div>
            </div>
            <div class="w-75 py-6">
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
                                    <th scope="col" class="text-light">Buka Detail</th>
                                    <th scope="col" class="text-light">Unduh</th>
                                    <th scope="col" class="text-light">Hapus</th>
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
                                    <td>
                                        <span class="edit_mode mx-1" style="cursor:pointer">
                                            <i class="fa fa-folder-open" aria-hidden="true" @click="showDetailWhenClicked(history)" data-bs-toggle="modal" data-bs-target="#modalStruk"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="edit_mode mx-1" style="cursor:pointer">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="edit_mode mx-1" style="cursor:pointer">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </span>
                                    </td>
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
            <!-- MODAL Struk -->
            <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="modalStruk">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Struk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="my-2 d-flex flex-row justify-content-start align-items-start">
                                <p class="fntAll tgl text-start header-text">
                                    {{tglCreated}}
                                </p>
                                <p class="fntAll pegawai text-start header-text">
                                    {{namaPegawai}}
                                </p>
                            </div>
                            <div class="w-100" v-for="row in details.values" :key="row">
                                <div class="namacont d-flex flex-row justify-content-start align-items-start">
                                    <p class="fntAll nama text-start">
                                        {{row.nama_barang}}
                                    </p>
                                </div>
                                <div class="barang d-flex flex-row justify-content-between align-items-start">
                                    <div class="w-100 d-flex flex-row">
                                        <p class="fntAll qtydansatuan text-start">
                                            {{row.qty + "  "}} {{row.satuan}}
                                        </p>
                                        <p class="fntAll harga text-start">
                                            {{row.harga_barang}}
                                        </p>
                                    </div>
                                    <div class="w-100 d-flex flex-row">
                                        <p class="fntAll equal text-start">
                                            =
                                        </p>
                                        <p class="fntAll total text-end ms-auto">
                                            {{row.total}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row justify-content-end align-items-center">
                                <p class="fntAll equals">
                                    ==============
                                </p>
                            </div>
                            <div class="w-100 d-flex flex-row justify-content-between align-items-center">
                                <p class="fntAll titleTotal text-start">
                                    Total
                                </p>
                                <p class="fntAll equalTot text-start">
                                    =
                                </p>
                                <p class="fntAll total text-start ms-auto">
                                    {{totalTrans.toFixed(0)}}
                                </p>
                            </div>
                            <div class="w-100 d-flex flex-row justify-content-between align-items-center">
                                <p class="fntAll title text-start">
                                    Tunai
                                </p>
                                <p class="fntAll equalTot text-start">
                                    =
                                </p>
                                <p class="fntAll total text-start ms-auto">
                                    {{tunaiTrans}}
                                </p>
                            </div>
                            <div class="w-100 d-flex flex-row justify-content-end align-items-center">
                                <p class="fntAll equals">
                                    ==============
                                </p>
                            </div>
                            <div class="w-100 d-flex flex-row justify-content-between align-items-center">
                                <p class="fntAll titleKembali text-start">
                                    Kembali
                                </p>
                                <p class="fntAll equalTot text-start">
                                    =
                                </p>
                                <p class="fntAll total text-start ms-auto">
                                    {{kembalianTrans.toFixed(0)}}
                                </p>
                            </div>
                            <div class="d-flex flex-row justify-content-start align-items-start endFoot">
                                <p class="fntAll end text-start header-text">
                                    Total Qty =
                                </p>
                                <p class="fntAll endval text-start header-text">
                                    {{totalQty}}
                                </p>
                            </div>
                            <div class="d-flex flex-row justify-content-start align-items-start endFoot">
                                <p class="fntAll end text-start header-text">
                                    ID. Order:
                                </p>
                                <p class="fntAll endval text-start header-text">
                                    {{idOrder}}
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MODAL DELETE -->
            <div class="modal fade" id="exampleModal1" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Transaksi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" v-if="historyDelete.deleted_at == null">
                            Apakah Anda Yakin Untuk Menghapus data Transaksi dengan Id Order "{{historyDelete.id}}" ?
                        </div>
                        <div class="modal-body" v-if="historyDelete.deleted_at != null">
                            Apakah Anda Yakin Untuk Mengembalikan data Transaksi dengan Id Order "{{historyDelete.id}}" ?
                        </div>
                        <form @submit.prevent="deleteBarang()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodePegawaiDelete" v-model="historyDelete.id">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MasterLayout>
</template>

<style scoped>
.edit_mode:hover{ 
    color:#666;
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