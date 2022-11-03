<script setup>
    import MasterLayout from '../layoutsPage/Master.vue';
    import InputSearch from '../atoms/InputSearch.vue';
</script>

<script>
import axios from 'axios';
import { reactive, ref } from 'vue';

export default {
    components: { InputSearch },
    data() {
        return {
            searchValue: reactive({value: ''}),
            booleanUpdate: false,
            formKategoriInsert: reactive({ kode: '', nama: '' }),
            KategoriInsert: reactive({ kode: '', nama: '' }),
            formKategoriUpdate: reactive({ kode: '', nama_hid: '', nama: '' }),
            KategoriUpdate: reactive({ kode: '', nama_hid: '', nama: '' }),
            kategoriDel: reactive({ kode: '', nama: '', deleted_at: ''}),
            errorsInsert: ref([]),
            errorsUpdate: ref([]),
            pageLast: 0,
            pageNow: 0,
            kategoris: ref([]),
        };
    },
    created() {
    },
    mounted() {
        this.showTable();
    },
    methods: {
        decrementPageFrom(){
            if(this.searchValue.value != ''){
                if(this.pageNow <= this.pageLast){
                    this.pageNow--;
                }
                axios
                    .post('api/v1/master/kategorisearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.kategoris.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageNow <= this.pageLast){
                    this.pageNow--;
                }
                axios
                    .get('api/v1/master/kategori?page='+this.pageNow)
                    .then((res) => {
                        this.kategoris.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }
        },
        incrementPageFrom(){
            if(this.searchValue.value != ''){
                if(this.pageLast > this.pageNow){
                    this.pageNow++;
                }
                axios
                    .post('api/v1/master/kategorisearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.kategoris.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageLast > this.pageNow){
                    this.pageNow++;
                }
                axios
                    .get('api/v1/master/kategori?page='+this.pageNow)
                    .then((res) => {
                        this.kategoris.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }
        },
        backToInsert(){
            this.booleanUpdate = false
            this.formKategoriUpdate.kode = '';
            this.formKategoriUpdate.nama_hid = '';
            this.formKategoriUpdate.nama = '';
        },
        buttonClickForModalInsert(){
            this.KategoriInsert.kode = this.formKategoriInsert.kode;
            this.KategoriInsert.nama = this.formKategoriInsert.nama;
        },
        buttonClickForModalUpdate(){
            this.KategoriUpdate.kode = this.formKategoriUpdate.kode;
            this.KategoriUpdate.nama = this.formKategoriUpdate.nama;
            this.KategoriUpdate.nama_hid = this.formKategoriUpdate.nama_hid;
        },
        rowClicked(row){
            this.booleanUpdate = true;
            this.formKategoriUpdate.kode = row.kode;
            this.formKategoriUpdate.nama_hid = row.nama;
            this.formKategoriUpdate.nama = row.nama;
        },
        rowClickedTakeKode(row){
            this.kategoriDel.kode = row.kode;
            this.kategoriDel.nama = row.nama;
            this.kategoriDel.deleted_at = row.deleted_at;
        },
        addKategori(){
            axios
                .post('api/v1/master/insertkategori',this.KategoriInsert)
                .then((res)=> {
                    alert(res.data.message)
                    this.errorsInsert = ref([])
                    this.formKategoriInsert.kode = ''
                    this.formKategoriInsert.nama = ''
                    this.showTable()
                })
                .catch((err) =>{
                    if(err){
                        this.errorsInsert.values = err.response.data.message
                    }
                });
        },
        updateKategori(){
            axios
                .post('api/v1/master/updatekategori',this.KategoriUpdate)
                .then((res)=> {
                    alert(res.data.message)
                    this.errorsUpdate = ref([])
                    this.formKategoriUpdate.kode = ''
                    this.formKategoriUpdate.nama_hid = ''
                    this.formKategoriUpdate.nama = ''
                    this.showTable()
                    this.booleanUpdate = false
                })
                .catch((err) =>{
                    if(err){
                        this.errorsUpdate.values = err.response.data.message
                    }
                });
        },
        deleteKategori(){
            axios
                .post('api/v1/master/deletekategori',this.kategoriDel)
                .then((res)=> {
                    alert(res.data.message)
                    this.kategoriDel.kode = ''
                    this.kategoriDel.nama = ''
                    this.kategoriDel.deleted_at = ''
                    this.showTable()
                })
                .catch((err) =>{
                    console.log(err)
                });
        },
        showTable(){
            axios
                .get('api/v1/master/kategori')
                .then((res) => {
                    this.kategoris.values = res.data.data
                    this.pageNow = res.data.meta.current_page;
                    this.pageLast = res.data.meta.last_page;
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        searchMethod(){
            axios
                .post('api/v1/master/kategorisearch',this.searchValue)
                .then((res) => {
                    this.kategoris.values = res.data.data.data
                    this.pageNow = res.data.data.current_page
                    this.pageLast = res.data.data.last_page
                })
                .catch((error) => {
                    console.log(error);
            });
        },
    },
};
</script>

<template>
    <MasterLayout>
        <div class="w-100">
            <div class="w-50 mt-5 mx-auto">
                <h1 class="fs-1 text-start header-text">
                    Master Kategori
                </h1>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center my-4 pt-5">
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
                                    <th scope="col" class="text-light">Kode Kategori</th>
                                    <th scope="col" class="text-light">Nama Kategori</th>
                                    <th scope="col" class="text-light">Jumlah Barang</th>
                                    <th scope="col" class="text-light">Keterangan</th>
                                    <th scope="col" class="text-light">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider lbl-text bodtab text-center">
                            <!-- row -->
                                <tr v-for="kategori in kategoris.values" :key="kategori.kode">
                                    <th scope="row" class="number">{{kategori.kode_kategori}}</th>
                                    <td>{{kategori.nama_kategori}}</td>
                                    <td>{{kategori.jumlah_barang}}</td>
                                    <td> 
                                        <div v-if="kategori.deleted_at == null" class="text-success fw-bold text-uppercase"> Aktif </div>
                                        <div v-if="kategori.deleted_at != null" class="text-danger fw-bold text-uppercase"> Non Aktif </div>
                                    </td>
                                    <td>
                                        <button class="btn res" @click="rowClicked(kategori)" >Edit</button>
                                        <button v-if="kategori.deleted_at == null" class="btn res del" @click="rowClickedTakeKode(kategori)" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
                                        <button v-if="kategori.deleted_at != null" class="btn res del" @click="rowClickedTakeKode(kategori)" data-bs-toggle="modal" data-bs-target="#exampleModal">Restore</button>
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
            <!-- MODAL INSERT -->
            <div class="modal fade" id="exampleModalInsert" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Insert Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Menambahkan Data Kategori dengan Kode {{KategoriInsert.kode.toUpperCase()}} ?
                        </div>
                        <form @submit.prevent="addKategori()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodeInsert" v-model="KategoriInsert.kode">
                            <input type="hidden" class="form-control lbl-text" id="NamaInsert" v-model="KategoriInsert.nama">
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Mengubah Data Kategori dengan Kode {{KategoriUpdate.kode.toUpperCase()}} ?
                        </div>
                        <form @submit.prevent="updateKategori()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodeUpdate" v-model="KategoriUpdate.kode">
                            <input type="hidden" class="form-control lbl-text" id="NamaUpdate" v-model="KategoriUpdate.nama">
                            <input type="hidden" class="form-control lbl-text" id="namaHiddenUpdate" v-model="KategoriUpdate.nama_hid">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- MODAL DELETE -->
            <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" v-if="kategoriDel.deleted_at == null">
                            Apakah Anda Yakin Untuk Menghapus data Kategori "{{kategoriDel.nama}}" ?
                        </div>
                        <div class="modal-body" v-if="kategoriDel.deleted_at != null">
                            Apakah Anda Yakin Untuk Mengembalikan data Kategori "{{kategoriDel.nama}}" ?
                        </div>
                        <form @submit.prevent="deleteKategori()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodePegawaiDelete" v-model="kategoriDel.kode">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
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
                            <label for="KodeKategori" class="form-label lbl-text fs-6 fw-bold">Kode Kategori</label>
                            <input type="text" v-model="formKategoriInsert.kode" class="form-control lbl-text" id="KodeKategori" placeholder="Masukkan Kode Kategori">
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.kode">
                                {{ errorsInsert.values.kode[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputNamaKategori" class="form-label lbl-text fs-6 fw-bold">Nama Kategori</label>
                            <input type="text" v-model="formKategoriInsert.nama" class="form-control lbl-text" id="InputNamaKategori" placeholder="Masukkan Nama Kategori">
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.nama">
                                {{ errorsInsert.values.nama[0] }}
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
                            <label for="KodeKategori" class="form-label lbl-text fs-6 fw-bold">Kode Kategori</label>
                            <input type="text" v-model="formKategoriUpdate.kode" class="form-control lbl-text" id="KodeKategori" placeholder="Berisi Kode Kategori" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="InputNamaKategori" class="form-label lbl-text fs-6 fw-bold">Nama Kategori</label>
                            <input type="hidden" v-model="formKategoriUpdate.nama_hid" class="form-control lbl-text" id="InputNamaKategoriHidden">
                            <input type="text" v-model="formKategoriUpdate.nama" class="form-control lbl-text" id="InputNamaKategori" placeholder="Masukkan Nama Kategori">
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.nama">
                                {{ errorsUpdate.values.nama[0] }}
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
    </MasterLayout>
</template>

<style scoped>
.back:hover{
    color: var(--bs-gray-700);
}
.res{
    width: 5.3rem;
}
.del{
    font-family: "Inter";
    font-size: medium;
    font-weight: 600;
    background-color: var(--bs-dark);
    color: var(--bs-border-color);
}
.del:hover{
    background-color: var(--bs-body-bg);
    color: var(--bs-body-color);
}
</style>