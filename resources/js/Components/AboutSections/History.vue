<template>
    <section>
        <div class="container mx-auto w-full grid grid-col justify-center items-center my-24">
            <div class="flex flex-col md:flex-row justify-center items-start mx-10">
                <div class="flex-1">
                    <h1 class="text-3xl md:text-5xl text-primary-default mt-10 mb-5">
                        A nossa
                        <span class="text-secondary-default">História</span>
                    </h1>
                    <p class="text-base text-justify mb-10 max-w-[900px]">
                        Somos uma empresa familiar, iniciámos a nossa atividade
                        em 2010. A paixão pela área, o profissionalismo e o
                        rigor do nosso gerente, tornou-nos numa referência de
                        qualidade no setor. <br />Com a evolução e prestígio no
                        mercado fundámos em 2021 a Cozinhas Tecozi, Móveis e
                        Roupeiros LDA., especializada na área das Cozinhas e
                        Roupeiros, focada na satisfação dos nossos clientes.
                    </p>
                </div>
                <div class="absolute top-28 right-2">
                    <img :src="KitchenWallpaper" alt="kitchen" class="w-full h-auto object-cover" />
                </div>
            </div>
            <div class="flex flex-col items-start mx-10">
                <div class="mb-5">
                    <h1 class="text-3xl md:text-5xl text-secondary-default mb-5">
                        Equipa
                    </h1>
                    <p class="text-base">
                        Profissionais atentos desde o início ao fim de cada
                        projeto
                    </p>
                </div>
                <div class="flex flex-col gap-8 lg:flex-row">
                    <div class="flex flex-wrap justify-center mt-5">
                        <div class="card card-compact bg-base-200 w-80 shadow-xl flex flex-row">
                            <div class="card-body w-1/2">
                                <h2 class="text-base text-center bg-primary-default rounded-full text-white px-2">
                                    Dinis Barros
                                </h2>
                                <p class="font-bold text-center">Gerente</p>
                                <p class="text-center">
                                    Responsável pela produção
                                </p>
                            </div>
                            <figure class="w-1/2">
                                <img :src="Dinis" alt="Dinis" class="w-38 p-2 h-full object-cover" />
                            </figure>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center mt-5">
                        <div class="card card-compact bg-base-200 w-80 shadow-xl flex flex-row">
                            <div class="card-body w-1/2">
                                <h2 class="text-base text-center bg-primary-default rounded-full text-white px-2">
                                    Paula Nunes
                                </h2>
                                <p class="font-bold text-center">Gerente</p>
                                <p class="text-center">
                                    Responsável Financeira, Orçamentação
                                </p>
                            </div>
                            <figure class="w-1/2">
                                <img :src="Paula" alt="Paula" class="w-38 p-2 h-full object-cover" />
                            </figure>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center mt-5">
                        <div class="card card-compact bg-base-200 w-80 shadow-xl flex flex-row">
                            <div class="card-body w-1/2 mt-10">
                                <h2 class="text-base text-center bg-primary-default rounded-full text-white px-2">
                                    Joana Barros
                                </h2>
                                <p class="text-center">Administrativa</p>
                            </div>
                            <figure class="w-1/2">
                                <img :src="Joana" alt="Joana" class="w-38 p-2 h-full object-cover" />
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-center mt-10">
                    <!-- Cartão de Missão -->
                    <div class="flex flex-wrap justify-center mt-5">
                        <div class="card card-compact bg-primary-default w-full md:w-[730px] h-auto shadow-xl flex flex-row transition-all duration-300 transform"
                            :class="{ 'md:w-[1200px]': activeCard === 'missao' }" @click="toggleCards('missao')">
                            <div class="container mx-auto flex flex-col md:flex-row items-start gap-6 px-4 py-4">
                                <!-- Ícone e Título -->
                                <div class="flex flex-col items-center w-full md:w-1/4">
                                    <img :src="Goal_White" alt="Missao" class="w-16 mb-2" />
                                    <h2 class="text-lg text-center text-white font-bold">Missão</h2>
                                </div>
                                <!-- Parágrafo -->
                                <div class="text-base text-white text-left pt-5 w-full md:w-2/3 lg:w-3/4 xl:w-[80%]">
                                    <p v-if="activeCard === 'missao'">
                                        Estamos comprometidos em oferecer soluções personalizadas e de alta qualidade
                                        que atendam às
                                        necessidades dos nossos clientes, sempre com foco na excelência e na satisfação
                                        total.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cartão de Visão -->
                    <div class="flex flex-wrap justify-center mt-5">
                        <div class="card card-compact bg-base-200 w-full md:w-[290px] h-auto shadow-xl flex flex-row transition-all duration-300 transform"
                            :class="{ 'md:w-[300px]': activeCard !== 'visao' }" @click="toggleCards('visao')">
                            <div class="container mx-auto flex flex-col justify-center items-center my-5">
                                <img :src="Eye" alt="Visão" class="w-14 mb-5" />
                                <h2 class="text-base text-center text-primary-default font-bold px-2">
                                    Visão
                                </h2>
                                <p class="text-center text-base pt-3" v-if="activeCard === 'visao'">
                                    A nossa visão é ser a referência em soluções
                                    personalizadas, reconhecida pela qualidade e
                                    inovação que oferecemos aos nossos clientes.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center mt-20">
                    <div class="mb-5">
                        <h1 class="text-3xl md:text-5xl text-primary-default mb-5">
                            Os nossos
                            <span class="text-3xl md:text-5xl text-secondary-default">Valores</span>
                        </h1>
                        <p class="text-base">
                            No cumprimento da sua missão, a Tecozi e os seus
                            profissionais perfilham os seguintes valores e
                            princípios:
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-5">
                    <!-- Card 1: Missão -->
                    <div class="card card-compact bg-base-200 shadow-xl p-5 text-left">
                        <div class="items-start">
                            <img :src="Client" alt="Missão" class="w-14 h-14 mb-4" />
                            <h2 class="text-base font-bold text-primary-default mb-2">
                                Missão
                            </h2>
                            <p class="text-base">
                                <strong>(A) Satisfação do Cliente -</strong>
                                Estamos focados nas necessidades e expectativas
                                dos nossos clientes, proporcionando soluções e
                                projetos personalizados.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Visão -->
                    <div class="card card-compact bg-base-200 shadow-xl p-5 text-left">
                        <div class="items-start">
                            <img :src="HandShake" alt="Visão" class="w-14 h-14 mb-4" />
                            <h2 class="text-base font-bold text-primary-default mb-2">
                                Visão
                            </h2>
                            <p class="text-base">
                                <strong>(B) Confiança -</strong> Valorizamos uma
                                relação de confiança com clientes e parceiros.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Qualidade -->
                    <div class="card card-compact bg-base-200 shadow-xl p-5 text-left">
                        <div class="items-start">
                            <img :src="Guarantee" alt="Qualidade" class="w-14 h-14 mb-4" />
                            <h2 class="text-base font-bold text-primary-default mb-2">
                                Qualidade
                            </h2>
                            <p class="text-base">
                                <strong>(C) Qualidade e Inovação -</strong>
                                Comprometemo-nos com as mais altas normas de
                                qualidade e inovação em todos os projetos.
                            </p>
                        </div>
                    </div>

                    <!-- Card 4: Responsabilidade -->
                    <div class="card card-compact bg-base-200 shadow-xl p-5 text-left">
                        <div class="items-start">
                            <img :src="Responsibility" alt="Responsabilidade" class="w-14 h-14 mb-4" />
                            <h2 class="text-base font-bold text-primary-default mb-2">
                                Responsabilidade
                            </h2>
                            <p class="text-base">
                                <strong>(D) Responsabilidade Ambiental -</strong>
                                Adotamos práticas responsáveis e sustentáveis
                                em todos os aspectos do nosso negócio.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Dinis from "@/assets/images/about/dinis.svg";
import Joana from "@/assets/images/about/joana.svg";
import Paula from "@/assets/images/about/distressed-wall-wallpaper-l.jpg";
import Eye from "@/assets/images/about/Eye.svg";
import Goal_White from "@/assets/images/about/goal_white.svg";
import Client from "@/assets/images/about/Client_Management.svg";
import HandShake from "@/assets/images/about/Handshake.svg";
import Guarantee from "@/assets/images/about/Guarantee.svg";
import Business from "@/assets/images/about/Business.svg";
import KitchenWallpaper from "@/assets/images/about/kitchen_wallpaper.svg";

export default {
    data() {
        return {
            activeCard: 'missao',
            Dinis,
            Joana,
            Paula,
            Eye,
            Goal_White,
            Client,
            HandShake,
            Guarantee,
            Business,
            KitchenWallpaper,
        };
    },
    methods: {
    toggleCards(card) {
      this.activeCard = this.activeCard === card ? null : card;
    },
  },
};
</script>

<style scoped>
.card {
    transition: width 0.3s, transform 0.3s;
}
</style>
