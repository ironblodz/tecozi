<template>
    <main>
      <Preloader v-if="showPreloader" @animation-complete="onAnimationComplete" />
      <div v-else>
        <Navbar />
        <Carousel />
        <ProjectDone />
        <ProjectFeature />
        <ContactSection />
        <Footer ref="footer" />
      </div>
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
      showPreloader: true,
    };
  },
  methods: {
    onAnimationComplete() {
      this.showPreloader = false;
    },
  },
  mounted() {
  document.body.classList.add("loaded");
}

};
</script>
