<template>
    <Navbar />
    <Portfolio />
    <Footer />
    </template>

    <script>
    import Navbar from '@/Components/Header/Navbar.vue';
    import Portfolio from '@/Components/PortfolioSections/Portfolios.vue';
    import Footer from '@/Components/Footer/Footer.vue';

    export default {
        name: "Projects",
        components: {
            Navbar,
            Portfolio,
            Footer
        },
        data(){
            return {

            }
        }
    }
    </script>
