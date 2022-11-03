<script setup>
import MasterLayout from '../layoutsPage/Master.vue';
import InputSearch from '../atoms/InputSearch.vue';
</script>

<script>
import Datepicker from "vue3-datepicker";
import axios from 'axios';
import moment, { now } from 'moment';
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
    components: {
        Datepicker,
        InputSearch,
    },
    data() {
        return {
            searchValue: reactive({ value: '' }),
            formJabatan: reactive({ id: '', email: '', jabatan: '' }),
            JabatanInsert: reactive({ email: '' }),
            formCuti: reactive({ id: '', email: '', tglAwal: ref(new Date(Date.now())), tglAkhir: ref(new Date(Date.now())) }),
            CutiInsert: reactive({ email: '' }),
            CutiDelete: reactive({ email: '' }),
            errors: ref([]),
            errorsCuti: ref([]),
            errorsCutiDel: ref([]),
            router: useRouter(),
            pageLast: 0,
            pageNow: 0,
            users: ref([]),
            buttonClick: "",
            pegawai: reactive({id: '', nama: '', deleted_at: ''}),
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
                    .post('api/v1/master/pegawaisearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.users.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageNow <= this.pageLast){
                    this.pageNow--;
                }
                axios
                    .get('api/v1/master/pegawai?page='+this.pageNow)
                    .then((res) => {
                        this.users.values = res.data.data
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
                    .post('api/v1/master/pegawaisearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.users.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageLast > this.pageNow){
                    this.pageNow++;
                }
                axios
                    .get('api/v1/master/pegawai?page='+this.pageNow)
                    .then((res) => {
                        this.users.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }
        },
        buttonClickForModalInsertJabatan(){
            this.JabatanInsert.email = this.formJabatan.email;
        },
        buttonClickForModalInsertCuti(){
            this.CutiInsert.email = this.formCuti.email;
        },
        buttonClickForModalDeleteCuti(){
            this.CutiDelete.email = this.formCuti.email;
        },
        rowClickedCuti(row){
            this.formCuti.id = row.id;
            this.formCuti.email = row.email;
            if(row.tanggalAwalCuti != null){
                this.formCuti.tglAwal = ref(new Date(row.tanggalAwalCuti));
            }
            if(row.tanggalAkhirCuti != null){
                this.formCuti.tglAkhir = ref(new Date(row.tanggalAkhirCuti));
            }
        },
        rowClickedTakeId(row){
            this.pegawai.id = row.id;
            this.pegawai.nama = row.name;
            this.pegawai.deleted_at = row.deleted_at;
        },
        rowClicked(row){
            this.formJabatan.id = row.id;
            this.formJabatan.email = row.email;
        },
        rowClickedWithJabatan(row){
            this.formJabatan.id = row.id;
            this.formJabatan.email = row.email;
            this.formJabatan.jabatan = row.jabatan;
        },
        addJabatan(){
            axios
                .post('api/v1/master/jabatanPegawai',this.formJabatan)
                .then((res)=> {
                    alert(res.data.message)
                    this.errors = ref([])
                    this.formJabatan.id = ''
                    this.formJabatan.email = ''
                    this.formJabatan.jabatan = ''
                    this.showTable()
                })
                .catch((err) =>{
                    if(err){
                        this.errors.values = err.response.data.message
                    }
                });
        },
        addCuti(){
            axios
                .post('api/v1/master/addCuti',this.formCuti)
                .then((res)=> {
                    console.log(res)
                    this.errorsCuti = ref([])
                    this.errorsCutiDel = ref([])
                    this.formCuti.id = ''
                    this.formCuti.email = ''
                    this.formCuti.tglAwal = ref(new Date(Date.now()))
                    this.formCuti.tglAkhir = ref(new Date(Date.now()))
                    this.showTable()
                    alert(res.data.message)
                })
                .catch((err) =>{
                    if(err){
                        this.errorsCuti.values = err.response.data.message
                        this.errorsCutiDel = ref([])
                    }
                });
        },
        deleteCuti(){
            axios
                .post('api/v1/master/deleteCuti',this.formCuti)
                .then((res)=> {
                    this.errorsCuti = ref([])
                    this.errorsCutiDel = ref([])
                    this.formCuti.id = ''
                    this.formCuti.email = ''
                    this.formCuti.tglAwal = ref(new Date(Date.now()))
                    this.formCuti.tglAkhir = ref(new Date(Date.now()))
                    this.showTable()
                    alert(res.data.message)
                })
                .catch((err) =>{
                    if(err){
                        this.errorsCutiDel.values = err.response.data.message
                        this.errorsCuti = ref([])
                    }
                });
        },
        deletePegawai(){
            axios
                .post('api/v1/master/deletePegawai',this.pegawai)
                .then((res)=> {
                    console.log(res)
                    this.pegawai.id = ''
                    this.pegawai.nama = ''
                    this.pegawai.deleted_at = ''
                    this.showTable()
                })
                .catch((err) =>{
                    console.log(err)
                });
        },
        showTable(){
            axios
                .get('api/v1/master/pegawai')
                .then((res) => {
                    this.users.values = res.data.data
                    this.pageNow = res.data.meta.current_page
                    this.pageLast = res.data.meta.last_page
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        searchMethod(){
            axios
                .post('api/v1/master/pegawaisearch',this.searchValue)
                .then((res) => {
                    this.users.values = res.data.data.data
                    this.pageNow = res.data.data.current_page
                    this.pageLast = res.data.data.last_page
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        submitButton(value){
            if(value == "Delete"){
                this.buttonClick = value;
            }else if(value == "Submit"){
                this.buttonClick = value;
            }
        }
    },
};
</script>

<template>
    <MasterLayout>
        <div class="w-100">
            <div class="w-50 mt-5 mx-auto">
                <h1 class="fs-1 text-start header-text">
                    Master Pegawai
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
                                    <th scope="col" class="text-light">Id</th>
                                    <th scope="col" class="text-light">Email Pegawai</th>
                                    <th scope="col" class="text-light">Nama Pegawai</th>
                                    <th scope="col" class="text-light">No. Telp</th>
                                    <th scope="col" class="text-light">Jabatan</th>
                                    <th scope="col" class="text-light">Tanggal Awal Cuti</th>
                                    <th scope="col" class="text-light">Tanggal Akhir Cuti</th>
                                    <th scope="col" class="text-light">Jumlah Cuti (Hari)</th>
                                    <th scope="col" class="text-light">Keterangan</th>
                                    <th scope="col" class="text-light">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider lbl-text bodtab text-center">
                            <!-- row -->
                                <tr v-for="user in users.values" :key="user.id">
                                    <th scope="row" class="number">{{user.id}}</th>
                                    <td>{{user.email}}</td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.phone}}</td>
                                    <td><div v-if="user.jabatan != null" @click="rowClickedWithJabatan(user)" style="cursor:pointer">{{user.jabatan}}</div>
                                        <div v-if="user.jabatan == null" @click="rowClicked(user)" class="text-danger" style="cursor:pointer">None</div></td>
                                    <td>
                                        <div v-if="user.tanggalAwalCuti != null">{{moment(user.tanggalAwalCuti).format('DD MMM YYYY')}}</div>
                                        <div v-if="user.tanggalAwalCuti == null">-</div>
                                    </td>
                                    <td>
                                        <div v-if="user.tanggalAkhirCuti != null">{{moment(user.tanggalAkhirCuti).format('DD MMM YYYY')}}</div>
                                        <div v-if="user.tanggalAkhirCuti == null">-</div>
                                    </td>
                                    <td>
                                        <div v-if="user.jumlahCuti != null">{{user.jumlahCuti}}</div>
                                        <div v-if="user.jumlahCuti == null">-</div>
                                    </td>
                                    <td>
                                        <div v-if="user.deleted_at == null" class="text-success fw-bold text-uppercase"> Aktif </div>
                                        <div v-if="user.deleted_at != null" class="text-danger fw-bold text-uppercase"> Non Aktif </div> </td>
                                    <td>
                                        <button class="btn edt" @click="rowClickedCuti(user)">Edit</button>
                                        <button v-if="user.deleted_at == null" class="btn edt del" @click="rowClickedTakeId(user)" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
                                        <button v-if="user.deleted_at != null" class="btn edt del" @click="rowClickedTakeId(user)" data-bs-toggle="modal" data-bs-target="#exampleModal">Restore</button>
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
            <div class="modal fade" id="exampleModalInsertJabatan" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Insert Jabatan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Menambahkan Data Jabatan dengan Email {{JabatanInsert.email}} ?
                        </div>
                        <form @submit.prevent="addJabatan()" method="post" class="d-grid">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- MODAL INSERT CUTI -->
            <div class="modal fade" id="exampleModalInsertCuti" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Insert Cuti Pegawai</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Menambahkan Data Cuti Pegawai dengan Email {{CutiInsert.email}} ?
                        </div>
                        <form @submit.prevent="addCuti()" method="post" class="d-grid">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- MODAL DELETE CUTI -->
            <div class="modal fade" id="exampleModalDeleteCuti" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Cuti Pegawai</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Menghapus Data Cuti Pegawai dengan Email {{CutiDelete.email}} ?
                        </div>
                        <form @submit.prevent="deleteCuti()" method="post" class="d-grid">
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Pegawai</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" v-if="pegawai.deleted_at == null">
                        Apakah Anda Yakin Untuk Menghapus data Pegawai {{pegawai.nama}} ?
                    </div>
                    <div class="modal-body" v-if="pegawai.deleted_at != null">
                        Apakah Anda Yakin Untuk Mengembalikan data Pegawai {{pegawai.nama}} ?
                    </div>
                    <form @submit.prevent="deletePegawai()" method="post" class="d-grid">
                        <input type="hidden" class="form-control lbl-text" id="idPegawaiForCuti" v-model="pegawai.id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-- Input -->
            <div class="w-50 d-flex flex-row align-items-start justify-content-center">
                <div class="w-50 py-5 mt-4 mx-2">
                    <form method="post" class="d-grid">
                        <div class="mb-3">
                            <h5 class="text-start header-text mb-4">
                                Input Cuti Pegawai
                            </h5>
                            <input type="hidden" class="form-control lbl-text" id="idPegawaiForCuti" v-model="formCuti.id">
                            <label for="date" class="form-label lbl-text fs-6 fw-bold">Email</label>
                            <div class="input-group date">
                                <input type="email" class="form-control lbl-text" id="emailCuti" placeholder="Berisi Email" disabled v-model="formCuti.email">
                            </div>
                            <div class="fs-6 text-danger" v-if="errorsCuti.values.email">
                                {{ errorsCuti.values.email[0] }}
                            </div>
                            <div class="fs-6 text-danger" v-if="errorsCutiDel.values.email">
                                {{ errorsCutiDel.values.email[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label lbl-text fs-6 fw-bold">Tanggal Awal Cuti</label>
                            <Datepicker class="form-control lbl-text w-100" v-model="formCuti.tglAwal" :typeable="true"/>
                            <div class="fs-6 text-danger" v-if="errorsCuti.values.tglAwal">
                                {{ errorsCuti.values.tglAwal[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label lbl-text fs-6 fw-bold">Tanggal Akhir Cuti</label>
                            <Datepicker class="form-control lbl-text w-100" v-model="formCuti.tglAkhir" :typeable="true"/>
                            <div class="fs-6 text-danger" v-if="errorsCuti.values.tglAkhir">
                                {{ errorsCuti.values.tglAkhir[0] }}
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mt-3 mb-5">
                            <button type="button" @click="buttonClickForModalInsertCuti()" data-bs-toggle="modal" data-bs-target="#exampleModalInsertCuti" class="btn px-4 py-2 rounded-md me-auto">
                                Submit
                            </button>
                            <button type="button" @click="buttonClickForModalDeleteCuti()" data-bs-toggle="modal" data-bs-target="#exampleModalDeleteCuti" class="btn px-4 py-2 rounded-md">
                                Delete
                            </button>
                        </div>
                    </form>
                </div>
                <div class="w-50 py-5 mt-4 mx-2">
                    <form method="post" class="d-grid">
                        <div class="mb-3">
                            <h5 class="text-start header-text mb-4">
                                Input Jabatan Pegawai
                            </h5>
                            <input 
                                type="hidden" 
                                class="form-control lbl-text" 
                                id="idPegawaiForJabatan" 
                                :value="formJabatan.id"
                            >
                            <label for="email" class="form-label lbl-text fs-6 fw-bold">Email</label>
                            <div class="input-group date">
                                <input 
                                    type="text" 
                                    class="form-control lbl-text"  
                                    id="emailForJabatan" 
                                    :value="formJabatan.email"
                                    placeholder="Berisi Email" disabled
                                >
                            </div>
                            <div class="fs-6 text-danger" v-if="errors.values.email">
                                {{ errors.values.email[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label lbl-text fs-6 fw-bold">Jabatan</label>
                            <div class="input-group date">
                                <input type="text" v-model="formJabatan.jabatan" class="form-control lbl-text" id="jabatan" placeholder="Masukkan Jabatan">
                            </div>
                            <div class="fs-6 text-danger" v-if="errors.values.jabatan">
                                {{ errors.values.jabatan[0] }}
                            </div>
                            <div id="jabatanHelpBlock" class="form-text">
                                Jabatan Hanya Bisa 3 Jenis Yaitu Admin, Kasir, dan Pegawai
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mt-3 mb-5">
                            <button type="button" @click="buttonClickForModalInsertJabatan()" data-bs-toggle="modal" data-bs-target="#exampleModalInsertJabatan" class="btn px-4 py-2 rounded-md ml-4 w-20">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </MasterLayout>
</template>

<style scoped>
.edt{
    width: 5rem;
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