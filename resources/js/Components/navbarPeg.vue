<script setup>
    import Logo from '../atoms/navLogo.vue';
</script>

<script>
    export default {
        components: {
        },
        data() {
            return {
            
            };
        },
        created() {
            
        },
        mounted() {
        
        },
        methods: {
            logoutClicked() {
                localStorage.removeItem('id');
                localStorage.removeItem('emailLogin');
                localStorage.removeItem('username');
                localStorage.removeItem('role');
            }
        },
    }
</script>

<template>
    <nav class="navbar navbar-expand-lg sticky-top bg-nav">
        <div class="d-flex justify-content-lg-between container-fluid">
            <div class="navbar-brand mt-2">
                <Logo />
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-fill ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link" role="button" aria-current="page" :to="{ name:'dashboardpegawai' }">Beranda</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name:'stokpegawai' }">Master Stok</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="button" href="#">Pengaturan</a>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" role="button" @click="logoutClicked()" :to="{ name:'login' }">Keluar</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.nav-link{
    font-family: "Inter";
    font-size: larger;
    font-weight: 600;
    color: rgb(179, 179, 179);
}

.nav-link:hover {
    font-size: larger;
    font-weight: 600;
    color: #000;
}

.dropdown-item{
    font-family: "Inter";
    font-size: large;
    font-weight: 600;
    color: #000;
}

.bg-nav {
    background-color: var(--bs-white);
}
</style>