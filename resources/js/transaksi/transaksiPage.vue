<script setup>
    import TransaksiLayout from '../layoutsPage/Transaksi.vue';
    import InputSearch from '../atoms/InputSearch.vue';
</script>

<script>
import axios from 'axios';
import moment from 'moment';
import { reactive, ref } from 'vue';

export default {
    components: { InputSearch },
    data() {
        return {
            showModal: false,
            searchValue: '',
            searchValueMember: '',
            searchValuePromo: '',
            rowSelected: 0,
            selectedIndex: 0,
            // Barang
                rowSelectedBarcode: '',
                rowSelectedKode: '',
                rowSelectedNama: '',
                rowSelectedSatuan: '',
                rowSelectedHarga: '',
            // 
            //Member
                memberSelectedKode: '',
                memberSelectedNama: '',
            //
            //Promo
                promoSelectedKode: '',
                promoSelectedPotongan: '',
            //
            rows: [ 
                { barcode: '', kode: '', nama:'', qty: '', satuan:'', harga: '', discount: '', jumlah: '' }
            ],
            forms: reactive({
                idPegawai: '',
                kode_member: '',
                kode_promo: '',
                pajak: '',
                total_qty: '',
                total_trans: '',
                tunai_trans: '',
                kembalian_trans: '',
                barang_trans: ''
            }),
            disabled: true,
            barangs: ref([]),
            barangsbarcode: [],
            baranglist: [],
            barangsketemu: [],
            members: ref([]),
            promos: ref([]),
            dataId: '',
            dataEmail: '',
            dataNama: '',
            pageLast: 0,
            pageNow: 0,
            pageLastMember: 0,
            pageNowMember: 0,
            pageLastPromo: 0,
            pageNowPromo: 0,
            jumTotal: 0,
            hargaPromoTotal: 0,
            hargaPajakTotal: 0,
            hargaTotal: 0,
            pajak: 0,
            pembayaran: 0,
            kembalian: 0,
            NoOrder: 0,
        };
    },
    created() {
        this.dataId = localStorage.getItem('id');
        this.dataEmail = localStorage.getItem('emailLogin');
        this.dataNama = localStorage.getItem('username');
    },
    mounted() {
        this.showTabelBarangForSearch()
        this.showTabelBarangForBarcode()
        this.showTabelMemberForSearch()
        this.showTabelPromoForSearch()
    },
    methods: {
        decrementPageFrom(){
            if(this.pageNow <= this.pageLast){
                this.pageNow--;
            }
            axios
                .get('api/v1/transaksi/barangtransaksi?page='+this.pageNow)
                .then((res) => {
                    this.barangs.values = res.data.data
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
                .get('api/v1/transaksi/barangtransaksi?page='+this.pageNow)
                .then((res) => {
                    this.barangs.values = res.data.data
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        decrementPagePromoFrom(){
            if(this.pageNowPromo <= this.pageLastPromo){
                this.pageNowPromo--;
            }
            axios
                .get('api/v1/transaksi/promotransaksi?page='+this.pageNowPromo)
                .then((res) => {
                    this.promos.values = res.data.data
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        incrementPagePromoFrom(){
            if(this.pageLastPromo > this.pageNowPromo){
                this.pageNowPromo++;
            }
            axios
                .get('api/v1/transaksi/promotransaksi?page='+this.pageNowPromo)
                .then((res) => {
                    this.promos.values = res.data.data
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        decrementPageMemberFrom(){
            if(this.pageNowMember <= this.pageLastMember){
                this.pageNowMember--;
            }
            axios
                .get('api/v1/transaksi/membertransaksi?page='+this.pageNowMember)
                .then((res) => {
                    this.members.values = res.data.data
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        incrementPageMemberFrom(){
            if(this.pageLastMember > this.pageNowMember){
                this.pageNowMember++;
            }
            axios
                .get('api/v1/transaksi/membertransaksi?page='+this.pageNowMember)
                .then((res) => {
                    this.members.values = res.data.data
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        buttonAddRow(){
            const row = { barcode: '', kode: '', nama:'', qty: '', satuan:'', harga: '', discount: '', jumlah: '' };
            this.rows.push(row);
            this.perhitunganHargadanJumlahTotal()
        },
        onChangeInputQTY(index){
            if(this.rows[index].qty <= 0){
                this.rows.splice(index,1);
            }else{
                this.rows[index].jumlah = this.rows[index].qty * this.rows[index].harga;
            }
            const besarDiscount = (this.rows[index].harga * this.rows[index].qty) * (this.rows[index].discount/100)
            this.rows[index].jumlah = (this.rows[index].harga * this.rows[index].qty) - besarDiscount.toFixed(0)
            this.perhitunganHargadanJumlahTotal()
        },
        onChangeInputDiscountRow(index){
            if(this.rows[index].discount <= 0){
                this.rows[index].discount = 0
            }
            const besarDiscount = (this.rows[index].harga * this.rows[index].qty) * (this.rows[index].discount/100)
            this.rows[index].jumlah = (this.rows[index].harga * this.rows[index].qty) - besarDiscount.toFixed(0)
            this.perhitunganHargadanJumlahTotal()
        },
        onChangeInputPajak(){
            this.jumTotal = 0
            this.hargaTotal = 0
            for (let i = 0; i < this.rows.length; i++) {
                this.jumTotal += this.rows[i].qty
                this.hargaTotal += this.rows[i].jumlah
            }
            this.hargaPromoTotal = this.hargaTotal * (this.promoSelectedPotongan/100)
            this.hargaTotal = this.hargaTotal - this.hargaPromoTotal
            this.hargaPajakTotal = this.hargaTotal * (this.pajak/100)
            this.hargaTotal = this.hargaTotal + this.hargaPajakTotal
        },
        updateValue(event) {
            const value = event.target.value
            if (value <= 0) {
                this.pajak = 0
            }else if(value >= 30){
                this.pajak = 30
            }
            this.$forceUpdate()
        },
        buttonDeleteRow(index){
            this.rows.splice(index,1);
            this.perhitunganHargadanJumlahTotal()
        },
        buttonBayar(){
            this.pembayaran = this.hargaTotal.toFixed(0)
        },
        clickedShow(index){
            this.selectedIndex = index
        },
        onChangeInputPembayaran(){
            if(this.pembayaran > this.hargaTotal){
                this.kembalian = this.pembayaran - this.hargaTotal
            }else{
                this.kembalian = 0
            }
        },
        perhitunganHargadanJumlahTotal(){
            this.jumTotal = 0
            this.hargaTotal = 0
            for (let i = 0; i < this.rows.length; i++) {
                this.jumTotal += this.rows[i].qty
                this.hargaTotal += this.rows[i].jumlah
            }
            this.hargaPromoTotal = this.hargaTotal * (this.promoSelectedPotongan/100)
            this.hargaTotal = this.hargaTotal - this.hargaPromoTotal
            this.hargaPajakTotal = this.hargaTotal * (this.pajak/100)
            this.hargaTotal = this.hargaTotal + this.hargaPajakTotal
        },
        selectedRowBarcode(){
            let valueSama = false
            let indexValue = 0
            this.rowSelectedBarcode = this.barangsketemu[0].barcode;
            this.rowSelectedKode = this.barangsketemu[0].kode_barang;
            this.rowSelectedNama = this.barangsketemu[0].nama_barang;
            this.rowSelectedSatuan = this.barangsketemu[0].satuan;
            if(this.barangsketemu[0].harga_khusus != null){
                this.rowSelectedHarga = this.barangsketemu[0].harga_khusus;
            }else{
                this.rowSelectedHarga = this.barangsketemu[0].harga;
            }
            if(this.rows.length > 1){
                for (let i = 0; i < this.rows.length; i++) {
                    if(this.rows[i].kode == this.rowSelectedKode){
                        valueSama = true
                        indexValue = i
                        break
                    }
                    valueSama = false
                }
            }

            if(valueSama){
                this.rows[indexValue].qty++
                this.rows[indexValue].jumlah = this.rows[indexValue].qty * this.rows[indexValue].harga;
                this.rows[this.rowSelected].barcode = ''
                this.perhitunganHargadanJumlahTotal()
            }else if(!valueSama){
                this.rows[this.rowSelected].barcode = this.rowSelectedBarcode;
                this.rows[this.rowSelected].kode = this.rowSelectedKode;
                this.rows[this.rowSelected].nama = this.rowSelectedNama;
                this.rows[this.rowSelected].qty = 1;
                this.rows[this.rowSelected].satuan = this.rowSelectedSatuan;
                this.rows[this.rowSelected].harga = this.rowSelectedHarga;
                this.rows[this.rowSelected].discount = 0;
                this.rows[this.rowSelected].jumlah = this.rows[this.rowSelected].qty * this.rowSelectedHarga;
                this.perhitunganHargadanJumlahTotal()
            }
        },
        selectedRowPilih(row){
            let valueSama = false
            let indexValue = 0
            if(row.barcode != null){
                this.rowSelectedBarcode = row.barcode;
            }else{
                this.rowSelectedBarcode = '-';
            }
            this.rowSelectedKode = row.kode_barang
            this.rowSelectedNama = row.nama_barang;
            this.rowSelectedSatuan = row.satuan;
            if(row.harga_khusus != null){
                this.rowSelectedHarga = row.harga_khusus;
            }else{
                this.rowSelectedHarga = row.harga;
            }
            if(this.rows.length > 1){
                for (let i = 0; i < this.rows.length; i++) {
                    if(this.rows[i].kode == this.rowSelectedKode){
                        valueSama = true
                        indexValue = i
                        break
                    }
                    valueSama = false
                }
            }

            if(valueSama){
                this.rows[indexValue].qty++
                this.rows[indexValue].jumlah = this.rows[indexValue].qty * this.rows[indexValue].harga;
                this.rows[this.selectedIndex].kode = ''
                this.perhitunganHargadanJumlahTotal()
            }else if(!valueSama){
                this.rows[this.selectedIndex].barcode = this.rowSelectedBarcode;
                this.rows[this.selectedIndex].kode = this.rowSelectedKode;
                this.rows[this.selectedIndex].nama = this.rowSelectedNama;
                this.rows[this.selectedIndex].qty = 1;
                this.rows[this.selectedIndex].satuan = this.rowSelectedSatuan;
                this.rows[this.selectedIndex].harga = this.rowSelectedHarga;
                this.rows[this.selectedIndex].discount = 0;
                this.rows[this.selectedIndex].jumlah = this.rows[this.rowSelected].qty * this.rowSelectedHarga;
                this.perhitunganHargadanJumlahTotal()
            }
        },
        searchDataFromInput(index){
            this.barangsketemu = []
            this.searchFromBarcode(index)
            
            this.rowSelected = index
            if(this.barangsketemu.length != 0){
                this.selectedRowBarcode()
            }else if(this.barangsketemu.length == 0){
                this.rows[index].barcode = ''
            }
        },
        searchFromKategoriOnKode(index){
            this.baranglist = []
            let list = []
            for (let i = 0; i < this.barangs.length; i++) {
                let kodeObj = this.barangs[i].kode_barang.substring(0,2)
                if (kodeObj.includes(this.rows[index].kode)) {
                    list.push(this.barangs[i].kode_barang);
                }
            }
            if(this.rows[index].kode == ''){
                this.baranglist = []
            }
            this.baranglist = list
        },
        searchFromBarcode(index){
            for (let i = 0; i < this.barangsbarcode.length; i++) {
                let barcodeObj = this.barangsbarcode[i].barcode
                if (barcodeObj == this.rows[index].barcode) {
                    this.barangsketemu.push(this.barangsbarcode[i]);
                }
            }
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
        showTabelBarangForSearch(){
            axios
                .get('api/v1/transaksi/barangtransaksi')
                .then((res) => {
                    this.barangs.values = res.data.data;
                    this.pageNow = res.data.meta.current_page;
                    this.pageLast = res.data.meta.last_page;
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        showTabelBarangForBarcode(){
            axios
                .get('api/v1/transaksi/barangbarcode')
                .then((res) => {
                    this.barangsbarcode = res.data.data
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        showTabelMemberForSearch(){
            axios
                .get('api/v1/transaksi/membertransaksi')
                .then((res) => {
                    this.members.values = res.data.data
                    this.pageNowMember = res.data.meta.current_page;
                    this.pageLastMember = res.data.meta.last_page;
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        showTabelPromoForSearch(){
            axios
                .get('api/v1/transaksi/promotransaksi')
                .then((res) => {
                    this.promos.values = res.data.data
                    this.pageNowPromo = res.data.meta.current_page;
                    this.pageLastPromo = res.data.meta.last_page;
                })
                .catch((error) => {
                    console.log(error);
            });
        },
        newButton(){
            this.searchValue = ''
            this.rowSelected = 0 
            this.nextBarId = 0
            this.jumTotal = 0
            this.hargaTotal = 0
            this.hargaPromoTotal = 0,
            this.hargaPajakTotal = 0,
            this.nextBarId = 0
            this.memberSelectedKode = ''
            this.memberSelectedNama = ''
            this.promoSelectedKode = ''
            this.promoSelectedPotongan = ''
            this.pajak = 0
            this.barangsketemu = []
            this.baranglist = []
            this.rows = [ 
                { barcode: '', kode: '', nama:'', qty: '', satuan:'', harga: '', discount: '', jumlah: '' }
            ]
            this.disabled = true
        },
        promoSelectedRow(row){
            if(row){
                this.promoSelectedKode = row.kode_promo;
                this.promoSelectedPotongan = row.potongan;
            }else{
                this.promoSelectedKode = ''
                this.promoSelectedPotongan = 0
            }
            this.perhitunganHargadanJumlahTotal()
        },
        memberSelectedRow(row){
            if(row){
                this.memberSelectedKode = row.kode_member;
                this.memberSelectedNama = row.nama_member;
            }else{
                this.memberSelectedKode = '';
                this.memberSelectedNama = '';
            }
        },
        checkoutTransaksi(){
            this.forms.idPegawai = this.dataId
            this.forms.kode_member = this.memberSelectedKode
            this.forms.kode_promo =  this.promoSelectedKode
            this.forms.pajak = this.pajak
            this.forms.total_qty = this.jumTotal
            this.forms.total_trans = this.hargaTotal.toFixed(0)
            this.forms.tunai_trans = this.pembayaran
            this.forms.kembalian_trans = this.kembalian.toFixed(0)
            this.forms.barang_trans = this.rows
            axios
                .post('api/v1/transaksi/inserttransaksi',this.forms)
                .then((res)=> {
                    alert(res.data.message)
                    this.NoOrder = res.data.data.idHtransLast + 1
                })
                .catch((err) =>{
                    alert(err.response.data.message)
                });
        },
    },
}
</script>

<template>
    <TransaksiLayout>
        <div class="w-100">
            <div class="w-50 mt-5 mx-auto">
                <h1 class="fs-1 text-center header-text">
                    Transaksi
                </h1>
            </div>
            <div class="w-75 my-4 py-2 mx-auto">
                <div class="table-responsive">
                    <table class="table table-bordered border-dark align-middle w-100">
                        <!-- head -->
                        <thead >
                            <tr class="table-dark fw-bold text-center">
                                <th scope="col" class="text-light Action">Action</th>
                                <th scope="col" class="text-light colBarcode">Barcode</th>
                                <th scope="col" class="text-light colKode">Kode Stock</th>
                                <th scope="col" class="text-light colName">Nama Barang</th>
                                <th scope="col" class="text-light colQty">Qty</th>
                                <th scope="col" class="text-light colReg">Satuan</th>
                                <th scope="col" class="text-light colPrice">Harga</th>
                                <th scope="col" class="text-light colDisc">Discount</th>
                                <th scope="col" class="text-light colPrice">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="lbl-text">
                        <!-- row -->
                            <tr 
                                v-for="(row, index) in rows" 
                                :key="row.id"
                            >
                                <td class="transTab text-center">
                                    <div class="mx-auto">
                                        <span class="edit_mode mx-1" @click="buttonDeleteRow(index)">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </span>
                                        <span class="edit_mode mx-1" @click="disabled = !disabled">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </td>
                                <!--   v-on:keyup="searchFromKategoriOnKode(index)"-->
                                <!-- v-on:change="onChangeInputQTY(index)"  -->
                                <td class="transTab text-center">
                                    <input 
                                        type="text" 
                                        v-on:change="searchDataFromInput(index)" 
                                        v-model="row.barcode" 
                                        class="transTabInputBarcode text-center border border-0 d-inline-block text-truncate" 
                                        style="max-width: 6.2rem"
                                        :disabled="row.kode != ''"
                                    >
                                </td>
                                <td class="transTab text-center" @click="clickedShow(index)" data-bs-toggle="modal" data-bs-target="#modalBarang">{{row.kode}}</td>
                                <td class="transTab text-center">{{row.nama}}</td>
                                <td class="transTab text-end"><input type="number" v-model="row.qty" v-on:change="onChangeInputQTY(index)" class="transTabInputQTY text-center border border-0" v-bind:disabled="disabled"></td>
                                <td class="transTab text-center">{{row.satuan}}</td>
                                <td class="transTab text-end">{{formatRupiah(row.harga + "","IDR")}}</td>
                                <td class="transTab text-end"><input type="number" v-model="row.discount" v-on:change="onChangeInputDiscountRow(index)" class="transTabInputDisc text-center border border-0" v-bind:disabled="disabled"></td>
                                <td class="transTab text-end">{{formatRupiah(row.jumlah + "","IDR")}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="w-100 d-flex flex-row justify-content-between align-self-center align-items-center">
                    <div class="me-auto addRow">
                        <button type="button" class="btn" @click="buttonAddRow()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        <button type="button" class="btn btnNew" data-bs-toggle="modal" data-bs-target="#exampleModalNew">New</button>
                    </div>
                    <div class="headerNameContent">Discount :</div>
                    <div class="border border-dark border-1 text-end text-black promoContent" data-bs-toggle="modal" data-bs-target="#modalPromo">{{promoSelectedKode}}</div>
                    <div class="border border-dark border-1 text-end text-black totalContent">{{formatRupiah(hargaPromoTotal.toFixed(0) + "","IDR")}}</div>
                </div>
                <div class="w-100 d-flex flex-row justify-content-end align-self-center align-items-center">
                    <div class="headerNameContent mt-1">Pajak :</div>
                    <input type="number" v-model="pajak" @input="updateValue" class="border border-dark border-1 text-end text-black pajakContent" v-on:change="onChangeInputPajak()">
                    <div class="border border-dark border-1 text-end text-black pajaktotalContent">{{formatRupiah(hargaPajakTotal.toFixed(0) + "", "IDR")}}</div>
                </div>
                <div class="w-100 d-flex flex-row justify-content-end align-self-center align-items-center">
                    <div class="headerNameContent mt-1">Member :</div>
                    <div class="border border-dark border-1 border-top-0 text-end text-black memberContent" data-bs-toggle="modal" data-bs-target="#modalMember">{{memberSelectedKode}}</div>
                    <div class="border border-dark border-1 border-top-0 text-end text-black membertotalContent">{{memberSelectedNama}}</div>
                </div>
                <div class="w-100 d-flex flex-row justify-content-end align-self-center align-items-center">
                    <div class="headerNameContent mt-1">Total Pembelian :</div>
                    <div class="border border-dark border-1 text-end text-black totalPembelianContent">{{formatRupiah(hargaTotal.toFixed(0) + "","IDR")}}</div>
                </div>
                <!--  Modal Search Barang -->
                <div class="modal fade" tabindex="-1" id="modalBarang">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Search</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="w-100 mb-3">
                                    <InputSearch v-model="searchValue"/> {{searchValue}}
                                </div>
                                <p>{{selectedIndex}}</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark table-hover align-middle w-100">
                                        <!-- head -->
                                        <thead >
                                            <tr class="table-dark fw-bold text-center">
                                                <th scope="col" class="text-light">Kode Stock</th>
                                                <th scope="col" class="text-light">Nama Barang</th>
                                                <th scope="col" class="text-light">Satuan</th>
                                                <th scope="col" class="text-light">Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider lbl-text bodtab text-center">
                                        <!-- row -->
                                            <tr v-for="barang in barangs.values" :key="barang.kode_barang">
                                                <th scope="row" class="number" @click="selectedRowPilih(barang)" data-bs-dismiss="modal">{{barang.kode_barang}}</th>
                                                <td><span style="max-width: 5rem">{{barang.nama_barang}}</span></td>
                                                <td>{{barang.satuan}}</td>
                                                <td>
                                                    <div v-if="barang.harga_khusus != null">{{barang.harga_khusus}}</div>
                                                    <div v-if="barang.harga_khusus == null">{{barang.harga}}</div>
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
                    </div>
                </div>
                <!--  Modal Search Promo -->
                <div class="modal fade" tabindex="-1" id="modalPromo">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Search</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="w-100 mb-3">
                                    <InputSearch v-model="searchValuePromo"/> {{searchValuePromo}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark table-hover align-middle w-100">
                                        <!-- head -->
                                        <thead >
                                            <tr class="table-dark fw-bold text-center">
                                                <th scope="col" class="text-light">Kode Promo</th>
                                                <th scope="col" class="text-light">Potongan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider lbl-text bodtab text-center">
                                        <!-- row -->
                                            <tr>
                                                <th scope="row" class="number" @click="promoSelectedRow()" data-bs-dismiss="modal">Tidak Ada Potongan</th>
                                                <td>0</td>
                                            </tr>
                                            <tr v-for="promo in promos.values" :key="promo.kode_promo">
                                                <th scope="row" class="number" @click="promoSelectedRow(promo)" data-bs-dismiss="modal">{{promo.kode_promo}}</th>
                                                <td>{{promo.potongan}}%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li v-if="pageNowPromo > 1" class="page-item">
                                            <a class="page-link" @click="decrementPagePromoFrom()" style="cursor:pointer">Previous</a>
                                        </li>
                                        <li class="page-item"><a class="page-link">{{pageNowPromo}}</a></li>
                                        <li class="page-item">
                                            <a class="page-link" @click="incrementPagePromoFrom()" style="cursor:pointer">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  Modal Search Member -->
                <div class="modal fade" tabindex="-1" id="modalMember">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Search</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="w-100 mb-3">
                                    <InputSearch v-model="searchValueMember"/> {{searchValueMember}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark table-hover align-middle w-100">
                                        <!-- head -->
                                        <thead >
                                            <tr class="table-dark fw-bold text-center">
                                                <th scope="col" class="text-light">Kode Member</th>
                                                <th scope="col" class="text-light">Nama Member</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider lbl-text bodtab text-center">
                                        <!-- row -->
                                            <tr>
                                                <th scope="row" class="number" @click="memberSelectedRow()" data-bs-dismiss="modal">Tanpa Member</th>
                                                <td></td>
                                            </tr>
                                            <tr v-for="member in members.values" :key="member.kode_member">
                                                <th scope="row" class="number" @click="memberSelectedRow(member)" data-bs-dismiss="modal">{{member.kode_member}}</th>
                                                <td>{{member.nama_member}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li v-if="pageNowMember > 1" class="page-item">
                                            <a class="page-link" @click="decrementPageMemberFrom()" style="cursor:pointer">Previous</a>
                                        </li>
                                        <li class="page-item"><a class="page-link">{{pageNowMember}}</a></li>
                                        <li class="page-item">
                                            <a class="page-link" @click="incrementPageMemberFrom()" style="cursor:pointer">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  Modal Pembayaran -->
                <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="modalPembayaran">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <input type="hidden" name="inputFormData" v-model="rows">
                                    <label for="HargaJumlah" class="form-label">Jumlah</label>
                                    <input type="text" :value="formatRupiah(hargaTotal.toFixed(0) + '', 'IDR')" name="jumlah" class="form-control" id="HargaJumlah" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="HargaVoucher" class="form-label">Voucher</label>
                                    <input type="text" :value="formatRupiah(hargaPromoTotal.toFixed(0) + '', 'IDR')" name="voucher" class="form-control" id="HargaVoucher" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="HargaSisa" class="form-label">Sisa</label>
                                    <input type="text" :value="formatRupiah(hargaTotal.toFixed(0) + '', 'IDR')" name="sisa" class="form-control" id="HargaSisa" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="HargaTunai" class="form-label">Tunai</label>
                                    <input type="number" v-on:change="onChangeInputPembayaran()" v-model="pembayaran" name="tunai" class="form-control" id="HargaTunai" required>
                                </div>
                                <div class="mb-3">
                                    <label for="HargaKembali" class="form-label">Kembali</label>
                                    <input type="text" :value="formatRupiah(kembalian.toFixed(0) + '', 'IDR')" name="kembali" class="form-control" id="HargaKembali" disabled>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCheckout" >Ya</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  Modal Struk -->
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
                                        {{moment().format("DD-MM-YYYY HH:mm")}}
                                    </p>
                                    <p class="fntAll pegawai text-start header-text">
                                        {{dataNama}}
                                    </p>
                                </div>
                                <div class="w-100" v-for="row in rows" :key="row">
                                    <div v-if="row.kode != ''" class="namacont d-flex flex-row justify-content-start align-items-start">
                                        <p class="fntAll nama text-start">
                                            {{row.nama}}
                                        </p>
                                    </div>
                                    <div v-if="row.kode != ''" class="barang d-flex flex-row justify-content-between align-items-start">
                                        <div class="w-100 d-flex flex-row">
                                            <p class="fntAll qtydansatuan text-start">
                                                {{row.qty + "  "}} {{row.satuan}}
                                            </p>
                                            <p class="fntAll harga text-start">
                                                {{row.harga}}
                                            </p>
                                        </div>
                                        <div class="w-100 d-flex flex-row">
                                            <p class="fntAll equal text-start">
                                                =
                                            </p>
                                            <p class="fntAll total text-end ms-auto">
                                                {{row.jumlah}}
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
                                        {{hargaTotal.toFixed(0)}}
                                    </p>
                                </div>
                                <div v-if="promoSelectedKode != ''" class="w-100 d-flex flex-row justify-content-between align-items-center">
                                    <p class="fntAll titleVoucher text-start">
                                        Voucher
                                    </p>
                                    <p class="fntAll equalTot text-start">
                                        =
                                    </p>
                                    <p class="fntAll total text-start ms-auto">
                                        {{hargaPromoTotal.toFixed(0)}}
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
                                        {{pembayaran}}
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
                                        {{kembalian.toFixed(0)}}
                                    </p>
                                </div>
                                <div class="d-flex flex-row justify-content-start align-items-start endFoot">
                                    <p class="fntAll end text-start header-text">
                                        Total Qty =
                                    </p>
                                    <p class="fntAll endval text-start header-text">
                                        {{jumTotal}}
                                    </p>
                                </div>
                                <div class="d-flex flex-row justify-content-start align-items-start endFoot">
                                    <p class="fntAll end text-start header-text">
                                        No. Order:
                                    </p>
                                    <p class="fntAll endval text-start header-text">
                                        {{NoOrder}}
                                    </p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODAL Untuk New -->
                <div class="modal fade" id="exampleModalNew" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Tabel Transaksi</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda Yakin Untuk Mereset Tabel Transaksi?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="newButton()">Ya</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODAL Untuk CheckoutTransaksi -->
                <div class="modal fade" id="exampleModalCheckout" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Transaksi</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda Yakin Untuk Mengakiri Transaksi?
                            </div>
                            <form @submit.prevent="checkoutTransaksi" method="post">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                    <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalStruk">Ya</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-75 py-2 mx-auto bottomPage">
                <div class="w-100 d-flex flex-row justify-content-between align-self-center align-items-center">
                    <div class="w-100 mt-3 d-flex flex-row">
                        <h5 class="fs-5 text-start header-text">
                            Rp.
                        </h5>
                        <div class="w-100 mt-5 d-flex flex-column">
                            <h1 class="Total ms-3 text-start header-text">
                                {{formatRupiah( hargaTotal.toFixed(0) + "")}}
                            </h1>
                            <svg
                                class="line"
                                width="380"
                                height="2"
                                viewBox="0 0 352 2"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                            <line
                                x1="1"
                                y1="1"
                                x2="350.756"
                                y2="1"
                                stroke="#9A9A9A"
                                stroke-opacity="0.89"
                                stroke-width="2"
                                stroke-linecap="round"
                            />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 d-flex flex-column justify-content-end align-items-end">
                            <div class="w-100 mt-3 d-flex flex-row">
                                <h5 class="qtyTotal fs-5 text-start header-text">
                                    Qty Total:
                                </h5>
                                <h3 class="fs-3 ms-3 text-start header-text">
                                    {{jumTotal}}
                                </h3>
                            </div>
                            <div class="w-100 mt-2 d-flex flex-column align-items-end">
                                <button type="button" class="btn btnBayar" @click="buttonBayar()" data-bs-toggle="modal" data-bs-target="#modalPembayaran" >Bayar</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </TransaksiLayout>
</template>

<style scoped>
.bottomPage{
    margin-top: 0.25rem;
    margin-bottom: 4rem;
}
.btnBayar{
    font-family: "Inter";
    font-size: larger;
    font-weight: 600;
    margin-left: 0.5rem;
    width: 8rem;
    height: 4.5rem;
}
.qtyTotal{
    width: 8rem;
}
.transTab {
    height: 2.5rem;
    font-family: "Inter";
    font-size: medium;
    font-weight: 600;
}
.Total{
    font-family: "Inter";
    font-size: 48pt;
    font-weight: 600;
}
.transTabInputBarcode{
    height: 2.5rem;
    background-color: var(--bs-bgcolor);
    font-family: "Inter";
    font-size: medium;
    font-weight: 600;
    margin:-0.51rem;
}
.transTabInputBarcode:hover{
    background-color: rgba(0, 0, 0, 0.025);
}
.transTabInputQTY{
    width:3.8rem; 
    height: 2.5rem;
    background-color: var(--bs-bgcolor);
    font-family: "Inter";
    font-size: medium;
    font-weight: 600;
    margin:-0.51rem;
    z-index: -100;
}
.transTabInputQTY:hover{
    background-color: rgba(0, 0, 0, 0.025);
}
.transTabInputDisc{
    width: 5rem; 
    height: 2.5rem;
    background-color: var(--bs-bgcolor);
    font-family: "Inter";
    font-size: medium;
    font-weight: 600;
    margin:-0.50rem;
}
.transTabInputDisc:hover{
    background-color: rgba(0, 0, 0, 0.025);
}
.Action {
    width: 5rem;
}
.colBarcode{
    width: 6.7rem;
}
.colKode {
    width: 15rem;
}
.colName {
    width: 27.2rem;
}
.colQty {
    width: 4.3rem;
}
.colDisc {
    width: 4rem;
}
.colReg {
    width: 8rem;
}
.colPrice {
    width: 12rem;
    padding-top: 0.3rem;
    padding-right: 0.5rem;
}
.edit_mode:hover{ 
    color:#666;
}
.firstRow {
    margin-right: 3rem;
}
.addRow {
    margin-top: -0.8rem;
}
.btnNew {
    font-family: "Inter";
    font-size: medium;
    font-weight: 600;
    margin-left: 0.5rem;
    width: 4.5rem;
    height: 2.4rem;
}
.headerNameContent {
    font-family: "Inter";
    font-size: medium;
    font-weight: 600;
    margin-top: -0.9rem;
    margin-right: 0.56rem;
}
.promoContent, .totalContent {
    font-family: "Inter";
    font-size: medium;
    font-weight: 600;
    width: 19.56rem;
    height: 2.5rem;
    margin-top: -1.19rem;
    padding-top: 0.3rem;
    padding-right: 0.5rem;
    z-index: 9;
}
.promoContent{
    margin-right: -0.07rem;
}
.pajakContent, .pajaktotalContent {
    font-family: "Inter";
    font-size: medium;
    font-weight: 600;
    width: 19.88rem;
    height: 2.5rem;
    margin-top: -0.2rem;
    padding-top: 0.3rem;
    padding-right: 0.5rem;
    z-index: 9;
}
.pajakContent{
    background-color: var(--bs-bgcolor);
    width: 12rem;
    margin-right: -0.07rem;
}
.pajaktotalContent{
    width: 19.56rem;
}
.memberContent, .membertotalContent, .totalPembelianContent {
    font-family: "Inter";
    font-size: medium;
    font-weight: 600;
    width: 19.88rem;
    height: 2.5rem;
    padding-top: 0.4rem;
    padding-right: 0.5rem;
    z-index: 9;
}
.memberContent{
    width: 12rem;
    margin-right: -0.07rem;
    margin-top: -0.05rem;
}
.membertotalContent{
    width: 19.56rem;
    margin-top: -0.05rem;
}
.totalPembelianContent{
    width: 19.56rem;
    margin-top: -0.05rem;
}
.marginContentRow{
    margin-right: 5rem;
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
.titleVoucher{
    position: static;
    margin-left: 15.6rem;
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