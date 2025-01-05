<template>
    <Navbar />
    <Materials />
    <Footer />
  </template>

  <script>
  import Navbar from '@/Components/Header/Navbar.vue';
  import Materials from '@/Components/MaterialSections/Materials.vue';
  import Footer from '@/Components/Footer/Footer.vue';
  import { onMounted } from 'vue';
  import { useMeta } from 'vue-meta';

  export default {
    name: "Material",
    components: {
      Navbar,
      Materials,
      Footer
    },
    setup() {
      // Definir as meta tags dinâmicas e o link canonical
      useMeta({
        title: 'Material - Tecozi', // Título da página
        meta: [
          {
            name: 'description',
            content: 'Explore os materiais de alta qualidade da Tecozi para a sua cozinha e outros projetos de móveis planejados.'
          },
          {
            name: 'keywords',
            content: 'materiais, móveis planejados, cozinha, armários, qualidade, Tecozi'
          },
          {
            property: 'og:title',
            content: 'Material - Tecozi'
          },
          {
            property: 'og:description',
            content: 'Explore os materiais de alta qualidade da Tecozi para a sua cozinha e outros projetos de móveis planejados.'
          },
          {
            property: 'og:type',
            content: 'website'
          },
          {
            property: 'og:url',
            content: window.location.href
          },
          {
            name: 'twitter:title',
            content: 'Material - Tecozi'
          },
          {
            name: 'twitter:description',
            content: 'Explore os materiais de alta qualidade da Tecozi para a sua cozinha e outros projetos de móveis planejados.'
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
