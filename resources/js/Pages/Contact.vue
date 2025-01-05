<template>
    <Navbar />
    <Contacts />
    <Footer />
  </template>

  <script>
  import Navbar from "@/Components/Header/Navbar.vue";
  import Contacts from "@/Components/ContactSection/Contact.vue";
  import Footer from "@/Components/Footer/Footer.vue";
  import { onMounted } from "vue";
  import { useMeta } from "vue-meta";

  export default {
    name: "Contact",
    components: {
      Navbar,
      Contacts,
      Footer,
    },
    setup() {
      // Definir as meta tags dinâmicas e o link canonical
      useMeta({
        title: "Contato - Tecozi", // Título da página
        meta: [
          {
            name: "description",
            content:
              "Entre em contato com a Tecozi. Oferecemos soluções personalizadas em móveis planejados para sua cozinha, closets e outros ambientes.",
          },
          {
            name: "keywords",
            content: "contato, móveis planejados, cozinha, armários, Tecozi, soluções personalizadas",
          },
          {
            property: "og:title",
            content: "Contato - Tecozi",
          },
          {
            property: "og:description",
            content:
              "Entre em contato com a Tecozi. Oferecemos soluções personalizadas em móveis planejados para sua cozinha, closets e outros ambientes.",
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
            content: "Contato - Tecozi",
          },
          {
            name: "twitter:description",
            content:
              "Entre em contato com a Tecozi. Oferecemos soluções personalizadas em móveis planejados para sua cozinha, closets e outros ambientes.",
          },
        ],
      });

      // Atualizar ou adicionar o link canonical
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
