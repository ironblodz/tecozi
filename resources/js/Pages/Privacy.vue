<template>
    <div>
      <Navbar />
      <PrivacyPolicy />
      <Footer ref="footer" />
    </div>
  </template>

  <script>
  import PrivacyPolicy from '@/Components/PrivacySections/PrivacyPolicy.vue';
  import Navbar from "../Components/Header/Navbar.vue";
  import Footer from "@/Components/Footer/Footer.vue";
  import { onMounted } from 'vue';
  import { useMeta } from 'vue-meta';

  export default {
    name: 'Privacy',
    components: {
      PrivacyPolicy,
      Navbar,
      Footer
    },
    setup() {
      useMeta({
        title: 'Política de Privacidade - Tecozi',
        meta: [
          {
            name: 'description',
            content: 'Leia a política de privacidade da Tecozi, que descreve como coletamos, usamos e protegemos suas informações pessoais.',
          },
          {
            name: 'keywords',
            content: 'política de privacidade, proteção de dados, Tecozi, segurança',
          },
          {
            property: 'og:title',
            content: 'Política de Privacidade - Tecozi',
          },
          {
            property: 'og:description',
            content: 'Leia a política de privacidade da Tecozi, que descreve como coletamos, usamos e protegemos suas informações pessoais.',
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
            content: 'Política de Privacidade - Tecozi',
          },
          {
            name: 'twitter:description',
            content: 'Leia a política de privacidade da Tecozi, que descreve como coletamos, usamos e protegemos suas informações pessoais.',
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
