<script setup >
    import Navbar from '../components/navbar.vue';
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
   <Navbar />
   <main>
        <slot />
   </main>
   <Footer />
</template>