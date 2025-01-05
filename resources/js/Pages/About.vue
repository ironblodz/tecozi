<template>
    <div>
      <Navbar />
      <History />
      <Footer />
    </div>
  </template>

  <script>
  import Navbar from "@/Components/Header/Navbar.vue";
  import History from "@/Components/AboutSections/History.vue";
  import Footer from "@/Components/Footer/Footer.vue";
  import { onMounted } from "vue";
  import { useMeta } from "vue-meta"; // Importando vue-meta para gerenciar as meta tags

  export default {
    name: "Home",
    components: {
      Navbar,
      History,
      Footer
    },
    setup() {
      // Configuração das meta tags dinâmicas usando vue-meta
      useMeta({
        title: "História - Tecozi", // Título da página
        meta: [
          {
            name: "description",
            content:
              "Descubra a história da Tecozi, nossa trajetória na fabricação de móveis sob medida e como transformamos a experiência de nossos clientes.",
          },
          {
            name: "keywords",
            content: "história, Tecozi, móveis sob medida, design de interiores",
          },
          {
            property: "og:title",
            content: "História - Tecozi", // Título Open Graph
          },
          {
            property: "og:description",
            content:
              "Descubra a história da Tecozi, nossa trajetória na fabricação de móveis sob medida e como transformamos a experiência de nossos clientes.",
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
            content: "História - Tecozi", // Título Twitter Card
          },
          {
            name: "twitter:description",
            content:
              "Descubra a história da Tecozi, nossa trajetória na fabricação de móveis sob medida e como transformamos a experiência de nossos clientes.",
          },
        ],
      });

      // Adicionando o link canônico dinamicamente
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
  /* Adicione seu estilo aqui, se necessário */
  </style>
