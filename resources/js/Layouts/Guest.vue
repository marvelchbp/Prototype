<script setup>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-backg">
        <div>
            <Link href="/">
                <BreezeApplicationLogo class="fill-current" :size=192 />
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden">
            <slot />
        </div>
    </div>
</template>

