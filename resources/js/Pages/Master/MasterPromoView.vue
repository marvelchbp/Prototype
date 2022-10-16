<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    // name: '',
    // email: '',
    // password: '',
    // phone: '',
    // password_confirmation: '',
    // terms: false,
});

const submit = () => {
};
</script>

<template>
    <Head title="Master Promo" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-4xl text-gray-800 leading-tight">
                Master Promo
            </h2>
        </template>
        <!-- Search -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="form-control w-full max-w-lg">
                    <label class="label">
                        <span class="label-text">Search</span>
                    </label>
                    <input type="text" placeholder="Search Item Here" class="input input-bordered w-full max-w-lg" />
                </div>
            </div>
        </div>
        <!-- Tabel -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="table table-normal w-full">
                        <!-- head -->
                        <thead >
                        <tr>
                            <th class="header-table">Kode Promo</th>
                            <th class="header-table">Deskripsi Promo</th>
                            <th class="header-table">Potongan (Persentase)</th>
                            <th class="header-table">Keterangan</th>
                            <th class="header-table">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- row -->
                        <tr class="hover">
                            <th class="number">LEBARAN2022</th>
                            <td>Promo potongan harga saat lebaran</td>
                            <td>30</td>
                            <td> <div class="text-green-600 font-bold uppercase"> Aktif </div> </td>
                            <td>
                                <button class="btn btn-xs sm:btn-sm sm:btn-outline md:btn-md md:btn-outline lg:btn lg:btn-outline hover:bg-bgHover hover:text-white">Delete</button>
                            </td>
                        </tr>
                        <tr class="hover">
                            <th class="number">MERDEKA2022</th>
                            <td>Potongan Harga edisi kemerdekaan</td>
                            <td>20</td>
                            <td> <div class="text-green-600 font-bold uppercase"> Aktif </div> </td>
                             <td>
                                <button class="btn btn-xs sm:btn-sm sm:btn-outline md:btn-md md:btn-outline lg:btn lg:btn-outline hover:bg-bgHover hover:text-white">Delete</button>
                            </td>
                        </tr>
                        <tr class="hover">
                            <th class="number">HUT2022</th>
                            <td>Promo Ulang Tahun Toko</td>
                            <td>50</td>
                            <td> <div class="text-green-600 font-bold uppercase"> Aktif </div> </td>
                             <td>
                                <button class="btn btn-xs sm:btn-sm sm:btn-outline md:btn-md md:btn-outline lg:btn lg:btn-outline hover:bg-bgHover hover:text-white">Delete</button>
                            </td>
                        </tr>
                        <tr class="hover">
                            <th class="number">NATAL2022</th>
                            <td>Promo potongan Hari Natal</td>
                            <td>30</td>
                            <td> <div class="text-green-600 font-bold uppercase"> Aktif </div> </td>
                             <td>
                                <button class="btn btn-xs sm:btn-sm sm:btn-outline md:btn-md md:btn-outline lg:btn lg:btn-outline hover:bg-bgHover hover:text-white">Delete</button>
                            </td>
                        </tr>
                        <tr class="hover">
                            <th class="number">WEEKENDDEALS</th>
                            <td>Potongan harga disaat weekend</td>
                            <td>10</td>
                            <td> <div class="text-red-600 font-bold uppercase"> Non Aktif </div> </td>
                             <td>
                                <button class="btn btn-xs sm:btn-sm sm:btn-outline md:btn-md md:btn-outline lg:btn lg:btn-outline hover:bg-bgHover hover:text-white">Restore</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="max-w-7xl mx-auto pt-4 sm:px-6 lg:px-[34rem]">
                    <div class="btn-group">
                        <button class="btn btn-md bg-backg text-xl text-black border-none hover:bg-bgHover hover:text-white">«</button>
                        <button class="btn btn-md bg-backg text-base text-black border-none hover:bg-backg hover:text-black">1</button>
                        <button class="btn btn-md bg-backg text-xl text-black border-none hover:bg-bgHover hover:text-white">»</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Input -->
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <div class="form-control w-full max-w-lg pb-5">
                        <label class="label">
                            <span class="label-text">Kode Promo</span>
                        </label>
                        <input type="text" placeholder="Masukkan Kode Promo" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-lg pb-5">
                        <label class="label">
                            <span class="label-text">Deskripsi Promo</span>
                        </label>
                        <input type="text" placeholder="Masukkan Deskripsi Promo" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-lg pb-5">
                        <label class="label">
                            <span class="label-text">Potongan</span>
                        </label>
                        <input type="text" placeholder="Masukkan Potongan" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-fit py-5">
                        <BreezeButton class="ml-50" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Submit
                        </BreezeButton>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.header-table{
    background-color: #EFEFEF;
    color: black;
}
td, .number{
    background-color: white;
    color: black;
}
</style>