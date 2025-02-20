<template>
    <div v-if="isVisible" class="preloader">
      <!-- Fundo animado com partículas -->
      <canvas ref="particlesCanvas" class="background-animation"></canvas>

      <!-- Conteúdo principal -->
      <div class="relative flex flex-col items-center space-y-6 z-10">
        <!-- Logotipo com animação -->
        <div class="logo-container" :class="{ 'fade-in': !isExiting, 'fade-out': isExiting }">
          <img :src="logo" alt="Logotipo" class="w-full mx-24 object-contain animate-bounce" />
        </div>

        <!-- Barra de progresso com brilho -->
        <div class="relative w-full max-w-md mt-8">
          <div class="button-container">
            <span v-if="!isCompleted">Carregando...</span>
            <span v-if="isCompleted">Entrando...</span>
            <div class="slider" :style="{ width: `${sliderWidth}%` }"></div>
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
        sliderWidth: 0,
        maxSliderWidth: 100,
        sliderSpeed: 2,
      };
    },
    mounted() {
      this.startSlider();
      this.initParticles();
    },
    methods: {
      startSlider() {
        const interval = setInterval(() => {
          if (this.sliderWidth < this.maxSliderWidth) {
            this.sliderWidth += this.sliderSpeed;
          } else {
            clearInterval(interval);
            this.completeSlider();
          }
        }, 15);
      },
      completeSlider() {
        this.isCompleted = true;
        setTimeout(() => {
          this.triggerExitAnimation();
        }, 500);
      },
      triggerExitAnimation() {
        this.isExiting = true;
        setTimeout(() => {
          this.isVisible = false;
          this.$emit("animation-complete");
        }, 1200);
      },
      initParticles() {
        const canvas = this.$refs.particlesCanvas;
        const ctx = canvas.getContext("2d");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let particles = [];
        const numParticles = 50;

        class Particle {
          constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 4 + 1;
            this.speedY = Math.random() * 2 + 1;
          }
          update() {
            this.y += this.speedY;
            if (this.y > canvas.height) {
              this.y = 0;
              this.x = Math.random() * canvas.width;
            }
          }
          draw() {
            ctx.fillStyle = "rgba(255, 255, 255, 0.7)";
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
          }
        }

        function createParticles() {
          for (let i = 0; i < numParticles; i++) {
            particles.push(new Particle());
          }
        }

        function animateParticles() {
          ctx.clearRect(0, 0, canvas.width, canvas.height);
          particles.forEach((particle) => {
            particle.update();
            particle.draw();
          });
          requestAnimationFrame(animateParticles);
        }

        createParticles();
        animateParticles();
      }
    },
  };
  </script>

  <style scoped>
  .preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #3D4877;
    z-index: 9999;
    animation: fadeIn 1s ease-in-out;
  }

  .background-animation {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
  }

  .logo-container {
    animation: fadeInLogo 1s ease-in-out;
  }

  @keyframes fadeInLogo {
    from {
      opacity: 0;
      transform: scale(0.8);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  .fade-in {
    opacity: 1;
    transition: opacity 1s, transform 1s;
  }

  .fade-out {
    opacity: 0;
    transform: translateY(-20px);
    transition: opacity 1s, transform 1s;
  }

  .button-container {
    width: 100%;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
  }

  .button-container span {
    position: absolute;
    font-size: 18px;
    font-weight: bold;
    color: #fff;
  }

  .slider {
    height: 100%;
    background: #3D4877;
    transition: width 0.3s ease;
    position: absolute;
    left: 0;
    top: 0;
    border-radius: 25px;
    box-shadow: 0 0 15px rgba(61, 72, 119, 0.5);
  }
  </style>
