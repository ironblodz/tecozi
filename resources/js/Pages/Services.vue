<template>
    <div>
      <Navbar />
      <Service />
      <Footer />
    </div>
  </template>

  <script>
  import Navbar from '@/Components/Header/Navbar.vue';
  import Service from '@/Components/ServiceSections/Service.vue';
  import Footer from '@/Components/Footer/Footer.vue';
  import { onMounted } from 'vue';
  import { useMeta } from 'vue-meta'; // Importando vue-meta

  export default {
    name: 'Services',
    components: {
      Navbar,
      Service,
      Footer
    },
    setup() {
      // Definir as meta tags dinâmicas e o link canonical
      useMeta({
        title: 'Nossos Serviços - Tecozi', // Título da página
        meta: [
          {
            name: 'description',
            content: 'A Tecozi oferece uma variedade de serviços especializados, incluindo o design e fabricação de cozinhas, guarda-roupas e mais.',
          },
          {
            name: 'keywords',
            content: 'serviços, design de interiores, cozinhas, guarda-roupas, Tecozi',
          },
          {
            property: 'og:title',
            content: 'Nossos Serviços - Tecozi',
          },
          {
            property: 'og:description',
            content: 'A Tecozi oferece uma variedade de serviços especializados, incluindo o design e fabricação de cozinhas, guarda-roupas e mais.',
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
            content: 'Nossos Serviços - Tecozi',
          },
          {
            name: 'twitter:description',
            content: 'A Tecozi oferece uma variedade de serviços especializados, incluindo o design e fabricação de cozinhas, guarda-roupas e mais.',
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
