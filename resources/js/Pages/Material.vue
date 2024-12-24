<template>
<Navbar/>
<Materials/>
<Footer/>
</template>

<script>
import Navbar from '@/Components/Header/Navbar.vue';
import Materials from '@/Components/MaterialSections/Materials.vue';
import Footer from '@/Components/Footer/Footer.vue';
export default {
    name: "Material",
    components: {
        Navbar,
        Materials,
        Footer
    },
    data() {
        return {

        }
    }
}

</script>
