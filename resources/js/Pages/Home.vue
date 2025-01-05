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
            <div class="w-full relative">
              <div class="absolute inset-0 bg-gray-600 opacity-30 h-[75%] mt-20"></div>
              <div class="relative z-20">
                <ProjectFeature />
                <ContactSection />
              </div>
            </div>
            <blockquote class="text-center mb-10">
              <p class="font-bold text-base xl:text-lg">{{ $t('quote.text') }}</p>
              <cite>{{ $t('quote.author') }}</cite>
            </blockquote>
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
  import { onMounted } from "vue";
  import { useMeta } from "vue-meta";

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
    setup() {
      // Configuração das meta tags dinâmicas usando vue-meta
      useMeta({
        title: "Página Inicial - Tecozi", // Defina o título da página
        meta: [
          {
            name: "description",
            content:
              "Bem-vindo à Tecozi, especializada em design e fabricação de cozinhas, guarda-roupas e outros móveis sob medida. Descubra nossos projetos e serviços.",
          },
          {
            name: "keywords",
            content: "cozinhas, guarda-roupas, móveis sob medida, design de interiores, Tecozi",
          },
          {
            property: "og:title",
            content: "Página Inicial - Tecozi", // Título Open Graph
          },
          {
            property: "og:description",
            content:
              "Bem-vindo à Tecozi, especializada em design e fabricação de cozinhas, guarda-roupas e outros móveis sob medida. Descubra nossos projetos e serviços.",
          },
          {
            property: "og:type",
            content: "website",
          },
          {
            property: "og:url",
            content: window.location.href,
          },
          {
            name: "twitter:title",
            content: "Página Inicial - Tecozi", // Título Twitter Card
          },
          {
            name: "twitter:description",
            content:
              "Bem-vindo à Tecozi, especializada em design e fabricação de cozinhas, guarda-roupas e outros móveis sob medida. Descubra nossos projetos e serviços.",
          },
        ],
      });

      // Adicionar o link canonical dinamicamente
      onMounted(() => {
        const canonicalLink = document.querySelector("link[rel='canonical']");
        if (canonicalLink) {
          canonicalLink.href = window.location.href;
        } else {
          const link = document.createElement("link");
          link.rel = "canonical";
          link.href = window.location.href;
          document.head.appendChild(link);
        }
      });
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
