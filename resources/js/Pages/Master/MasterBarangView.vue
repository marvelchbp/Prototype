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
    <Head title="Master Barang" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-4xl text-gray-800 leading-tight">
                Master Barang
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
        <div class="pb-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="table table-normal w-full">
                        <!-- head -->
                        <thead >
                        <tr>
                            <th class="header-table">Kode Stock</th>
                            <th class="header-table">Nama Barang</th>
                            <th class="header-table">Satuan</th>
                            <th class="header-table">Faktor</th>
                            <th class="header-table">Harga Grosir</th>
                            <th class="header-table">Harga Eceran</th>
                            <th class="header-table">Keterangan</th>
                            <th class="header-table">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- row -->
                        <tr class="hover">
                            <th class="number">01LAICEPURPLE16SLP</th>
                            <td>LA ICE PURPLE 16</td>
                            <td>SLOP</td>
                            <td>10</td>
                            <td>260.000</td>
                            <td>260.000</td>
                            <td> <div class="text-success font-bold uppercase"> Aktif </div> </td>
                            <td>
                                <button class="btn btn-xs sm:btn-sm sm:btn-outline md:btn-md md:btn-outline lg:btn lg:btn-outline hover:bg-bgHover hover:text-white">Delete</button>
                            </td>
                        </tr>
                        <tr class="hover">
                            <th class="number">01LAMRH12PCS</th>
                            <td>LA MERAH 12</td>
                            <td>PCS</td>
                            <td>1</td>
                            <td>17.800</td>
                            <td>17.800</td>
                            <td> <div class="text-success font-bold uppercase"> Aktif </div> </td>
                             <td>
                                <button class="btn btn-xs sm:btn-sm sm:btn-outline md:btn-md md:btn-outline lg:btn lg:btn-outline hover:bg-bgHover hover:text-white">Delete</button>
                            </td>
                        </tr>
                        <tr class="hover">
                            <th class="number">01LAMRH12SLP</th>
                            <td>LA MERAH 12</td>
                            <td>SLOP</td>
                            <td>10</td>
                            <td>177.000</td>
                            <td>177.000</td>
                            <td> <div class="text-success font-bold uppercase"> Aktif </div> </td>
                             <td>
                                <button class="btn btn-xs sm:btn-sm sm:btn-outline md:btn-md md:btn-outline lg:btn lg:btn-outline hover:bg-bgHover hover:text-white">Delete</button>
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
                            <span class="label-text">Kode Stock</span>
                        </label>
                        <input type="text" placeholder="Masukkan Kode Stock" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-lg pb-5">
                        <label class="label">
                            <span class="label-text">Nama Barang</span>
                        </label>
                        <input type="text" placeholder="Masukkan Nama Barang" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-lg pb-5">
                        <label class="label">
                            <span class="label-text">Satuan</span>
                        </label>
                        <input type="text" placeholder="Masukkan Satuan" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-lg pb-5">
                        <label class="label">
                            <span class="label-text">Harga Grosir</span>
                        </label>
                        <input type="text" placeholder="Masukkan Harga Grosir" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-lg pb-5">
                        <label class="label">
                            <span class="label-text">Harga Eceran</span>
                        </label>
                        <input type="text" placeholder="Masukkan Harga Eceran" class="input input-bordered w-full max-w-lg" />
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