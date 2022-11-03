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
            searchValue: reactive({ value: '' }),
            booleanUpdate: false,
            formSatuanInsert: reactive({ kode_satuan: '', faktor: '' }),
            SatuanInsert: reactive({ kode_satuan: '', faktor: '' }),
            formSatuanUpdate: reactive({ kode_satuan: '', faktor: '' }),
            SatuanUpdate: reactive({ kode_satuan: '', faktor: '' }),
            SatuanDel: reactive({ kode_satuan: '', deleted_at: ''}),
            errorsInsert: ref([]),
            errorsUpdate: ref([]),
            pageLast: 0,
            pageNow: 0,
            satuans: ref([]),
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
                    .post('api/v1/master/satuansearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.satuans.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageNow <= this.pageLast){
                    this.pageNow--;
                }
                axios
                    .get('api/v1/master/satuan?page='+this.pageNow)
                    .then((res) => {
                        this.satuans.values = res.data.data
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
                    .post('api/v1/master/satuansearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.satuans.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageLast > this.pageNow){
                    this.pageNow++;
                }
                axios
                    .get('api/v1/master/satuan?page='+this.pageNow)
                    .then((res) => {
                        this.satuans.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }
        },
        backToInsert(){
            this.booleanUpdate = false
            this.formSatuanUpdate.kode_satuan = '';
            this.formSatuanUpdate.faktor = '';
        },
        buttonClickForModalInsert(){
            this.SatuanInsert.kode_satuan = this.formSatuanInsert.kode_satuan;
            this.SatuanInsert.faktor = this.formSatuanInsert.faktor;
        },
        buttonClickForModalUpdate(){
            this.SatuanUpdate.kode_satuan = this.formSatuanUpdate.kode_satuan;
            this.SatuanUpdate.faktor = this.formSatuanUpdate.faktor;
        },
        rowClicked(row){
            this.booleanUpdate = true;
            this.formSatuanUpdate.kode_satuan = row.kode_satuan;
            this.formSatuanUpdate.faktor = row.faktor;
        },
        rowClickedTakeKode(row){
            this.SatuanDel.kode_satuan = row.kode_satuan;
            this.SatuanDel.deleted_at = row.deleted_at;
        },
        addSatuan(){
            axios
                .post('api/v1/master/insertsatuan',this.SatuanInsert)
                .then((res)=> {
                    console.log(res)
                    alert(res.data.message)
                    this.errorsInsert = ref([])
                    this.formSatuanInsert.kode_satuan = ''
                    this.formSatuanInsert.faktor = ''
                    this.showTable()
                })
                .catch((err) =>{
                    if(err){
                        this.errorsInsert.values = err.response.data.message
                    }
                });
        },
        updateSatuan(){
            axios
                .post('api/v1/master/updatesatuan',this.SatuanUpdate)
                .then((res)=> {
                    alert(res.data.message)
                    this.errorsUpdate = ref([])
                    this.formSatuanUpdate.kode_satuan = ''
                    this.formSatuanUpdate.faktor = ''
                    this.showTable()
                    this.booleanUpdate = false
                })
                .catch((err) =>{
                    if(err){
                        this.errorsUpdate.values = err.response.data.message
                    }
                });
        },
        deleteSatuan(){
            axios
                .post('api/v1/master/deletesatuan',this.SatuanDel)
                .then((res)=> {
                    console.log(res)
                    alert(res.data.message)
                    this.SatuanDel.kode_satuan = ''
                    this.SatuanDel.deleted_at = ''
                    this.showTable()
                })
                .catch((err) =>{
                    console.log(err)
                });
        },
        showTable(){
            axios
                .get('api/v1/master/satuan')
                .then((res) => {
                    this.satuans.values = res.data.data
                    this.pageNow = res.data.meta.current_page;
                    this.pageLast = res.data.meta.last_page;
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        searchMethod(){
            axios
                .post('api/v1/master/satuansearch',this.searchValue)
                .then((res) => {
                    this.satuans.values = res.data.data.data
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
                    Master Satuan
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
                                    <th scope="col" class="text-light">Kode Satuan</th>
                                    <th scope="col" class="text-light">Faktor</th>
                                    <th scope="col" class="text-light">Keterangan</th>
                                    <th scope="col" class="text-light">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider lbl-text bodtab text-center">
                            <!-- row -->
                                <tr v-for="satuan in satuans.values" :key="satuan.kode_satuan">
                                    <th scope="row" class="number">{{satuan.kode_satuan}}</th>
                                    <td>{{satuan.faktor}}</td>
                                    <td> 
                                        <div v-if="satuan.deleted_at == null" class="text-success fw-bold text-uppercase"> Aktif </div>
                                        <div v-if="satuan.deleted_at != null" class="text-danger fw-bold text-uppercase"> Non Aktif </div>
                                    </td>
                                    <td>
                                        <button class="btn res" @click="rowClicked(satuan)">Edit</button>
                                        <button v-if="satuan.deleted_at == null" class="btn res del" @click="rowClickedTakeKode(satuan)" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
                                        <button v-if="satuan.deleted_at != null" class="btn res del" @click="rowClickedTakeKode(satuan)" data-bs-toggle="modal" data-bs-target="#exampleModal">Restore</button>
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Insert Satuan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Menambahkan Data Satuan dengan Kode {{SatuanInsert.kode_satuan.toUpperCase()}} ?
                        </div>
                        <form @submit.prevent="addSatuan()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodeInsert" v-model="SatuanInsert.kode_satuan">
                            <input type="hidden" class="form-control lbl-text" id="FaktorInsert" v-model="SatuanInsert.faktor">
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Satuan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Mengubah Data Satuan dengan Kode {{SatuanUpdate.kode_satuan.toUpperCase()}} ?
                        </div>
                        <form @submit.prevent="updateSatuan()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodeInsert" v-model="SatuanUpdate.kode_satuan">
                            <input type="hidden" class="form-control lbl-text" id="FaktorInsert" v-model="SatuanUpdate.faktor">
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Promo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" v-if="SatuanDel.deleted_at == null">
                            Apakah Anda Yakin Untuk Menghapus data Satuan "{{SatuanDel.kode_satuan}}" ?
                        </div>
                        <div class="modal-body" v-if="SatuanDel.deleted_at != null">
                            Apakah Anda Yakin Untuk Mengembalikan data Satuan "{{SatuanDel.kode_satuan}}" ?
                        </div>
                        <form @submit.prevent="deleteSatuan()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodePegawaiDelete" v-model="SatuanDel.kode_satuan">
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
                            <label for="KodePromo" class="form-label lbl-text fs-6 fw-bold">Kode Satuan</label>
                            <input type="text" v-model="formSatuanInsert.kode_satuan" class="form-control lbl-text" id="KodeSatuan" placeholder="Masukkan Kode Satuan" aria-describedby="kodePromo" >
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.kode_satuan">
                                {{ errorsInsert.values.kode_satuan[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="DeskripsiPromo" class="form-label lbl-text fs-6 fw-bold">Faktor</label>
                            <input type="number" v-model="formSatuanInsert.faktor" class="form-control lbl-text" id="faktor" placeholder="Masukkan Faktor" >
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.faktor">
                                {{ errorsInsert.values.faktor[0] }}
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
                            <label for="KodePromo" class="form-label lbl-text fs-6 fw-bold">Kode Satuan</label>
                            <input type="text" v-model="formSatuanUpdate.kode_satuan" class="form-control lbl-text" id="KodeSatuan" placeholder="Masukkan Kode Satuan" aria-describedby="kodePromo" disabled>
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.kode_satuan">
                                {{ errorsUpdate.values.kode_satuan[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="DeskripsiPromo" class="form-label lbl-text fs-6 fw-bold">Faktor</label>
                            <input type="number" v-model="formSatuanUpdate.faktor" class="form-control lbl-text" id="faktor" placeholder="Masukkan Faktor" >
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.faktor">
                                {{ errorsUpdate.values.faktor[0] }}
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