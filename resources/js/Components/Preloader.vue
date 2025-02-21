<template>
    <div v-if="isVisible" class="preloader flex items-center justify-center bg-primary-default">
      <div class="text-center">
        <!-- Logotipo animado -->
        <div ref="logoContainer" class="opacity-0 scale-50">
          <img :src="logo" alt="Logotipo" class="mx-auto w-32" />
        </div>
      </div>
    </div>
  </template>

  <script>
  import gsap from "gsap";
  import logo from "@/assets/images/logo/logot.svg";

  export default {
    name: "Preloader",
    data() {
      return {
        logo,
        isVisible: true,
      };
    },
    mounted() {
      this.startAnimation();
    },
    methods: {
      startAnimation() {
        gsap.to(this.$refs.logoContainer, {
          opacity: 1,
          scale: 1,
          duration: 1,
          ease: "power2.out",
        });

        setTimeout(() => {
          this.exitAnimation();
        }, 2500);
      },
      exitAnimation() {
        gsap.to(this.$refs.logoContainer, {
          opacity: 0,
          scale: 0.8,
          duration: 1,
          ease: "power2.inOut",
          onComplete: () => {
            this.isVisible = false;
            this.$emit("animation-complete");
          },
        });
        gsap.to(".preloader", {
          opacity: 0,
          duration: 1,
          ease: "power2.inOut",
          onComplete: () => {
            this.isVisible = false;
          },
        });
      },
    },
  };
  </script>

  <style scoped>
  .preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
  }
  </style>
