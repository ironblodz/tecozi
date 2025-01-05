<template>
    <div>
      <Navbar />
      <DisputeResolution />
      <Footer ref="footer" />
    </div>
  </template>

  <script>
  import DisputeResolution from '@/Components/PrivacySections/DisputeResolution.vue';
  import Navbar from "../Components/Header/Navbar.vue";
  import Footer from "@/Components/Footer/Footer.vue";
  import { onMounted } from 'vue';
  import { useMeta } from 'vue-meta'; // Importando vue-meta

  export default {
    name: 'Resolution',
    components: {
      DisputeResolution,
      Navbar,
      Footer
    },
    setup() {
      // Definir as meta tags dinâmicas e o link canonical
      useMeta({
        title: 'Resolução de Disputas - Tecozi', // Título da página
        meta: [
          {
            name: 'description',
            content: 'A seção de resolução de disputas da Tecozi fornece soluções eficazes e rápidas para resolver questões com nossos produtos e serviços.',
          },
          {
            name: 'keywords',
            content: 'resolução de disputas, conflitos, Tecozi, serviço ao cliente',
          },
          {
            property: 'og:title',
            content: 'Resolução de Disputas - Tecozi',
          },
          {
            property: 'og:description',
            content: 'A seção de resolução de disputas da Tecozi fornece soluções eficazes e rápidas para resolver questões com nossos produtos e serviços.',
          },
          {
            property: 'og:type',
            content: 'website',
          },
          {
            property: 'og:url',
            content: window.location.href,
          },
          {
            name: 'twitter:title',
            content: 'Resolução de Disputas - Tecozi',
          },
          {
            name: 'twitter:description',
            content: 'A seção de resolução de disputas da Tecozi fornece soluções eficazes e rápidas para resolver questões com nossos produtos e serviços.',
          }
        ]
      });

      // Atualizar ou adicionar o link canonical
      onMounted(() => {
        const canonicalLink = document.querySelector('link[rel="canonical"]');
        if (canonicalLink) {
          canonicalLink.href = window.location.href;
        } else {
          const link = document.createElement('link');
          link.rel = 'canonical';
          link.href = window.location.href;
          document.head.appendChild(link);
        }
      });
    }
  };
  </script>
