<template>
<Navbar />
<Service />
<Footer />
</template>

<script>
import Navbar from '@/Components/Header/Navbar.vue';
import Service from '@/Components/ServiceSections/Service.vue';
import Footer from '@/Components/Footer/Footer.vue';

export default {
    name: "Services",
    components: {
        Navbar,
        Service,
        Footer
    },
    data(){
        return {

        }
    }
}
</script>
