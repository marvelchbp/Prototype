<script setup >
    import Navbar from '../components/navbar.vue';
    import Footer from '../components/footer.vue';
    import Login from '../Login.vue';
    import Register from '../Register.vue';
    import DashboardPage from '../master/dashboard.vue';
    import MasterBarangPage from '../master/masterBarang.vue';
    import MasterKategoriPage from '../master/masterKategori.vue';
    import MasterMemberPage from '../master/masterMember.vue';
    import MasterPegawaiPage from '../master/masterPegawai.vue';
</script>

<script>
export default {
    components: {
    },
    data() {
        return {
            value: false,
        };
    },
    created() {
        
    },
    mounted() {
    
    },
    methods: {
    
    },
}
</script>

<template>
   <router-view></router-view>
</template>

<style>
.header-text{
    font-family: "Inter";
    font-size: larger;
    font-weight: 600;
}
.lbl-text{
    font-family: "Inter";
}
.bodtab{
    font-size: 11.5pt;
}
.header-table{
    background-color: #EFEFEF;
    color: black;
}
.page-link{
    background-color: #EFEFEF;
    color: black;
}
.number{
    background-color: white;
    color: black;
}
.btn{
    font-family: "Inter";
    font-size: medium;
    font-weight: 600;
    background-color: #4a4a4a;
    color: #fff;
}
.btn:hover{
    background-color: #A6A6A6;
    color: #4a4a4a;
}
.underline{
    font-family: "Inter";
    font-size: large;
    font-weight: 600;
    color: rgb(179, 179, 179);
}
</style>
