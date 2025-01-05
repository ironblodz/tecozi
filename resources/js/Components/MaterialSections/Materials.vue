<template>
  <section
    class="relative min-h-screen py-10 bg-gradient-to-br from-white via-gray-50 to-gray-100"
  >
    <!-- Imagem de fundo -->
    <img
      :src="kitchen"
      alt="Fundo Inferior Direito"
      class="absolute bottom-0 right-0 w-48 xl:w-60 scale-x-[-1] opacity-80 z-0"
    />

    <!-- TÍTULO E DESCRIÇÃO (inalterado) -->
    <div class="flex flex-col justify-center mx-10 mt-24 mb-10 text-center xl:text-left">
      <h1 class="text-primary-default text-2xl xl:text-3xl mb-3 z-20 tracking-wide">
        Trabalhamos com as
        <span class="text-secondary-default">melhores marcas</span>
        do mercado
      </h1>
      <p class="text-base xl:text-lg max-w-7xl mx-auto xl:mx-0 text-gray-600">
        Trabalho de qualidade acompanhado dos melhores materiais em cada projeto realizado!
        Os materiais que garantem o melhor resultado.
      </p>
    </div>
    <!-- FIM TÍTULO E DESCRIÇÃO -->

    <!-- CONTAINER PRINCIPAL (coluna cima + coluna baixo) -->
    <div class="flex flex-col gap-6 mx-10 mb-8 relative z-10">

      <!-- COLUNA ESQUERDA (EM CIMA): Cards em row -->
      <div class="flex flex-row flex-wrap w-full gap-6 justify-center">
        <!-- Card: Madeiras -->
        <div
        :class="[
      'shadow-md rounded-lg bg-white text-black p-4',
      'w-[272px] flex flex-col items-center',
      'cursor-pointer relative transition-transform duration-300',
      'hover:card-3d-transform',
      activeMaterial === 'madeiras' ? 'border-4 border-[#BF0404] bg-primary-default' : ''
    ]"
    @click="activeMaterial = 'madeiras'"
  >
    <img
      :src="Material2"
      alt="Madeiras"
      class="w-32 h-32 object-contain mb-4"
    />
    <p class="font-semibold text-lg xl:text-2xl text-center">Madeiras</p>
  </div>

        <!-- Card: Ferragens -->
        <div
        :class="[
      'shadow-md rounded-lg bg-white text-black p-4',
      'w-[272px] flex flex-col items-center',
      'cursor-pointer relative transition-transform duration-300',
      'hover:card-3d-transform',
            activeMaterial === 'ferragens' ? 'border-4 border-[#BF0404]' : ''
          ]"
          @click="activeMaterial = 'ferragens'"
        >
          <img
            :src="Material3"
            alt="Ferragens"
            class="w-32 h-32 object-contain mb-2"
          />
          <p class="font-semibold text-base xl:text-xl text-center">Ferragens</p>
        </div>

        <!-- Card: Acessórios -->
        <div
        :class="[
      'shadow-md rounded-lg bg-white text-black p-4',
      'w-[272px] flex flex-col items-center',
      'cursor-pointer relative transition-transform duration-300',
      'hover:card-3d-transform',
            activeMaterial === 'acessorios' ? 'border-4 border-[#BF0404]' : ''
          ]"
          @click="activeMaterial = 'acessorios'"
        >
          <img
            :src="Material4"
            alt="Acessórios"
            class="w-32 h-32 object-contain mb-2"
          />
          <p class="font-semibold text-base xl:text-xl text-center">Acessórios</p>
        </div>

        <!-- Card: Equipamentos -->
        <div
        :class="[
      'shadow-md rounded-lg bg-white text-black p-4',
      'w-[272px] flex flex-col items-center',
      'cursor-pointer relative transition-transform duration-300',
      'hover:card-3d-transform',
            activeMaterial === 'equipamentos' ? 'border-4 border-[#BF0404]' : ''
          ]"
          @click="activeMaterial = 'equipamentos'"
        >
          <img
            :src="Material5"
            alt="Equipamentos"
            class="w-32 h-32 object-contain mb-2"
          />
          <p class="font-semibold text-base xl:text-xl text-center">
            Equipamentos
          </p>
        </div>

        <!-- Card: Portaros -->
        <div
        :class="[
      'shadow-md rounded-lg bg-white text-black p-4',
      'w-[272px] flex flex-col items-center',
      'cursor-pointer relative transition-transform duration-300',
      'hover:card-3d-transform',
            activeMaterial === 'portaros' ? 'border-4 border-[#BF0404]' : ''
          ]"
          @click="activeMaterial = 'portaros'"
        >
          <img
            :src="Material6"
            alt="Portaros"
            class="w-32 h-32 object-contain mb-2"
          />
          <p class="font-semibold text-base xl:text-xl text-center">Portaros</p>
        </div>
      </div>
      <!-- FIM COLUNA ESQUERDA (EM CIMA) -->

      <!-- COLUNA DIREITA (EMBAIXO) -->
      <div
        class="relative w-full flex-grow rounded-xl p-6 shadow-2xl
               bg-gradient-to-bl from-white via-gray-100 to-white
               backdrop-blur-md border-l-4 border-[#BF0404]
               transition-all duration-300"
      >
        <!-- Transição do Conteúdo -->
        <transition name="zoom-fade" mode="out-in">
          <!-- Conteúdo: Madeiras -->
          <div
            v-if="activeMaterial === 'madeiras'"
            key="madeiras"
            class="p-5 mt-2 mb-2 rounded-lg shadow-md bg-white/80 animate-contentFadeIn"
          >
            <h2 class="text-xl font-bold mb-2 text-primary-default tracking-wide">
              Informações sobre Madeiras
            </h2>
            <p class="mb-4 text-gray-700 leading-relaxed">
              Apresentamos um vasto catálogo de materiais, de cores e decors
              madeira para cozinhas atuais e modernas.
            </p>
            <img
              src="https://via.placeholder.com/350x150?text=Imagem+Madeiras"
              alt="Exemplo de Madeiras"
              class="mb-2 rounded-md shadow object-cover"
            />
          </div>
        </transition>

        <transition name="zoom-fade" mode="out-in">
          <!-- Conteúdo: Ferragens -->
          <div
            v-if="activeMaterial === 'ferragens'"
            key="ferragens"
            class="p-5 mt-2 mb-2 rounded-lg shadow-md bg-white/80 animate-contentFadeIn"
          >
            <h2 class="text-xl font-bold mb-2 text-primary-default tracking-wide">
              Informações sobre Ferragens
            </h2>
            <p class="mb-4 text-gray-700 leading-relaxed">
              A escolha das ferragens é muito importante para...
            </p>
          </div>
        </transition>

        <transition name="zoom-fade" mode="out-in">
          <!-- Conteúdo: Acessórios -->
          <div
            v-if="activeMaterial === 'acessorios'"
            key="acessorios"
            class="p-5 mt-2 mb-2 rounded-lg shadow-md bg-white/80 animate-contentFadeIn"
          >
            <h2 class="text-xl font-bold mb-2 text-primary-default tracking-wide">
              Informações sobre Acessórios
            </h2>
            <p class="mb-4 text-gray-700 leading-relaxed">
              Completamos com acessórios multifuncionais...
            </p>
          </div>
        </transition>

        <transition name="zoom-fade" mode="out-in">
          <!-- Conteúdo: Equipamentos -->
          <div
            v-if="activeMaterial === 'equipamentos'"
            key="equipamentos"
            class="p-5 mt-2 mb-2 rounded-lg shadow-md bg-white/80 animate-contentFadeIn"
          >
            <h2 class="text-xl font-bold mb-2 text-primary-default tracking-wide">
              Informações sobre Equipamentos
            </h2>
            <p class="mb-4 text-gray-700 leading-relaxed">
              Podemos fornecer lava-loiça, exaustor, entre outros...
            </p>
            <img
              src="https://via.placeholder.com/350x150?text=Imagem+Equipamentos"
              alt="Exemplo de Equipamentos"
              class="mb-2 rounded-md shadow object-cover"
            />
          </div>
        </transition>

        <transition name="zoom-fade" mode="out-in">
          <!-- Conteúdo: Portaros -->
          <div
            v-if="activeMaterial === 'portaros'"
            key="portaros"
            class="p-5 mt-2 mb-2 rounded-lg shadow-md bg-white/80 animate-contentFadeIn"
          >
            <h2 class="text-xl font-bold mb-2 text-primary-default tracking-wide">
              Informações sobre Portaros
            </h2>
            <p class="mb-4 text-gray-700 leading-relaxed">
              Portas interiores de qualidade, com diversos tipos de acabamento...
            </p>
            <img
              src="https://via.placeholder.com/350x150?text=Imagem+Portaros"
              alt="Exemplo de Portaros"
              class="mb-2 rounded-md shadow object-cover"
            />
          </div>
        </transition>
      </div>
    </div>
  </section>
</template>

<script>
import Material2 from "@/assets/images/materials/material2.svg";
import Material3 from "@/assets/images/materials/material3.svg";
import Material4 from "@/assets/images/materials/material4.svg";
import Material5 from "@/assets/images/materials/material5.svg";
import Material6 from "@/assets/images/materials/material6.svg";
import kitchen from "@/assets/images/footer/kitchnet.svg";

export default {
  name: "Materials",
  data() {
    return {
      // Exibe "madeiras" por padrão ao carregar a página
      activeMaterial: "madeiras",
      Material2,
      Material3,
      Material4,
      Material5,
      Material6,
      kitchen,
    };
  },
};
</script>

<style scoped>
/* ------------------------------------------
   TRANSIÇÃO DO CONTEÚDO (zoom-fade)
   Aqui, usamos classes personalizadas
------------------------------------------ */
.zoom-fade-enter-active,
.zoom-fade-leave-active {
  transition: all 0.3s ease-in-out;
}
.zoom-fade-enter {
  opacity: 0;
  transform: scale(0.9);
}
.zoom-fade-leave-to {
  opacity: 0;
  transform: scale(1.05);
}

/* ------------------------------------------
   CLASSE CUSTOM PARA O HOVER 3D
   (Tailwind não tem rotateX / rotateY prontos)
------------------------------------------ */
.hover\:card-3d-transform:hover {
  transform: perspective(600px) rotateX(6deg) rotateY(-6deg) scale(1.03);
  box-shadow: 0 15px 25px -5px rgba(0, 0, 0, 0.3);
}

/* ------------------------------------------
   ANIMAÇÃO DE FADE-IN (contentFadeIn)
------------------------------------------ */
@keyframes contentFadeIn {
  0% {
    opacity: 0;
    transform: translateY(15px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-contentFadeIn {
  animation: contentFadeIn 0.4s ease forwards;
}
</style>
