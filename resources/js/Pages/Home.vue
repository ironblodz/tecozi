<!-- resources/js/Pages/Home.vue -->
<template>
     <main>
        <Navbar />
        <Carousel />
        <ProjectDone />
        <ProjectFeature />
        <ContactSection />
        <Footer ref="footer" />
    </main>
</template>

<script>
import Navbar from "../Components/Header/Navbar.vue";
import Carousel from "../Components/Header/Carousel.vue";
import ProjectDone from "@/Components/HomeSections/ProjectDone.vue";
import ProjectFeature from "@/Components/HomeSections/ProjectFeature.vue";
import ContactSection from "@/Components/HomeSections/ContactSection.vue";
import Footer from "@/Components/Footer/Footer.vue";

export default {
    name: "Home",
    components: {
        Navbar,
        Carousel,
        ProjectDone,
        ProjectFeature,
        ContactSection,
        Footer,
    },
    data() {
        return {

        };
    },
    methods: {
    },
};
</script>
