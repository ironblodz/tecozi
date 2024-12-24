<!-- resources/js/Pages/Home.vue -->
<template>

<Navbar/>
<History/>
<Footer/>
</template>

<script>
import Navbar from "@/Components/Header/Navbar.vue";
import History from "@/Components/AboutSections/History.vue"
import Footer from "@/Components/Footer/Footer.vue";


export default {
    name: "About",
    components: {
        Navbar,
        Footer,
        History
    },
};
</script>
