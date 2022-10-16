<script setup>
import { ref } from 'vue';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="relative">
        <div class="min-h-screen bg-backg">
            <div class="navbar">
                <div class="flex-1">
                    <div class="container-content">
                        <div class="logo-picture">
                            <svg
                                class="logo"
                                width="5rem"
                                height="5rem"
                                viewBox="0 0 287 290"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <ellipse
                                    cx="143.5"
                                    cy="145"
                                    rx="143.5"
                                    ry="145"
                                    fill="#424242"
                                />
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M267 144.5C267 213.907 211.388 270 143 270C74.6116 270 19 213.907 19 144.5C19 133.478 20.4024 122.792 23.0357 112.612L92.8 112.9C98.5 112.9 101.2 114.4 101.2 118.15C101.2 123.1 93.25 129.85 77.65 139.9C96.55 150.1 105.85 159.1 105.85 167.5C105.85 171.7 103.15 173.65 97.75 173.65H76.9V117.4H47.8V199H90.7C107.05 199 118.75 198.55 126.4 193.9C134.65 188.95 138.85 181 138.85 170.65C138.85 158.95 132.25 147.55 119.5 138.55C129.1 130.6 133.75 122.5 133.75 112.6C133.75 96.25 121.9 87.85 98.35 87.85H32.3182C52.7852 46.9712 94.707 19 143 19C191.293 19 233.215 46.9712 253.682 87.85H218.651C196.451 87.85 179.651 93.55 167.501 105.7C154.901 118.3 147.251 137.65 147.251 159.25C147.251 178 153.251 196.45 165.101 214.6L188.801 199C181.751 187.6 178.001 175.9 177.401 163.9H208.751V199H238.751V117.4H208.751V138.25H180.401C187.001 120.25 199.301 112.9 220.601 112.9L262.965 112.617C265.598 122.795 267 133.48 267 144.5ZM276 144.5C276 218.782 216.454 279 143 279C69.5461 279 10 218.782 10 144.5C10 70.2177 69.5461 10 143 10C216.454 10 276 70.2177 276 144.5Z"
                                    fill="white"
                                />
                            </svg>
                        </div>
                        <div class="main-logo-content">
                            <div class="main-content flex flex-column">
                                    <p class="title-logo">
                                        BUDI ATMOJO
                                    </p>
                                    <svg
                                        width="352"
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
                                    <p class="title-place">
                                        Surakarta
                                    </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-none">
                    <ul class="menu menu-horizontal p-0 text-menuColor">
                        <li>
                            <a href="dashboard" class="hover:bg-bgHover hover:text-white">
                                Beranda
                            </a>
                        </li>
                        <li tabindex="0">
                            <a class="hover:bg-bgHover hover:text-white">
                                Master
                                <svg
                                    class="fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 24 24"
                                >
                                <path
                                    d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"
                                />
                                </svg>
                            </a>
                            <ul class="p-2 bg-white shadow z-[99]">
                                <li>
                                    <a href="barang" class="hover:bg-bgHover hover:text-white" >
                                        Master Barang
                                    </a>
                                </li>
                                <li>
                                    <a href="kategori" class="hover:bg-bgHover hover:text-white" >
                                        Master Kategori
                                    </a>
                                </li>
                                <li>
                                    <a href="pegawai" class="hover:bg-bgHover hover:text-white" >
                                        Master Pegawai
                                    </a>
                                </li>
                                <li>
                                    <a href="stok" class="hover:bg-bgHover hover:text-white" >
                                        Master Stok
                                    </a>
                                </li>
                                <li>
                                <a href="member" class="hover:bg-bgHover hover:text-white" >
                                    Master Member
                                </a>
                                </li>
                                <li>
                                    <a href="promo"  class="hover:bg-bgHover hover:text-white" >
                                        Master Promo
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="hover:bg-bgHover hover:text-white">
                                Riwayat Pembelian
                            </a>
                        </li>
                        <li>
                            <a class="hover:bg-bgHover hover:text-white">
                                Pengaturan
                            </a>
                        </li>
                        <li>
                            <a href="logout" class="hover:bg-bgHover hover:text-white">
                                Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page Heading -->
            <header v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>

            <footer class="footer footer-center p-10">
                <div class="all-logo-container">
                    <div class="container-content-footer">
                        <div class="logo-picture-footer">
                            <svg
                                class="logo"
                                width="5rem"
                                height="5rem"
                                viewBox="0 0 287 290"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <ellipse
                                    cx="143.5"
                                    cy="145"
                                    rx="143.5"
                                    ry="145"
                                    fill="white"
                                />
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M267 144.5C267 213.907 211.388 270 143 270C74.6116 270 19 213.907 19 144.5C19 133.478 20.4024 122.792 23.0357 112.612L92.8 112.9C98.5 112.9 101.2 114.4 101.2 118.15C101.2 123.1 93.25 129.85 77.65 139.9C96.55 150.1 105.85 159.1 105.85 167.5C105.85 171.7 103.15 173.65 97.75 173.65H76.9V117.4H47.8V199H90.7C107.05 199 118.75 198.55 126.4 193.9C134.65 188.95 138.85 181 138.85 170.65C138.85 158.95 132.25 147.55 119.5 138.55C129.1 130.6 133.75 122.5 133.75 112.6C133.75 96.25 121.9 87.85 98.35 87.85H32.3182C52.7852 46.9712 94.707 19 143 19C191.293 19 233.215 46.9712 253.682 87.85H218.651C196.451 87.85 179.651 93.55 167.501 105.7C154.901 118.3 147.251 137.65 147.251 159.25C147.251 178 153.251 196.45 165.101 214.6L188.801 199C181.751 187.6 178.001 175.9 177.401 163.9H208.751V199H238.751V117.4H208.751V138.25H180.401C187.001 120.25 199.301 112.9 220.601 112.9L262.965 112.617C265.598 122.795 267 133.48 267 144.5ZM276 144.5C276 218.782 216.454 279 143 279C69.5461 279 10 218.782 10 144.5C10 70.2177 69.5461 10 143 10C216.454 10 276 70.2177 276 144.5Z"
                                    fill="#696969"
                                />
                            </svg>
                        </div>
                        <div class="main-logo-content-footer">
                            <div class="main-content-footer">
                                <p class="title-logo-footer">
                                    BUDI ATMOJO
                                </p>
                                <svg
                                    class="line"
                                    viewBox="0 0 173 2"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                <path
                                    d="M1 1H86.25H171.5"
                                    stroke="white"
                                    stroke-opacity="0.89"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                />
                                </svg>
                                <p class="title-address-footer">
                                    Jl Tanjung Anom No.9
                                </p>
                                <p class="title-place-footer">
                                    Surakarta
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="grid grid-flow-col gap-4">
                        <a><svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            class="fill-current"
                        >
                        <path
                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"
                        /></svg></a>
                        <a><svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            class="fill-current"
                        >
                        <path
                            d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"
                        /></svg></a>
                        <a><svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            class="fill-current"
                        >
                        <path
                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"
                        /></svg></a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>

