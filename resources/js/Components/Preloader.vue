<template>
    <div v-if="isVisible" class="preloader">
      <!-- Fundo animado -->
      <div class="background-animation"></div>

      <!-- Conteúdo principal -->
      <div class="relative flex flex-col items-center space-y-6">
        <!-- Logotipo -->
        <div class="logo-container" :class="{ 'fade-in': !isExiting, 'fade-out': isExiting }">
          <img :src="logo" alt="Logotipo Tecozi" class="w-full h-full object-contain ml-[3.8rem] xl:ml-[5rem]" />
        </div>

        <!-- Botão de Slider -->
        <div class="relative w-full max-w-lg mt-8">
          <!-- Botão Fixado -->
          <div class="button-container">
            <span v-if="!isCompleted">Arraste para Entrar</span>
            <span v-if="isCompleted">Entrando...</span>

            <!-- Slider que se move automaticamente -->
            <div
              class="slider"
              :style="{ width: `${sliderWidth}%` }"
            ></div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import logo from '@/assets/images/logo/logotipo.svg';

  export default {
    name: "Preloader",
    data() {
      return {
        logo,
        isVisible: true,
        isExiting: false,
        isCompleted: false,
        sliderWidth: 0, // Largura do slider
        maxSliderWidth: 100, // Largura máxima (100%)
        sliderSpeed: 0.5, // Velocidade do slider
      };
    },
    mounted() {
      this.startSlider(); // Inicia o movimento do slider automaticamente
    },
    methods: {
      startSlider() {
        // O slider se move automaticamente
        const interval = setInterval(() => {
          if (this.sliderWidth < this.maxSliderWidth) {
            this.sliderWidth += this.sliderSpeed; // Aumenta a largura do slider
          } else {
            clearInterval(interval); // Para quando o slider atingir 100%
            this.completeSlider();
          }
        }, 30); // A cada 30ms o slider se move um pouco
      },
      completeSlider() {
        this.isCompleted = true; // Marca o fim do movimento
        setTimeout(() => {
          this.triggerExitAnimation(); // Chama a animação de saída
        }, 500);
      },
      triggerExitAnimation() {
        this.isExiting = true;
        const preloader = document.querySelector(".preloader");
        preloader.classList.add("exit-animation");

        setTimeout(() => {
          this.isVisible = false;
          this.$emit("animation-complete");
        }, 1200); // Duração da animação de saída
      },
    },
  };
  </script>

  <style scoped>
  /* Fundo do Preloader */
  .preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #3d4877, #1f2b50);
    animation: fadeIn 1s ease-in-out;
  }

  /* Fundo Animado */
  .background-animation {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(61, 72, 119, 0.7) 0%, rgba(31, 43, 80, 0.8) 50%, #1f2b50 100%);
    animation: pulseBackground 3s infinite alternate;
    z-index: -1;
  }

  @keyframes pulseBackground {
    from {
      transform: scale(1);
      opacity: 0.8;
    }
    to {
      transform: scale(1.1);
      opacity: 1;
    }
  }

  /* Logotipo */
  .logo-container {
    animation: fadeInLogo 1s ease-in-out;
  }

  @keyframes fadeInLogo {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .fade-in {
    opacity: 1;
    transform: translateY(0);
    transition: opacity 1s, transform 1s;
  }

  .fade-out {
    opacity: 0;
    transform: translateY(-20px);
    transition: opacity 1s, transform 1s;
  }

  /* Estilo do botão */
  .button-container {
    width: 100%;
    max-width: 500px;
    height: 50px;
    background-color: #eee;
    border-radius: 25px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
  }

  .button-container span {
    position: absolute;
    font-size: 18px;
    font-weight: bold;
    color: #333;
    text-align: center;
  }

  .button-container span:first-child {
    opacity: 1;
  }

  .button-container span:last-child {
    opacity: 0;
    transition: opacity 0.5s ease;
  }

  /* Slider que se move dentro do botão */
  .slider {
    height: 100%;
    background-color: #bf0404;
    transition: width 0.3s ease;
    position: absolute;
    left: 0;
    top: 0;
    border-radius: 25px;
  }

  /* Animação de saída */
  .exit-animation {
    animation: fadeOut 1.2s ease-in-out;
  }

  @keyframes fadeOut {
    from {
      opacity: 1;
    }
    to {
      opacity: 0;
    }
  }
  </style>
