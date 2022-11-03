<script setup >
    import NavbarPegawai from '../components/navbarPeg.vue';
    import Footer from '../components/footer.vue';
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
    
    },
}
</script>

<template>
   <NavbarPegawai />
   <main>
        <slot />
   </main>
   <Footer />
</template>