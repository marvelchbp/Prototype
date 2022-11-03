<script setup>
    import StokLayout from '../layoutsPage/Stok.vue';
</script>

<script>
export default {
    components: {
    },
    data() {
        return {
            rows: [
                { id: 1, nama: "Lorem", job: "Kerja", fav: "Kuning"},
                { id: 2, nama: "Ipsum", job: "Kerja", fav: "Biru"},
                { id: 3, nama: "Dolor", job: "Kerja", fav: "Merah"},
                { id: 4, nama: "Rean", job: "Kerja", fav: "Kuning"},
                { id: 5, nama: "Pico", job: "Kerja", fav: "Biru"}
            ],
            displayName: '',
            displayJob: '',
            displayFavorite: '',
            dataId: '',
            dataEmail: '',
            dataNama: '',
        };
    },
    created() {
        this.dataId = localStorage.getItem('id');
        this.dataEmail = localStorage.getItem('emailLogin');
        this.dataNama = localStorage.getItem('username');
    },
    mounted() {
    
    },
    methods: {
        clicked(row) {
            this.displayName = row.nama;
            this.displayJob = row.job;
            this.displayFavorite = row.fav;
        }
    },
}
</script>

<template>
    <StokLayout>
        <div class="w-100">
            <div class="w-50 mt-5 mx-auto">
                <h1 class="fs-1 text-start header-text">
                    Dashboard
                </h1>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center my-4 pt-5">
            <div class="w-50 pb-1">
                <div class="w-100 mb-3">
                    <label for="exampleInputEmail1" class="form-label lbl-text fs-6 fw-bold">Search</label>
                    <input type="text" class="form-control lbl-text" id="InputSearch" placeholder="Cari Disini.." aria-describedby="emailHelp" required>
                </div>
            </div>
            <div class="w-50 py-6">
                <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> -->
                    <div class="table-responsive">
                        <table class="table table-hover w-100">
                            <!-- head -->
                            <thead >
                                <tr>
                                    <th class="header-table"></th>
                                    <th class="header-table">Name</th>
                                    <th class="header-table">Job</th>
                                    <th class="header-table">Favorite Color</th>
                                    <th class="header-table">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                            <!-- row -->
                                <tr 
                                    v-for="row in rows"
                                    :key="row.id"
                                >
                                    <th class="number">{{ row.id }}</th>
                                    <td>{{ row.nama }}</td>
                                    <td>{{ row.job }}</td>
                                    <td>{{ row.fav }}</td>
                                    <td><button @click="clicked(row)" class="btn">Edit</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                <!-- </div> -->
            </div>
        </div>
    </StokLayout>
</template>