import { createWebHistory,createRouter } from "vue-router";
    import Login from '../Login.vue';
    import Register from '../Register.vue';
    import DashboardPage from '../master/dashboard.vue';
    import DashboardPegawaiPage from '../pegawaiStok/dashboardPegawai.vue';
    import MasterBarangPage from '../master/masterBarang.vue';
    import MasterSatuanPage from '../master/masterSatuan.vue';
    import MasterKategoriPage from '../master/masterKategori.vue';
    import MasterMemberPage from '../master/masterMember.vue';
    import MasterPegawaiPage from '../master/masterPegawai.vue';
    import MasterPromoPage from '../master/masterPromo.vue';
    import MasterStokPage from '../master/masterStok.vue';
    import MasterStokPegawaiPage from '../pegawaiStok/masterStokPegawai.vue';
    import TransaksiPage from '../transaksi/transaksiPage.vue';
    import RiwayatTransPage from '../transaksi/RiwayatTransPage.vue';
    import RiwayatPembelianPage from '../master/RiwayatPembelian.vue';

const routes = [
    {
        path: '/',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardPage
    },
    {
        path: '/dashboardPegawai',
        name: 'dashboardpegawai',
        component: DashboardPegawaiPage
    },
    {
        path: '/masterBarang',
        name: 'barang',
        component: MasterBarangPage
    },
    {
        path: '/masterKategori',
        name: 'kategori',
        component: MasterKategoriPage
    },
    {
        path: '/masterMember',
        name: 'member',
        component: MasterMemberPage
    },
    {
        path: '/masterPegawai',
        name: 'pegawai',
        component: MasterPegawaiPage
    },
    {
        path: '/masterSatuan',
        name: 'satuan',
        component: MasterSatuanPage
    },
    {
        path: '/masterPromo',
        name: 'promo',
        component: MasterPromoPage
    },
    {
        path: '/masterStok',
        name: 'stok',
        component: MasterStokPage
    },
    {
        path: '/masterStokPegawai',
        name: 'stokpegawai',
        component: MasterStokPegawaiPage
    },
    {
        path: '/riwayatpembelian',
        name: 'pembelian',
        component: RiwayatPembelianPage
    },
    {
        path: '/transaksi',
        name: 'transaksi',
        component: TransaksiPage
    },
    {
        path: '/riwayattrans',
        name: 'riwayat',
        component: RiwayatTransPage
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;