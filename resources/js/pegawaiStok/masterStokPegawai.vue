<script setup>
    import StokLayout from '../layoutsPage/Stok.vue';
</script>

<script>
import axios from 'axios';
import moment, { now } from 'moment';
import { reactive, ref } from 'vue';

export default {
    data() {
        return {
            booleanUpdate: false,
            formStokInsert: reactive({ kode: '', stok: '', pilihan: '' }),
            StokInsert: reactive({ id:'' ,kode: '', stok: '', pilihan: '' }),
            formStokUpdate: reactive({ kode: '', stok: '', pilihan: '' }),
            StokUpdate: reactive({ id:'' ,kode: '', stok: '', pilihan: '' }),
            errorsInsert: ref([]),
            errorsUpdate: ref([]),
            pageLastCatat: 0,
            pageNowCatat: 0,
            pageLastStok: 0,
            pageNowStok: 0,
            catats: ref([]),
            stoks: ref([]),
            dataId: '',
        };
    },
    created() {
        this.dataId = localStorage.getItem('id');
    },
    mounted() {
        this.showTablePencatatan();
        this.showTableStok();
    },
    methods: {
        decrementPageFromCatat(){
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
        },
        incrementPageFromCatat(){
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
        },
        decrementPageFromStok(){
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
        },
        incrementPageFromStok(){
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
        },
        backToInsert(){
            this.booleanUpdate = false
            this.formStokUpdate.kode = '';
            this.formStokUpdate.stok = '';
            this.formStokUpdate.pilihan = '';
        },
        rowClicked(row){
            this.booleanUpdate = true;
            this.formStokUpdate.kode = row.kode_barang;
            this.formStokUpdate.stok = row.stock;
        },
        buttonClickForModalInsert(){
            this.StokInsert.kode = this.formStokInsert.kode;
            this.StokInsert.stok = this.formStokInsert.stok;
            this.StokInsert.pilihan = this.formStokInsert.pilihan;
            this.StokInsert.id = this.dataId;
        },
        buttonClickForModalUpdate(){
            this.StokUpdate.kode = this.formStokUpdate.kode;
            this.StokUpdate.stok = this.formStokUpdate.stok;
            this.StokUpdate.pilihan = this.formStokUpdate.pilihan;
            this.StokUpdate.id = this.dataId;
        },
        addStok(){
            axios
                .post('api/v1/master/insertstok',this.StokInsert)
                .then((res)=> {
                    alert(res.data.message)
                    this.errorsInsert = ref([])
                    this.formStokInsert.kode = ''
                    this.formStokInsert.stok = ''
                    this.formStokInsert.pilihan = ''
                    this.showTableStok()
                    this.showTablePencatatan()
                })
                .catch((err) =>{
                    if(err){
                        this.errorsInsert.values = err.response.data.message
                    }
                });
        },
        updateStok(){
            axios
                .post('api/v1/master/updatestok',this.StokUpdate)
                .then((res)=> {
                    alert(res.data.message)
                    this.errorsUpdate = ref([])
                    this.formStokUpdate.kode = ''
                    this.formStokUpdate.stok = ''
                    this.formStokUpdate.pilihan = ''
                    this.showTableStok()
                    this.showTablePencatatan()
                    this.booleanUpdate = false
                })
                .catch((err) =>{
                    if(err){
                        this.errorsUpdate.values = err.response.data.message
                    }
                });
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
        }
    },
};
</script>

