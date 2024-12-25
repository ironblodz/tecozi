<!-- resources/js/Pages/Home.vue -->
<template>
     <main>
        <Navbar />
        <!-- Botão de "scroll to top" com a imagem que muda dinamicamente -->
        <div
            class="fixed bottom-4 right-4 z-50 cursor-pointer animate-float"
            @click="scrollToTop"
        >
            <img :src="topImage" alt="floating image" class="w-12 h-12" />
        </div>
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

import Top from "@/assets/images/home/Top.svg";
import TopOnScroll from "@/assets/images/services/scroll.png";  // Nova imagem

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
            TopOnScroll, // Nova imagem para quando o footer aparecer
            topImage: Top, // Imagem inicial
        };
    },
    mounted() {
        this.setupIntersectionObserver();
    },
    methods: {
        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        },
        setupIntersectionObserver() {
            const observer = new IntersectionObserver(
                ([entry]) => {
                    // Verifica se o footer está visível
                    if (entry.isIntersecting) {
                        this.topImage = this.TopOnScroll;  // Muda a imagem quando o footer aparecer
                    } else {
                        this.topImage = this.Top;  // Restaura a imagem original
                    }
                },
                {
                    threshold: 1.0,  // O footer deve estar 100% visível para a troca
                }
            );

            observer.observe(this.$refs.footer); // Observa o footer
        },
    },
};
</script>
