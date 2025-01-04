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

  export default {
    name: 'Resolution',
    components: {
      DisputeResolution,
      Navbar,
      Footer
    }
  };
  </script>
