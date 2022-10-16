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
    <Head title="Master Stok" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-4xl text-gray-800 leading-tight">
                Master Stok
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
                            <th class="header-table">Stok</th>
                            <th class="header-table">Dibuat Oleh</th>
                            <th class="header-table">Tanggal</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- row -->
                        <tr class="hover">
                            <th class="number">01LAMRH12PCS</th>
                            <td>10</td>
                            <td>karyawan1</td>
                            <td>30 July 2022</td>
                        </tr>
                        <tr class="hover">
                            <th class="number">01LAMRH16SLP</th>
                            <td>7</td>
                            <td>karyawan3</td>
                            <td>28 July 2022</td>
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
                    <div class="form-control w-full flex flex-row justify-start pb-5">
                        <label class="label cursor-pointer">
                            <span class="label-text font-bold pr-4">Tambah</span> 
                            <input type="radio" name="radioStok" class="radio checked:bg-black-600 checked:bg-none text-black pr-4" checked />
                        </label>
                        <label class="label cursor-pointer">
                            <span class="label-text font-bold pr-4">Ubah</span> 
                            <input type="radio" name="radioStok" class="radio checked:bg-black-600 checked:bg-none text-black" />
                        </label>
                    </div>
                    <div class="form-control w-full max-w-lg pb-5">
                        <label class="label">
                            <span class="label-text">Kode Stock</span>
                        </label>
                        <input type="text" placeholder="Masukkan Kode Stok" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-lg pb-5">
                        <label class="label">
                            <span class="label-text">Jumlah Stok</span>
                        </label>
                        <input type="text" placeholder="Masukkan Jumlah Stok" class="input input-bordered w-full max-w-lg" />
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