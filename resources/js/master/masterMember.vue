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
            formMemberInsert: reactive({ nama: '', wilayah: '', alamat: '', telp: '' }),
            MemberInsert: reactive({ nama: '', wilayah: '', alamat: '', telp: '' }),
            formMemberUpdate: reactive({ kode: '', nama: '', wilayah: '', alamat: '', telp: '' }),
            MemberUpdate: reactive({ kode: '', nama: '', wilayah: '', alamat: '', telp: '' }),
            memberDel: reactive({ kode: '', nama: '', deleted_at: ''}),
            errorsInsert: ref([]),
            errorsUpdate: ref([]),
            pageLast: 0,
            pageNow: 0,
            members: ref([]),
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
                    .post('api/v1/master/membersearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.members.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageNow <= this.pageLast){
                    this.pageNow--;
                }
                axios
                    .get('api/v1/master/member?page='+this.pageNow)
                    .then((res) => {
                        this.members.values = res.data.data
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
                    .post('api/v1/master/membersearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.members.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageLast > this.pageNow){
                    this.pageNow++;
                }
                axios
                    .get('api/v1/master/member?page='+this.pageNow)
                    .then((res) => {
                        this.members.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }
        },
        backToInsert(){
            this.booleanUpdate = false
            this.formMemberUpdate.kode = '';
            this.formMemberUpdate.nama = '';
            this.formMemberUpdate.wilayah = '';
            this.formMemberUpdate.alamat = '';
            this.formMemberUpdate.telp = '';
        },
        buttonClickForModalInsert(){
            this.MemberInsert.nama = this.formMemberInsert.nama;
            this.MemberInsert.wilayah = this.formMemberInsert.wilayah;
            this.MemberInsert.alamat = this.formMemberInsert.alamat;
            this.MemberInsert.telp = this.formMemberInsert.telp;
        },
        buttonClickForModalUpdate(){
            this.MemberUpdate.kode = this.formMemberUpdate.kode;
            this.MemberUpdate.nama = this.formMemberUpdate.nama;
            this.MemberUpdate.wilayah = this.formMemberUpdate.wilayah;
            this.MemberUpdate.alamat = this.formMemberUpdate.alamat;
            this.MemberUpdate.telp = this.formMemberUpdate.telp;
        },
        rowClicked(row){
            this.booleanUpdate = true;
            this.formMemberUpdate.kode = row.kode_member;
            this.formMemberUpdate.nama = row.nama_member;
            if(row.wilayah != null){
                this.formMemberUpdate.wilayah = row.wilayah;
            }else {
                this.formMemberUpdate.wilayah = "";
            }
            if(row.alamat != null){
                this.formMemberUpdate.alamat = row.alamat;
            }else {
                this.formMemberUpdate.alamat = "";
            }
            if(row.telp_member != null){
                this.formMemberUpdate.telp = row.telp_member;
            }else {
                this.formMemberUpdate.telp = "";
            }
        },
        rowClickedTakeKode(row){
            this.memberDel.kode = row.kode_member;
            this.memberDel.nama = row.nama_member;
            this.memberDel.deleted_at = row.deleted_at;
        },
        addMember(){
            axios
                .post('api/v1/master/insertmember',this.MemberInsert)
                .then((res)=> {
                    alert(res.data.message)
                    this.errorsInsert = ref([])
                    this.formMemberInsert.nama = ''
                    this.formMemberInsert.wilayah = ''
                    this.formMemberInsert.alamat = ''
                    this.formMemberInsert.telp = ''
                    this.showTable()
                })
                .catch((err) =>{
                    if(err){
                        this.errorsInsert.values = err.response.data.message
                    }
                });
        },
        updateMember(){
            axios
                .post('api/v1/master/updatemember',this.MemberUpdate)
                .then((res)=> {
                    alert(res.data.message)
                    this.errorsUpdate = ref([])
                    this.formMemberUpdate.nama = ''
                    this.formMemberUpdate.wilayah = ''
                    this.formMemberUpdate.alamat = ''
                    this.formMemberUpdate.telp = ''
                    this.showTable()
                    this.booleanUpdate = false
                })
                .catch((err) =>{
                    if(err){
                        this.errorsUpdate.values = err.response.data.message
                    }
                });
        },
        deleteMember(){
            axios
                .post('api/v1/master/deletemember',this.memberDel)
                .then((res)=> {
                    alert(res.data.message)
                    this.memberDel.kode = ''
                    this.memberDel.nama = ''
                    this.memberDel.deleted_at = ''
                    this.showTable()
                })
                .catch((err) =>{
                    console.log(err)
                });
        },
        showTable(){
            axios
                .get('api/v1/master/member')
                .then((res) => {
                    this.members.values = res.data.data
                    this.pageNow = res.data.meta.current_page;
                    this.pageLast = res.data.meta.last_page;
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        searchMethod(){
            axios
                .post('api/v1/master/membersearch',this.searchValue)
                .then((res) => {
                    this.members.values = res.data.data.data
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
                    Master Member
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
                                    <th scope="col" class="text-light">Kode Member</th>
                                    <th scope="col" class="text-light">Nama Member</th>
                                    <th scope="col" class="text-light">Wilayah</th>
                                    <th scope="col" class="text-light">Alamat</th>
                                    <th scope="col" class="text-light">No. Telp</th>
                                    <th scope="col" class="text-light">Keterangan</th>
                                    <th scope="col" class="text-light">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider lbl-text bodtab text-center">
                            <!-- row -->
                                <tr v-for="member in members.values" :key="member.kode_member">
                                    <th scope="row" class="number">{{member.kode_member}}</th>
                                    <td>{{member.nama_member}}</td>
                                    <td>{{member.wilayah}}</td>
                                    <td>{{member.alamat}}</td>
                                    <td>{{member.nomor_telepon_member}}</td>
                                    <td> 
                                        <div v-if="member.deleted_at == null" class="text-success fw-bold text-uppercase"> Aktif </div>
                                        <div v-if="member.deleted_at != null" class="text-danger fw-bold text-uppercase"> Non Aktif </div>
                                    </td>
                                    <td>
                                        <button class="btn" @click="rowClicked(member)" >Edit</button>
                                        <button v-if="member.deleted_at == null" class="btn res del" @click="rowClickedTakeKode(member)" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
                                        <button v-if="member.deleted_at != null" class="btn res del" @click="rowClickedTakeKode(member)" data-bs-toggle="modal" data-bs-target="#exampleModal">Restore</button>
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Insert Member</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Menambahkan Data Member dengan Nama {{MemberInsert.nama}} ?
                        </div>
                        <form @submit.prevent="addMember()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="namaInsert" v-model="MemberInsert.nama">
                            <input type="hidden" class="form-control lbl-text" id="wilayahInsert" v-model="MemberInsert.wilayah">
                            <input type="hidden" class="form-control lbl-text" id="alamatInsert" v-model="MemberInsert.alamat">
                            <input type="hidden" class="form-control lbl-text" id="telpInsert" v-model="MemberInsert.telp">
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Member</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Mengubah Data Member dengan Nama {{MemberUpdate.nama}} ?
                        </div>
                        <form @submit.prevent="updateMember()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="namaInsert" v-model="MemberUpdate.kode">
                            <input type="hidden" class="form-control lbl-text" id="namaInsert" v-model="MemberUpdate.nama">
                            <input type="hidden" class="form-control lbl-text" id="wilayahInsert" v-model="MemberUpdate.wilayah">
                            <input type="hidden" class="form-control lbl-text" id="alamatInsert" v-model="MemberUpdate.alamat">
                            <input type="hidden" class="form-control lbl-text" id="telpInsert" v-model="MemberUpdate.telp">
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Member</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" v-if="memberDel.deleted_at == null">
                            Apakah Anda Yakin Untuk Menghapus data Member dengan Kode "{{memberDel.nama}}" ?
                        </div>
                        <div class="modal-body" v-if="memberDel.deleted_at != null">
                            Apakah Anda Yakin Untuk Mengembalikan data Member dengan Kode "{{memberDel.nama}}" ?
                        </div>
                        <form @submit.prevent="deleteMember()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodePegawaiDelete" v-model="memberDel.kode">
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
                            <label for="NamaMember" class="form-label lbl-text fs-6 fw-bold">Nama Member</label>
                            <input type="text" class="form-control lbl-text" v-model="formMemberInsert.nama" id="NamaMember" placeholder="Masukkan Nama Member" aria-describedby="namaMember">
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.nama">
                                {{ errorsInsert.values.nama[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputAlamat" class="form-label lbl-text fs-6 fw-bold">Wilayah</label>
                            <input type="text" class="form-control lbl-text" v-model="formMemberInsert.wilayah" id="InputWilayah" placeholder="Masukkan Wilayah" aria-describedby="wilayah" >
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.wilayah">
                                {{ errorsInsert.values.wilayah[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputAlamat" class="form-label lbl-text fs-6 fw-bold">Alamat</label>
                            <input type="text" class="form-control lbl-text" v-model="formMemberInsert.alamat" id="InputAlamat" placeholder="Masukkan Alamat" aria-describedby="alamat" >
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.alamat">
                                {{ errorsInsert.values.alamat[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputNomorTelepon" class="form-label lbl-text fs-6 fw-bold">Nomor Telepon</label>
                            <input type="text" class="form-control lbl-text" v-model="formMemberInsert.telp" id="InputNomorTelepon" placeholder="Masukkan Nomor Telepon" aria-describedby="nomorTelepon" >
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.telp">
                                {{ errorsInsert.values.telp[0] }}
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
                            <label for="NamaMember" class="form-label lbl-text fs-6 fw-bold">Nama Member</label>
                            <input type="hidden" v-model="formMemberUpdate.kode" class="form-control lbl-text" id="kodeMember">
                            <input type="text" v-model="formMemberUpdate.nama" class="form-control lbl-text" id="NamaMember" placeholder="Masukkan Nama Member" aria-describedby="namaMember">
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.nama">
                                {{ errorsUpdate.values.nama[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputAlamat" class="form-label lbl-text fs-6 fw-bold">Wilayah</label>
                            <input type="text" v-model="formMemberUpdate.wilayah" class="form-control lbl-text" id="InputWilayah" placeholder="Masukkan Wilayah" aria-describedby="wilayah" >
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.wilayah">
                                {{ errorsUpdate.values.wilayah[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputAlamat" class="form-label lbl-text fs-6 fw-bold">Alamat</label>
                            <input type="text" v-model="formMemberUpdate.alamat" class="form-control lbl-text" id="InputAlamat" placeholder="Masukkan Alamat" aria-describedby="alamat" >
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.alamat">
                                {{ errorsUpdate.values.alamat[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputNomorTelepon" class="form-label lbl-text fs-6 fw-bold">Nomor Telepon</label>
                            <input type="text" v-model="formMemberUpdate.telp" class="form-control lbl-text" id="InputNomorTelepon" placeholder="Masukkan Nomor Telepon" aria-describedby="nomorTelepon" >
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.telp">
                                {{ errorsUpdate.values.telp[0] }}
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