<style scoped>
.navbar {
    width: 100%;
    background-color: #ffffff;
    font-family: "Inter";
    font-weight: 600;
}
/* .btn-nav:hover {
    background-color: #4a4a4a;
    color: #ffffff;
} */
.container-content {
    width: 25rem;
    display: flex;
    flex-direction: row;
    margin-left: 1rem;
}
.logo-picture {
    padding-left: 1rem;
    flex: 1;
}
.main-logo-content {
    flex: 3;
}
.main-content {
    display: flex;
    flex-direction: column;
    padding-left: 1rem;
    color: #9a9a9a;
}
.title-logo {
    font-family: "Kadwa";
    font-weight: bold;
    font-size: 32px;
    flex: 1;
    text-align: left;
}
.title-address {
    font-family: "Inter";
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    letter-spacing: 0.03em;
    text-align: left;
    flex: 1;
}
.title-place {
    font-family: "Inter";
    font-style: normal;
    font-weight: 600;
    font-size: 20px;
    letter-spacing: 0.17em;
    flex: 1;
    text-align: left;
}
.flex-none {
    margin-right: 2rem;
}
.footer {
    width: 100%;
    background-color: #696969;
    color: #ffff;
}
.container-content-footer {
    width: 25rem;
    display: flex;
    flex-direction: row;
    margin-left: 1rem;
}
.logo-picture-footer {
    padding-left: 1rem;
    flex: 1;
}
.main-logo-content-footer {
    flex: 3;
}
.main-content-footer {
    display: flex;
    flex-direction: column;
    padding-left: 1rem;
    color: #ffff;
}
.title-logo-footer {
    font-family: "Kadwa";
    font-weight: bold;
    font-size: 32px;
    flex: 1;
    text-align: left;
    padding-top: 0.25rem;
}
.line {
    width: 13.75rem;
    padding-top: 0.625rem;
}
.title-address-footer {
    font-family: "Inter";
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    letter-spacing: 0.03em;
    text-align: left;
}
.title-place-footer {
    font-family: "Inter";
    font-style: normal;
    font-weight: 600;
    font-size: 20px;
    letter-spacing: 0.17em;
    flex: 1;
    text-align: left;
}
</style>