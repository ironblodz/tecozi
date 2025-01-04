<template>
  <div class="maintenance-page">
    <div class="content">
      <img src="/assets/maintenance.png" alt="Manutenção" class="maintenance-image" />
      <h1>Estamos em Construção</h1>
      <p>Desculpe pelo inconveniente. Site brevemente disponível!</p>
      <p>Obrigado pela sua paciência.</p>
      <button @click="contactSupport" class="contact-button">Entre em Contato</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "MaintenancePage",
  methods: {
    contactSupport() {
      alert("Por favor, envie um e-mail para geral.konseptus@gmail.com");
    },
  },
};
</script>

<style scoped>
.maintenance-page {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background: linear-gradient(135deg, #f8f9fa, #e9ecef);
  font-family: 'Arial', sans-serif;
  color: #495057;
}

.content {
  text-align: center;
  max-width: 500px;
  background: #ffffff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.maintenance-image {
  max-width: 100%;
  height: auto;
  margin-bottom: 20px;
}

h1 {
  font-size: 2rem;
  margin-bottom: 10px;
}

p {
  font-size: 1rem;
  line-height: 1.5;
  margin-bottom: 20px;
}

.contact-button {
  background-color: #007bff;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
}

.contact-button:hover {
  background-color: #0056b3;
}
</style>
