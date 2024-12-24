<!-- resources/js/Pages/Home.vue -->
<template>
    <main>
        <Navbar />
        <div class="fixed bottom-4 right-4 z-50 cursor-pointer animate-float" @click="scrollToTop">
            <img :src="Top" alt="floating image" class="w-12 h-12" />
        </div>
        <Carousel />
        <ProjectDone />
        <ProjectFeature />
        <ContactSection />
        <Footer />
    </main>
</template>

<script>
import Navbar from "../Components/Header/Navbar.vue";
import Carousel from "../Components/Header/Carousel.vue";
import ProjectDone from "@/Components/HomeSections/ProjectDone.vue";
import ProjectFeature from "@/Components/HomeSections/ProjectFeature.vue";
import ContactSection from "@/Components/HomeSections/ContactSection.vue";
import Footer from "@/Components/Footer/Footer.vue";

import Top from "@/assets/images/home/Top.svg";

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
            Top,
        };
    },
    props: {
        imageSrc: {
            type: String,
            required: true,
        },
    },
    methods: {
        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        },
    },
};
</script>
