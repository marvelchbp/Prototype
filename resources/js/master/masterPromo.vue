<script setup>
    import MasterLayout from '../layoutsPage/Master.vue';
    import InputSearch from '../atoms/InputSearch.vue';
</script>

<script>
import axios from 'axios';
import { reactive, ref } from 'vue';

export default {
    components: {
        InputSearch,
    },
    data() {
        return {
            searchValue: reactive({ value: '' }),
            booleanUpdate: false,
            formPromoInsert: reactive({ kode_promo: '', deskripsi_promo: '', potongan: '' }),
            PromoInsert: reactive({ kode_promo: '', deskripsi_promo: '', potongan: '' }),
            formPromoUpdate: reactive({ kode_promo_Hid: '',kode_promo: '', deskripsi_promo: '', potongan: '' }),
            PromoUpdate: reactive({ kode_promo_Hid: '',kode_promo: '', deskripsi_promo: '', potongan: '' }),
            promoDel: reactive({ kode_promo: '', deleted_at: ''}),
            errorsInsert: ref([]),
            errorsUpdate: ref([]),
            pageLast: 0,
            pageNow: 0,
            promos: ref([]),
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
                    .post('api/v1/master/promosearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.promos.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageNow <= this.pageLast){
                    this.pageNow--;
                }
                axios
                    .get('api/v1/master/promo?page='+this.pageNow)
                    .then((res) => {
                        this.promos.values = res.data.data
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
                    .post('api/v1/master/promosearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.promos.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageLast > this.pageNow){
                    this.pageNow++;
                }
                axios
                    .get('api/v1/master/promo?page='+this.pageNow)
                    .then((res) => {
                        this.promos.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }
        },
        backToInsert(){
            this.booleanUpdate = false
            this.formPromoUpdate.kode_promo_Hid = '';
            this.formPromoUpdate.kode_promo = '';
            this.formPromoUpdate.deskripsi_promo = '';
            this.formPromoUpdate.potongan = '';
        },
        buttonClickForModalInsert(){
            this.PromoInsert.kode_promo = this.formPromoInsert.kode_promo;
            this.PromoInsert.deskripsi_promo = this.formPromoInsert.deskripsi_promo;
            this.PromoInsert.potongan = this.formPromoInsert.potongan;
        },
        buttonClickForModalUpdate(){
            this.PromoUpdate.kode_promo_Hid = this.formPromoUpdate.kode_promo_Hid;
            this.PromoUpdate.kode_promo = this.formPromoUpdate.kode_promo;
            this.PromoUpdate.deskripsi_promo = this.formPromoUpdate.deskripsi_promo;
            this.PromoUpdate.potongan = this.formPromoUpdate.potongan;
        },
        rowClicked(row){
            this.booleanUpdate = true;
            this.formPromoUpdate.kode_promo_Hid = row.kode_promo;
            this.formPromoUpdate.kode_promo = row.kode_promo;
            this.formPromoUpdate.potongan = row.potongan;
            if(row.deskripsi_promo != null){
                this.formPromoUpdate.deskripsi_promo = row.deskripsi_promo;
            }else {
                this.formPromoUpdate.deskripsi_promo = "";
            }
        },
        rowClickedTakeKode(row){
            this.promoDel.kode_promo = row.kode_promo;
            this.promoDel.deleted_at = row.deleted_at;
        },
        addPromo(){
            axios
                .post('api/v1/master/insertpromo',this.PromoInsert)
                .then((res)=> {
                    console.log(res)
                    alert(res.data.message)
                    this.errorsInsert = ref([])
                    this.formPromoInsert.kode_promo = ''
                    this.formPromoInsert.deskripsi_promo = ''
                    this.formPromoInsert.potongan = ''
                    this.showTable()
                })
                .catch((err) =>{
                    if(err){
                        this.errorsInsert.values = err.response.data.message
                    }
                });
        },
        updatePromo(){
            axios
                .post('api/v1/master/updatepromo',this.PromoUpdate)
                .then((res)=> {
                    alert(res.data.message)
                    this.errorsUpdate = ref([])
                    this.formPromoUpdate.kode_promo = ''
                    this.formPromoUpdate.deskripsi_promo = ''
                    this.formPromoUpdate.potongan = ''
                    this.showTable()
                    this.booleanUpdate = false
                })
                .catch((err) =>{
                    if(err){
                        this.errorsUpdate.values = err.response.data.message
                    }
                });
        },
        deletePromo(){
            axios
                .post('api/v1/master/deletepromo',this.promoDel)
                .then((res)=> {
                    console.log(res)
                    this.promoDel.kode_promo = ''
                    this.promoDel.deleted_at = ''
                    this.showTable()
                })
                .catch((err) =>{
                    console.log(err)
                });
        },
        searchMethod(){
            axios
                .post('api/v1/master/promosearch',this.searchValue)
                .then((res) => {
                    this.promos.values = res.data.data.data
                    this.pageNow = res.data.data.current_page
                    this.pageLast = res.data.data.last_page
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        showTable(){
            axios
                .get('api/v1/master/promo')
                .then((res) => {
                    this.promos.values = res.data.data
                    this.pageNow = res.data.meta.current_page;
                    this.pageLast = res.data.meta.last_page;
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
                    Master Promo
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
                                    <th scope="col" class="text-light">Kode Promo</th>
                                    <th scope="col" class="text-light">Deskripsi Promo</th>
                                    <th scope="col" class="text-light">Potongan (Persentase)</th>
                                    <th scope="col" class="text-light">Keterangan</th>
                                    <th scope="col" class="text-light">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider lbl-text bodtab text-center">
                            <!-- row -->
                                <tr v-for="promo in promos.values" :key="promo.kode_promo">
                                    <th scope="row" class="number">{{promo.kode_promo}}</th>
                                    <td>
                                        <div v-if="promo.deskripsi_promo != null">{{promo.deskripsi_promo}}</div>
                                        <div v-if="promo.deskripsi_promo == null">-</div>
                                    </td>
                                    <td>{{promo.potongan}}</td>
                                    <td> 
                                        <div v-if="promo.deleted_at == null" class="text-success fw-bold text-uppercase"> Aktif </div>
                                        <div v-if="promo.deleted_at != null" class="text-danger fw-bold text-uppercase"> Non Aktif </div>
                                    </td>
                                    <td>
                                        <button class="btn res" @click="rowClicked(promo)">Edit</button>
                                        <button v-if="promo.deleted_at == null" class="btn res del" @click="rowClickedTakeKode(promo)" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
                                        <button v-if="promo.deleted_at != null" class="btn res del" @click="rowClickedTakeKode(promo)" data-bs-toggle="modal" data-bs-target="#exampleModal">Restore</button>
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
                            <li class="page-item"><a class="page-link" >{{pageNow}}</a></li>
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Insert Promo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Menambahkan Data Promo dengan Kode {{PromoInsert.kode_promo.toUpperCase()}} ?
                        </div>
                        <form @submit.prevent="addPromo()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodePromoInsert" v-model="PromoInsert.kode_promo">
                            <input type="hidden" class="form-control lbl-text" id="deskripsiInsert" v-model="PromoInsert.deskripsi_promo">
                            <input type="hidden" class="form-control lbl-text" id="potonganInsert" v-model="PromoInsert.potongan">
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Promo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Mengubah Data Promo dengan Kode {{PromoUpdate.kode_promo.toUpperCase()}} ?
                        </div>
                        <form @submit.prevent="updatePromo()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodePromoHidInsert" v-model="PromoUpdate.kode_promo_Hid">
                            <input type="hidden" class="form-control lbl-text" id="kodePromoInsert" v-model="PromoUpdate.kode_promo">
                            <input type="hidden" class="form-control lbl-text" id="deskripsiInsert" v-model="PromoUpdate.deskripsi_promo">
                            <input type="hidden" class="form-control lbl-text" id="potonganInsert" v-model="PromoUpdate.potongan">
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
                    <div class="modal-body" v-if="promoDel.deleted_at == null">
                        Apakah Anda Yakin Untuk Menghapus data Promo dengan Kode "{{promoDel.kode_promo}}" ?
                    </div>
                    <div class="modal-body" v-if="promoDel.deleted_at != null">
                        Apakah Anda Yakin Untuk Mengembalikan data Promo dengan Kode "{{promoDel.kode_promo}}" ?
                    </div>
                    <form @submit.prevent="deletePromo()" method="post" class="d-grid">
                        <input type="hidden" class="form-control lbl-text" id="kodePegawaiDelete" v-model="promoDel.kode_promo">
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
                            <label for="KodePromo" class="form-label lbl-text fs-6 fw-bold">Kode Promo</label>
                            <input type="text" v-model="formPromoInsert.kode_promo" class="form-control lbl-text disabled" id="KodePromo" placeholder="Masukkan Kode Promo" aria-describedby="kodePromo" >
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.kode_promo">
                                {{ errorsInsert.values.kode_promo[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="DeskripsiPromo" class="form-label lbl-text fs-6 fw-bold">Deskripsi Promo</label>
                            <textarea class="form-control lbl-text" v-model="formPromoInsert.deskripsi_promo" id="DeskripsiPromo" placeholder="Masukkan Deskripsi Promo" rows="2"></textarea>
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.deskripsi_promo">
                                {{ errorsInsert.values.deskripsi_promo[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputPotongan" class="form-label lbl-text fs-6 fw-bold">Potongan ( Persentase )</label>
                            <input type="number" class="form-control lbl-text" v-model="formPromoInsert.potongan" id="InputPotongan" placeholder="Masukkan Potongan Dalam Persen (%)" aria-describedby="potongan" >
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.potongan">
                                {{ errorsInsert.values.potongan[0] }}
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
                            <label for="KodePromo" class="form-label lbl-text fs-6 fw-bold">Kode Promo</label>
                            <input type="hidden" v-model="formPromoUpdate.kode_promo_Hid" class="form-control lbl-text" id="KodePromoHIdden">
                            <input type="text" v-model="formPromoUpdate.kode_promo" class="form-control lbl-text" id="KodePromo" placeholder="Masukkan Kode Promo">
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.kode_promo">
                                {{ errorsUpdate.values.kode_promo[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="DeskripsiPromo" class="form-label lbl-text fs-6 fw-bold">Deskripsi Promo</label>
                            <textarea class="form-control lbl-text" v-model="formPromoUpdate.deskripsi_promo" id="DeskripsiPromo" placeholder="Masukkan Deskripsi Promo" rows="2"></textarea>
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.deskripsi_promo">
                                {{ errorsUpdate.values.deskripsi_promo[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputPotongan" class="form-label lbl-text fs-6 fw-bold">Potongan ( Persentase )</label>
                            <input type="number" class="form-control lbl-text" v-model="formPromoUpdate.potongan" id="InputPotongan" placeholder="Masukkan Potongan Dalam Persen (%)">
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.potongan">
                                {{ errorsUpdate.values.potongan[0] }}
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