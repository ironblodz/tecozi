<template>
    <Navbar />
    <Contacts />
    <Footer />
</template>

<script>
import Navbar from "@/Components/Header/Navbar.vue";
import Contacts from "@/Components/ContactSection/Contact.vue";
import Footer from "@/Components/Footer/Footer.vue";


export default {
    name: "Contact",
    components: {
        Navbar,
        Contacts,
        Footer,
    },
};
</script>
