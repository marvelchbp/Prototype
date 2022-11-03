<script setup >
    import NavbarTransaksi from '../components/navbarKasir.vue';
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
   <NavbarTransaksi />
   <main>
        <slot />
   </main>
   <Footer />
</template>