<template>
    <StokLayout>
        <div class="w-100">
            <div class="w-50 mt-5 mx-auto">
                <h1 class="fs-1 text-start header-text">
                    Master Stok
                </h1>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center my-4 pt-5">
            <!-- Tabel Stok Barang -->
            <div class="w-50 pb-1">
                <h3 class="fs-3 text-start header-text">
                    Tabel Stok Barang
                </h3>
            </div>
            <div class="w-50 pb-1">
                <div class="w-100 mb-3">
                    <label for="exampleInputEmail1" class="form-label lbl-text fs-6 fw-bold">Search</label>
                    <input type="text" class="form-control lbl-text" id="InputSearch" placeholder="Cari Disini.." aria-describedby="emailHelp" required>
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
                                    <th scope="col" class="text-light">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider lbl-text bodtab text-center">
                            <!-- row -->
                                <tr v-for="stok in stoks.values" :key="stok.kode_barang">
                                    <th scope="row" class="number">{{stok.kode_barang}}</th>
                                    <td>{{stok.stock}}</td>
                                    <td>
                                        <button class="btn res" @click="rowClicked(stok)" >Edit</button>
                                    </td>
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
            <!-- MODAL INSERT -->
            <div class="modal fade" id="exampleModalInsert" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Stok Barang</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Menambahkan Stok Barang dengan Kode {{StokInsert.kode.toUpperCase()}} ?
                        </div>
                        <form @submit.prevent="addStok()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodeStokInsert" v-model="StokInsert.kode">
                            <input type="hidden" class="form-control lbl-text" id="stokInsert" v-model="StokInsert.stok">
                            <input type="hidden" class="form-control lbl-text" id="pilihanInsert" v-model="StokInsert.pilihan">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- MODAL UPDATE -->
            <div class="modal fade" id="exampleModalUpdate" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Stok Barang</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Menambah Atau Mengubah Stok Barang dengan Kode {{StokUpdate.kode.toUpperCase()}} ?
                        </div>
                        <form @submit.prevent="updateStok()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodeStokUpdate" v-model="StokUpdate.kode">
                            <input type="hidden" class="form-control lbl-text" id="stokUpdate" v-model="StokUpdate.stok">
                            <input type="hidden" class="form-control lbl-text" id="pilihanUpdate" v-model="StokUpdate.pilihan">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Input -->
            <div class="w-50 py-5 mt-4 ">
                <div class="w-100">
                    <form v-if="!booleanUpdate" method="post" class="d-grid">
                        <div class="mb-3 w-100">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radioClick" v-model="formStokInsert.pilihan" type="radio" name="perubahanStok" id="rubahStok" v-bind:value="'tambah'">
                                <label class="form-check-label lbl-text fs-6 fw-bold" for="inlineRadio1">Tambah</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radioClick" v-model="formStokInsert.pilihan" type="radio" name="perubahanStok" id="rubahStok" v-bind:value="'ubah'">
                                <label class="form-check-label lbl-text fs-6 fw-bold" for="inlineRadio2">Ubah</label>
                            </div>
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.pilihan">
                                {{ errorsInsert.values.pilihan[0] }}
                            </div>
                        </div>
                        <div class="mb-3 w-100">
                            <label for="KodeStock" class="form-label lbl-text fs-6 fw-bold">Kode Stock</label>
                            <input type="text" class="form-control lbl-text" v-model="formStokInsert.kode" id="KodeStock" placeholder="Masukkan Kode Stock" aria-describedby="kodeStock" >
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.kode">
                                {{ errorsInsert.values.kode[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="JumlahStock" class="form-label lbl-text fs-6 fw-bold">Jumlah Stok</label>
                            <input type="number" class="form-control lbl-text" v-model="formStokInsert.stok" id="JumlahStock" placeholder="Masukkan Jumlah Stok Barang" aria-describedby="jumStock" >
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.stok">
                                {{ errorsInsert.values.stok[0] }}
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mt-3 mb-5">
                            <button type="button" @click="buttonClickForModalInsert()" data-bs-toggle="modal" data-bs-target="#exampleModalInsert" class="btn px-4 py-2 rounded-md ml-4 w-20">
                                Sumbit
                            </Button>
                        </div>
                    </form>
                    <form v-if="booleanUpdate" method="post" class="d-grid">
                        <div class="mb-3 w-100">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radioClick" v-model="formStokUpdate.pilihan" type="radio" name="perubahanStok" id="rubahStok" v-bind:value="'tambah'">
                                <label class="form-check-label lbl-text fs-6 fw-bold" for="inlineRadio1">Tambah</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radioClick" v-model="formStokUpdate.pilihan" type="radio" name="perubahanStok" id="rubahStok" v-bind:value="'ubah'">
                                <label class="form-check-label lbl-text fs-6 fw-bold" for="inlineRadio2">Ubah</label>
                            </div>
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.pilihan">
                                {{ errorsUpdate.values.pilihan[0] }}
                            </div>
                        </div>
                        <div class="mb-3 w-100">
                            <label for="KodeStock" class="form-label lbl-text fs-6 fw-bold">Kode Stock</label>
                            <input type="text" class="form-control lbl-text" v-model="formStokUpdate.kode" id="KodeStock" placeholder="Masukkan Kode Stock" aria-describedby="kodeStock" disabled>
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.kode">
                                {{ errorsUpdate.values.kode[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="JumlahStock" class="form-label lbl-text fs-6 fw-bold">Jumlah Stok</label>
                            <input type="number" class="form-control lbl-text" v-model="formStokUpdate.stok" id="JumlahStock" placeholder="Masukkan Jumlah Stok Barang" aria-describedby="jumStock" >
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.stok">
                                {{ errorsUpdate.values.stok[0] }}
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mt-3 mb-5">
                            <span @click="backToInsert()" class="back underline text-decoration-underline px-3" style="cursor: pointer">
                                Kembali Ke Form Tambah
                            </span>
                            <button type="button" @click="buttonClickForModalUpdate()" data-bs-toggle="modal" data-bs-target="#exampleModalUpdate" class="btn px-4 py-2 rounded-md ml-4 w-20">
                                Update
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </StokLayout>
</template>

<style scoped>
.back:hover{
    color: var(--bs-gray-700);
}
.res{
    width: 5.3rem;
}
.radioClick:active{
    background-color: #4a4a4a;
    border: 1pt solid #4a4a4a;
}
.radioClick:focus{
    background-color: #4a4a4a;
    border: 1pt solid #4a4a4a;
}
.radioClick:checked{
    background-color: #4a4a4a;
    border: 1pt solid #4a4a4a;
}
</style>