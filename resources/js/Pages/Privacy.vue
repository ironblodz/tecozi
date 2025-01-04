<template>
    <div>
        <Navbar />
        <PrivacyPolicy />
        <Footer ref="footer" />
    </div>
</template>

<script>
import PrivacyPolicy from '@/Components/PrivacySections/PrivacyPolicy.vue';
import Navbar from "../Components/Header/Navbar.vue";
import Footer from "@/Components/Footer/Footer.vue";

export default {
    name: 'Privacy',
    components: {
        PrivacyPolicy,
        Navbar,
        Footer
    }
};
</script>
