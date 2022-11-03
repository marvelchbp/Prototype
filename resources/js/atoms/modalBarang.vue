
<script>
    import InputSearch from '../atoms/InputSearch.vue';
    import axios from 'axios';
    import { reactive, ref } from 'vue';

    export default {
        components: { InputSearch },
        data() {
            return {
                searchValue: '',
                pageLast: 0,
                pageNow: 0,
                barangs: ref([]),
            };
        },
        created() {
        },
        mounted() {
            this.showTabelBarangForSearch();
        },
        methods: {
            
            showTabelBarangForSearch(){
                axios
                    .get('api/v1/transaksi/barangtransaksi')
                    .then((res) => {
                        this.barangs.values = res.data.data
                    })
                    .catch((error) => {
                        console.log(error);
                });
            },
        },
    }
</script>

<template>
    <!--  Modal Search Barang -->
    <div class="modal fade" tabindex="-1" id="modalBarang">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Search</h5>
                    <button type="button" class="btn-close" @click="$emit('close')" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="w-100 mb-3">
                        <InputSearch v-model="searchValue"/> {{searchValue}}
                    </div>
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
                                    <th scope="row" class="number" data-bs-dismiss="modal">{{barang.kode_barang}}</th>
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
</template>