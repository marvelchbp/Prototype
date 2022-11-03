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
            formBarangInsert: reactive({ kode_barang: '', barcode: '', nama_barang: '', kategori_barang: '', satuan: '', harga_grosir: '', harga_eceran: '', harga_khusus: '', deskripsi: '' }),
            formBarangUpdate: reactive({ kode_barang: '', barcode: '', nama_barang: '', kategori_barang: '', satuan: '', harga_grosir: '', harga_eceran: '', harga_khusus: '', deskripsi: '' }),
            barangDel: reactive({ kode: '', nama: '', deleted_at: ''}),
            errorsInsert: ref([]),
            errorsUpdate: ref([]),
            pageLast: 0,
            pageNow: 0,
            kategoris: ref([]),
            satuans: ref([]),
            barangs: ref([]),
            barangInsert: reactive({ kode: '', kode_barang: '', barcode: '', nama_barang: '', kategori_barang: '', satuan: '', harga_grosir: '', harga_eceran: '', harga_khusus: '', deskripsi: '' }),
            barangUpdate: reactive({ kode: '', kode_barang: '', barcode: '', nama_barang: '', kategori_barang: '', satuan: '', harga_grosir: '', harga_eceran: '', harga_khusus: '', deskripsi: '' }),
        };
    },
    created() {
    },
    mounted() {
        this.showTable();
        this.showKategori();
        this.showSatuan();
    },
    methods: {
        backToInsert(){
            this.booleanUpdate = false
            this.formBarangUpdate.kode_barang = '';
            this.formBarangUpdate.barcode = '';
            this.formBarangUpdate.nama_barang = '';
            this.formBarangUpdate.kategori_barang = '';
            this.formBarangUpdate.satuan = '';
            this.formBarangUpdate.harga_grosir = '';
            this.formBarangUpdate.harga_eceran = '';
            this.formBarangUpdate.harga_khusus = '';
            this.formBarangUpdate.deskripsi = '';
        },
        decrementPageFrom(){
            if(this.searchValue.value != ''){
                if(this.pageNow <= this.pageLast){
                    this.pageNow--;
                }
                axios
                    .post('api/v1/master/barangsearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.barangs.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageNow <= this.pageLast){
                    this.pageNow--;
                }
                axios
                    .get('api/v1/master/barang?page='+this.pageNow)
                    .then((res) => {
                        this.barangs.values = res.data.data
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
                    .post('api/v1/master/barangsearch?page='+this.pageNow,this.searchValue)
                    .then((res) => {
                        this.barangs.values = res.data.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }else{
                if(this.pageLast > this.pageNow){
                    this.pageNow++;
                }
                axios
                    .get('api/v1/master/barang?page='+this.pageNow)
                    .then((res) => {
                        this.barangs.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            }
        },
        buttonClickForModalInsert(){
            this.barangInsert.kode = this.formBarangInsert.kode_barang;
            this.barangInsert.kode_barang = this.formBarangInsert.kode_barang;
            this.barangInsert.barcode = this.formBarangInsert.barcode;
            this.barangInsert.nama_barang = this.formBarangInsert.nama_barang;
            this.barangInsert.kategori_barang = this.formBarangInsert.kategori_barang;
            this.barangInsert.satuan = this.formBarangInsert.satuan;
            this.barangInsert.harga_grosir = this.formBarangInsert.harga_grosir;
            this.barangInsert.harga_eceran = this.formBarangInsert.harga_eceran;
            this.barangInsert.harga_khusus = this.formBarangInsert.harga_khusus;
            this.barangInsert.deskripsi = this.formBarangInsert.deskripsi;
        },
        buttonClickForModalUpdate(){
            this.barangUpdate.kode = this.formBarangUpdate.kode_barang;
            this.barangUpdate.kode_barang = this.formBarangUpdate.kode_barang;
            this.barangUpdate.barcode = this.formBarangUpdate.barcode;
            this.barangUpdate.nama_barang = this.formBarangUpdate.nama_barang;
            this.barangUpdate.kategori_barang = this.formBarangUpdate.kategori_barang;
            this.barangUpdate.satuan = this.formBarangUpdate.satuan;
            this.barangUpdate.harga_grosir = this.formBarangUpdate.harga_grosir;
            this.barangUpdate.harga_eceran = this.formBarangUpdate.harga_eceran;
            this.barangUpdate.harga_khusus = this.formBarangUpdate.harga_khusus;
            this.barangUpdate.deskripsi = this.formBarangUpdate.deskripsi;
        },
        rowClicked(row){
            this.booleanUpdate = true;
            this.formBarangUpdate.kode_barang = row.kode_barang;
            this.formBarangUpdate.barcode = row.barcode;
            this.formBarangUpdate.nama_barang = row.nama_barang;
            this.formBarangUpdate.kategori_barang = row.kode_kategori;
            this.formBarangUpdate.satuan = row.satuan;
            this.formBarangUpdate.harga_grosir = row.harga_grosir;
            this.formBarangUpdate.harga_eceran = row.harga_eceran;
            this.formBarangUpdate.harga_khusus = row.harga_khusus;
            this.formBarangUpdate.deskripsi = row.deskripsi;
        },
        rowClickedTakeKode(row){
            this.barangDel.kode = row.kode_barang;
            this.barangDel.nama = row.nama_barang;
            this.barangDel.deleted_at = row.deleted_at;
        },
        addBarang(){
            axios
                .post('api/v1/master/insertbarang',this.barangInsert)
                .then((res)=> {
                    console.log(res)
                    this.errorsInsert = ref([])
                    this.formBarangInsert.kode_barang = ''
                    this.formBarangInsert.barcode = ''
                    this.formBarangInsert.nama_barang = ''
                    this.formBarangInsert.kategori_barang = ''
                    this.formBarangInsert.satuan = ''
                    this.formBarangInsert.harga_grosir = ''
                    this.formBarangInsert.harga_eceran = ''
                    this.formBarangInsert.harga_khusus = ''
                    this.formBarangInsert.deskripsi = ''
                    this.showTable()
                })
                .catch((err) =>{
                    if(err){
                        this.errorsInsert.values = err.response.data.message
                    }
                });
        },
        updateBarang(){
            axios
                .post('api/v1/master/updatebarang',this.barangUpdate)
                .then((res)=> {
                    alert(res.data.message)
                    this.errorsUpdate = ref([])
                    this.formBarangUpdate.kode_barang = ''
                    this.formBarangUpdate.barcode = ''
                    this.formBarangUpdate.nama_barang = ''
                    this.formBarangUpdate.kategori_barang = ''
                    this.formBarangUpdate.satuan = ''
                    this.formBarangUpdate.harga_grosir = ''
                    this.formBarangUpdate.harga_eceran = ''
                    this.formBarangUpdate.harga_khusus = ''
                    this.formBarangUpdate.deskripsi = ''
                    this.showTable()
                    this.booleanUpdate = false
                })
                .catch((err) =>{
                    if(err){
                        this.errorsUpdate.values = err.response.data.message
                    }
                });
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
                .get('api/v1/master/barang')
                .then((res) => {
                    this.barangs.values = res.data.data
                    this.pageNow = res.data.meta.current_page
                    this.pageLast = res.data.meta.last_page
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        showKategori(){
            axios
                .get('api/v1/master/kategoriselect')
                .then((res) => {
                    this.kategoris.values = res.data.data
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        showSatuan(){
            axios
                .get('api/v1/master/satuanselect')
                .then((res) => {
                    this.satuans.values = res.data.data
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        searchMethod(){
            // let list=[]
            // for (let i = 0; i < this.allbarangs.length; i++) {
            //     let kodeObj = this.allbarangs[i].kode_barang
            //     if (kodeObj.toLowerCase().includes(this.searchValue.toLowerCase())) {
            //         list.push(this.allbarangs[i]);
            //     }
            // }
            // this.barangs.values = list
            axios
                .post('api/v1/master/barangsearch',this.searchValue)
                .then((res) => {
                    this.barangs.values = res.data.data.data
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
                    Master Barang
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
                                    <th scope="col" class="text-light">Kode Stock</th>
                                    <th scope="col" class="text-light">Barcode</th>
                                    <th scope="col" class="text-light">Nama Barang</th>
                                    <th scope="col" class="text-light">Kategori</th>
                                    <th scope="col" class="text-light">Satuan</th>
                                    <th scope="col" class="text-light">Faktor</th>
                                    <th scope="col" class="text-light">Harga Grosir</th>
                                    <th scope="col" class="text-light">Harga Eceran</th>
                                    <th scope="col" class="text-light">Harga Khusus</th>
                                    <th scope="col" class="text-light">Deskripsi</th>
                                    <th scope="col" class="text-light">Keterangan</th>
                                    <th scope="col" class="text-light">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider lbl-text bodtab text-center">
                            <!-- row -->
                                <tr v-for="barang in barangs.values" :key="barang.kode_barang">
                                    <th scope="row" class="number">{{barang.kode_barang}}</th>
                                    <td>
                                        <span v-if="barang.barcode == null">-</span>
                                        <span v-if="barang.barcode != null" class="d-inline-block text-truncate" style="max-width: 5rem">{{barang.barcode}}</span>
                                    </td>
                                    <td><span style="max-width: 5rem">{{barang.nama_barang}}</span></td>
                                    <td>{{barang.nama_kategori}}</td>
                                    <td>{{barang.satuan}}</td>
                                    <td>{{barang.faktor}}</td>
                                    <td>{{barang.harga_grosir}}</td>
                                    <td>{{barang.harga_eceran}}</td>
                                    <td>
                                        <div v-if="barang.harga_khusus != null">{{barang.harga_khusus}}</div>
                                        <div v-if="barang.harga_khusus == null">-</div>
                                    </td>
                                    <td>
                                        <span v-if="barang.deskripsi == null">-</span>
                                        <span v-if="barang.deskripsi != null" class="d-inline-block text-truncate" style="max-width: 5rem">{{barang.deskripsi}}</span>
                                    </td>
                                    <td> 
                                        <div v-if="barang.deleted_at == null" class="text-success fw-bold text-uppercase"> Aktif </div>
                                        <div v-if="barang.deleted_at != null" class="text-danger fw-bold text-uppercase"> Non Aktif </div>
                                    </td>
                                    <td>
                                        <button class="btn res" @click="rowClicked(barang)" >Edit</button>
                                        <button v-if="barang.deleted_at == null" class="btn res del" @click="rowClickedTakeKode(barang)" data-bs-toggle="modal" data-bs-target="#exampleModal1">Delete</button>
                                        <button v-if="barang.deleted_at != null" class="btn res del" @click="rowClickedTakeKode(barang)" data-bs-toggle="modal" data-bs-target="#exampleModal1">Restore</button>
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Insert Barang</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Menambahkan Data Barang dengan Kode {{barangInsert.kode.toUpperCase()}} ?
                        </div>
                        <form @submit.prevent="addBarang()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodeBarangInsert" v-model="barangInsert.kode_barang">
                            <input type="hidden" class="form-control lbl-text" id="BarcodeInsert" v-model="barangInsert.barcode">
                            <input type="hidden" class="form-control lbl-text" id="namaBarangInsert" v-model="barangInsert.nama_barang">
                            <input type="hidden" class="form-control lbl-text" id="KategoriInsert" v-model="barangInsert.kategori_barang">
                            <input type="hidden" class="form-control lbl-text" id="SatuanInsert" v-model="barangInsert.satuan">
                            <input type="hidden" class="form-control lbl-text" id="HargaGrosirInsert" v-model="barangInsert.harga_grosir">
                            <input type="hidden" class="form-control lbl-text" id="HargaEceranInsert" v-model="barangInsert.harga_eceran">
                            <input type="hidden" class="form-control lbl-text" id="HargaKhususInsert" v-model="barangInsert.harga_khusus">
                            <input type="hidden" class="form-control lbl-text" id="deskripsiInsert" v-model="barangInsert.deskripsi">
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Barang</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Untuk Mengubah Data Barang dengan Kode {{barangUpdate.kode.toUpperCase()}} ?
                        </div>
                        <form @submit.prevent="updateBarang()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodeBarangUpdate" v-model="barangUpdate.kode_barang">
                            <input type="hidden" class="form-control lbl-text" id="BarcodeUpdate" v-model="barangUpdate.barcode">
                            <input type="hidden" class="form-control lbl-text" id="namaBarangUpdate" v-model="barangUpdate.nama_barang">
                            <input type="hidden" class="form-control lbl-text" id="KategoriUpdate" v-model="barangUpdate.kategori_barang">
                            <input type="hidden" class="form-control lbl-text" id="SatuanUpdate" v-model="barangUpdate.satuan">
                            <input type="hidden" class="form-control lbl-text" id="HargaGrosirUpdate" v-model="barangUpdate.harga_grosir">
                            <input type="hidden" class="form-control lbl-text" id="HargaEceranUpdate" v-model="barangUpdate.harga_eceran">
                            <input type="hidden" class="form-control lbl-text" id="HargaKhususUpdate" v-model="barangUpdate.harga_khusus">
                            <input type="hidden" class="form-control lbl-text" id="deskripsiUpdate" v-model="barangUpdate.deskripsi">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- MODAL DELETE -->
            <div class="modal fade" id="exampleModal1" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" v-if="barangDel.deleted_at == null">
                            Apakah Anda Yakin Untuk Menghapus data Barang "{{barangDel.nama}}" ?
                        </div>
                        <div class="modal-body" v-if="barangDel.deleted_at != null">
                            Apakah Anda Yakin Untuk Mengembalikan data Barang "{{barangDel.nama}}" ?
                        </div>
                        <form @submit.prevent="deleteBarang()" method="post" class="d-grid">
                            <input type="hidden" class="form-control lbl-text" id="kodePegawaiDelete" v-model="barangDel.kode">
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
                            <label for="KodeStock" class="form-label lbl-text fs-6 fw-bold">Kode Stock</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangInsert.kode_barang" id="KodeStock" placeholder="Masukkan Kode Stock" aria-describedby="kodeStock">
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.kode_barang">
                                {{ errorsInsert.values.kode_barang[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputBarcode" class="form-label lbl-text fs-6 fw-bold">Barcode</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangInsert.barcode" id="InputBarcode" placeholder="Masukkan Barcode" aria-describedby="barcode">
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.barcode">
                                {{ errorsInsert.values.barcode[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputNama" class="form-label lbl-text fs-6 fw-bold">Nama Barang</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangInsert.nama_barang" id="InputNama" placeholder="Masukkan Nama Barang" aria-describedby="namaBarang">
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.nama_barang">
                                {{ errorsInsert.values.nama_barang[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Input" class="form-label lbl-text fs-6 fw-bold">Kategori Barang</label>
                            <select class="form-select" v-model="formBarangInsert.kategori_barang">
                                <option value="" selected>Pilih Kategori Barang</option>
                                <option v-for="kategori in kategoris.values" :key="kategori.kode_kategori" :value="kategori.kode_kategori">{{kategori.nama_kategori}}</option>
                            </select>
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.kategori_barang">
                                {{ errorsInsert.values.kategori_barang[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputSatuan" class="form-label lbl-text fs-6 fw-bold">Satuan</label>
                            <select class="form-select" v-model="formBarangInsert.satuan">
                                <option value="" selected>Pilih Satuan Barang</option>
                                <option v-for="satuan in satuans.values" :key="satuan.kode_satuan" :value="satuan.kode_satuan">{{satuan.kode_satuan}}</option>
                            </select>
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.satuan">
                                {{ errorsInsert.values.satuan[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputHGrosir" class="form-label lbl-text fs-6 fw-bold">Harga Grosir</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangInsert.harga_grosir" id="inputHGrosir" placeholder="Masukkan Harga Grosir" aria-describedby="hargaGrosir">
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.harga_grosir">
                                {{ errorsInsert.values.harga_grosir[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputHEceran" class="form-label lbl-text fs-6 fw-bold">Harga Eceran</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangInsert.harga_eceran" id="inputHEceran" placeholder="Masukkan Harga Eceran" aria-describedby="hargaEceran">
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.harga_eceran">
                                {{ errorsInsert.values.harga_eceran[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputHKhusus" class="form-label lbl-text fs-6 fw-bold">Harga Khusus</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangInsert.harga_khusus" id="inputHKhusus" placeholder="Masukkan Harga Khusus" aria-describedby="hargaKhusus">
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.harga_khusus">
                                {{ errorsInsert.values.harga_khusus[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label lbl-text fs-6 fw-bold">Deskripsi</label>
                            <textarea class="form-control lbl-text" v-model="formBarangInsert.deskripsi" id="Deskripsi" placeholder="Masukkan Deskripsi" rows="2"></textarea>
                            <div class="fs-6 text-danger" v-if="errorsInsert.values.deskripsi">
                                {{ errorsInsert.values.deskripsi[0] }}
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
                            <label for="KodeStock" class="form-label lbl-text fs-6 fw-bold">Kode Stock</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangUpdate.kode_barang" id="KodeStock" placeholder="Masukkan Kode Stock" aria-describedby="kodeStock" disabled>
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.kode_barang">
                                {{ errorsUpdate.values.kode_barang[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputBarcode" class="form-label lbl-text fs-6 fw-bold">Barcode</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangUpdate.barcode" id="InputBarcode" placeholder="Masukkan Barcode" aria-describedby="barcode" >
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.barcode">
                                {{ errorsUpdate.values.barcode[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputNama" class="form-label lbl-text fs-6 fw-bold">Nama Barang</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangUpdate.nama_barang" id="InputNama" placeholder="Masukkan Nama Barang" aria-describedby="namaBarang" >
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.nama_barang">
                                {{ errorsUpdate.values.nama_barang[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Input" class="form-label lbl-text fs-6 fw-bold">Kategori Barang</label>
                            <select class="form-select" v-model="formBarangUpdate.kategori_barang" aria-label="Default select example">
                                <option value="" selected>Pilih Kategori Barang</option>
                                <option v-for="kategori in kategoris.values" :key="kategori.kode" :value="kategori.kode">{{kategori.nama}}</option>
                            </select>
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.kategori_barang">
                                {{ errorsUpdate.values.kategori_barang[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputSatuan" class="form-label lbl-text fs-6 fw-bold">Satuan</label>
                            <select class="form-select" v-model="formBarangUpdate.satuan">
                                <option value="" selected>Pilih Satuan Barang</option>
                                <option v-for="satuan in satuans.values" :key="satuan.kode_satuan" :value="satuan.kode_satuan">{{satuan.kode_satuan}}</option>
                            </select>
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.satuan">
                                {{ errorsUpdate.values.satuan[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputHGrosir" class="form-label lbl-text fs-6 fw-bold">Harga Grosir</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangUpdate.harga_grosir" id="inputHGrosir" placeholder="Masukkan Harga Grosir" aria-describedby="hargaGrosir" >
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.harga_grosir">
                                {{ errorsUpdate.values.harga_grosir[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputHEceran" class="form-label lbl-text fs-6 fw-bold">Harga Eceran</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangUpdate.harga_eceran" id="inputHEceran" placeholder="Masukkan Harga Eceran" aria-describedby="hargaEceran" >
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.harga_eceran">
                                {{ errorsUpdate.values.harga_eceran[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputHKhusus" class="form-label lbl-text fs-6 fw-bold">Harga Khusus</label>
                            <input type="text" class="form-control lbl-text" v-model="formBarangUpdate.harga_khusus" id="inputHKhusus" placeholder="Masukkan Harga Khusus" aria-describedby="hargaKhusus" >
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.harga_khusus">
                                {{ errorsUpdate.values.harga_khusus[0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label lbl-text fs-6 fw-bold">Deskripsi</label>
                            <textarea class="form-control lbl-text" v-model="formBarangUpdate.deskripsi" id="Deskripsi" placeholder="Masukkan Deskripsi" rows="2"></textarea>
                            <div class="fs-6 text-danger" v-if="errorsUpdate.values.deskripsi">
                                {{ errorsUpdate.values.deskripsi[0] }}
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