<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-4xl text-gray-800 leading-tight">
                Dashboard
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
                            <th class="header-table"></th>
                            <th class="header-table">Name</th>
                            <th class="header-table">Job</th>
                            <th class="header-table">Favorite Color</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- row -->
                        <tr class="hover">
                            <th class="number">1</th>
                            <td>Cy Ganderton</td>
                            <td>Quality Control Specialist</td>
                            <td>Blue</td>
                        </tr>
                        <tr class="hover">
                            <th class="number">2</th>
                            <td>Hart Hagerty</td>
                            <td>Desktop Support Technician</td>
                            <td>Purple</td>
                        </tr>
                        <tr class="hover">
                            <th class="number">3</th>
                            <td>Brice Swyre</td>
                            <td>Tax Accountant</td>
                            <td>Red</td>
                        </tr>
                        <tr class="hover">
                            <th class="number">4</th>
                            <td>Cy Ganderton</td>
                            <td>Quality Control Specialist</td>
                            <td>Blue</td>
                        </tr>
                        <tr class="hover">
                            <th class="number">5</th>
                            <td>Hart Hagerty</td>
                            <td>Desktop Support Technician</td>
                            <td>Purple</td>
                        </tr>
                        <tr class="hover">
                            <th class="number">6</th>
                            <td>Brice Swyre</td>
                            <td>Tax Accountant</td>
                            <td>Red</td>
                        </tr>
                        <tr class="hover">
                            <th class="number">7</th>
                            <td>Cy Ganderton</td>
                            <td>Quality Control Specialist</td>
                            <td>Blue</td>
                        </tr>
                        <tr class="hover">
                            <th class="number">8</th>
                            <td>Hart Hagerty</td>
                            <td>Desktop Support Technician</td>
                            <td>Purple</td>
                        </tr>
                        <tr class="hover">
                            <th class="number">9</th>
                            <td>Brice Swyre</td>
                            <td>Tax Accountant</td>
                            <td>Red</td>
                        </tr>
                        <tr class="hover">
                            <th class="number">10</th>
                            <td>Brice Swyre</td>
                            <td>Tax Accountant</td>
                            <td>Red</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Input -->
        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" method="post">
                    <div class="form-control w-full max-w-lg">
                        <label class="label">
                            <span class="label-text">What is your name?</span>
                        </label>
                        <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-lg">
                        <label class="label">
                            <span class="label-text">What is your name?</span>
                        </label>
                        <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-lg">
                        <label class="label">
                            <span class="label-text">What is your name?</span>
                        </label>
                        <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-lg">
                        <label class="label">
                            <span class="label-text">What is your name?</span>
                        </label>
                        <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-lg" />
                    </div>
                    <div class="form-control w-full max-w-lg">
                        <label class="label">
                            <span class="label-text">What is your name?</span>
                        </label>
                        <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-lg" />
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
/* .item:hover{
    background-color: #AFAFAF;
    color: black;
} */
</style>