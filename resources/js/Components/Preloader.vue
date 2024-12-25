<template>
    <div v-if="isVisible" class="preloader">
        <!-- Fundo animado -->
        <div class="background-animation"></div>

        <!-- Conteúdo principal -->
        <div class="relative flex flex-col items-center space-y-6">
            <!-- Logotipo -->
            <div class="logo-container blinking-logo" :class="{ 'fade-in': !isExiting, 'fade-out': isExiting }">
                <img :src="logo" alt="Logotipo Tecozi" class="w-full h-full object-contain ml-[3.8rem] :ml-[4.8rem]" />
            </div>

            <!-- Campo de Entrada com Ícone -->
            <div
                class="relative bg-gray-100 dark:bg-primary-default px-6 py-3 rounded-full shadow-xl flex items-center w-80 border-2 border-secondary-default glowing-border">
                <!-- Ícone de Pesquisa -->
                <svg class="h-6 w-6 text-secondary-default absolute left-4" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 11a4 4 0 118 0 4 4 0 01-8 0zM2 20l4.35-4.35" />
                </svg>

                <!-- Texto Animado -->
                <div class="pl-12 flex space-x-1">
                    <span v-for="(letter, index) in text" :key="index" :class="[
                        'text-primary-default text-xl font-semibold transition-all transform duration-300',
                        {
                            'opacity-100 translate-y-0 scale-100 typing-effect': index < currentIndex,
                            'opacity-0 translate-y-2 scale-90': index >= currentIndex,
                        },
                    ]">
                        {{ letter }}
                    </span>
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
            text: "www.tecozi.pt",
            currentIndex: 0,
            isVisible: true,
            isExiting: false,
        };
    },
    mounted() {
        this.animateText();
    },
    methods: {
        animateText() {
            const interval = setInterval(() => {
                if (this.currentIndex < this.text.length) {
                    this.currentIndex++;
                } else {
                    clearInterval(interval);
                    setTimeout(() => {
                        this.triggerExitAnimation();
                    }, 800);
                }
            }, 250);
        },
        triggerExitAnimation() {
            this.isExiting = true;
            const preloader = document.querySelector(".preloader");
            preloader.classList.add("exit-animation");

            setTimeout(() => {
                this.isVisible = false;
                this.$emit("animation-complete");
            }, 1200);
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
    overflow: hidden;
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

/* Campo de entrada com borda brilhante */
.glowing-border {
    box-shadow: 0 0 15px 2px #bf0404, inset 0 0 10px 1px #bf0404;
    animation: glow 1.5s infinite alternate;
}

@keyframes glow {
    from {
        box-shadow: 0 0 10px 2px #bf0404, inset 0 0 5px 1px #bf0404;
    }

    to {
        box-shadow: 0 0 20px 4px #bf0404, inset 0 0 15px 2px #bf0404;
    }
}

/* Texto digitado */
.typing-effect {
    animation: type 0.25s steps(1) forwards;
}

@keyframes type {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

/* Saída suave */
.exit-animation {
    animation: fadeOut 1.2s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }

    to {
        opacity: 0;
    }
}

/* Efeito de piscar para o logotipo */
@keyframes blink {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.3;
    }
    100% {
        opacity: 1;
    }
}

/* Aplica o efeito de piscar no logotipo */
.blinking-logo {
    animation: blink 1.2s infinite;
}

</style>
