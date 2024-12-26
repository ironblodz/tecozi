<template>
    <main>
      <!-- Envolva em um único transition para evitar separação -->
      <transition name="fade">
        <template v-if="showPreloader">
          <Preloader @animation-complete="onAnimationComplete" />
        </template>
        <template v-else>
          <div>
            <Navbar />
            <Carousel />
            <ProjectDone />
            <ProjectFeature />
            <ContactSection />
            <Footer ref="footer" />
          </div>
        </template>
      </transition>
    </main>
  </template>

<script>
import Navbar from "../Components/Header/Navbar.vue";
import Carousel from "../Components/Header/Carousel.vue";
import ProjectDone from "@/Components/HomeSections/ProjectDone.vue";
import ProjectFeature from "@/Components/HomeSections/ProjectFeature.vue";
import ContactSection from "@/Components/HomeSections/ContactSection.vue";
import Footer from "@/Components/Footer/Footer.vue";
import Preloader from "../Components/Preloader.vue";

export default {
  name: "Home",
  components: {
    Navbar,
    Carousel,
    ProjectDone,
    ProjectFeature,
    ContactSection,
    Footer,
    Preloader,
  },
  data() {
    return {
      showPreloader: true, // Controla a exibição do Preloader
    };
  },
  methods: {
    // Método chamado quando o Preloader completa sua animação
    onAnimationComplete() {
      this.showPreloader = false;
      document.body.classList.add("loaded"); // Garante que o corpo da página tenha uma classe específica
    },
  },
};
</script>
<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
