<template>
    <section class="container mx-auto">
        <div class="w-full grid grid-col justify-center items-center my-24">
            <div class="flex flex-col md:flex-row justify-center items-start mx-10">
                <div class="flex-1 text-center xl:text-left">
                    <h1 class="text-2xl xl:text-3xl text-primary-default mt-10 mb-5">
                        A nossa
                        <span class="text-secondary-default text-2xl xl:text-3xl">História</span>
                    </h1>
                    <p class="text-base xl:text-lg mb-10 max-w-[900px] text-center xl:text-left">
                        Somos uma empresa familiar, iniciámos a nossa atividade
                        em 2010. A paixão pela área, o profissionalismo e o
                        rigor do nosso gerente, tornou-nos numa referência de
                        qualidade no setor. <br />Com a evolução e prestígio no
                        mercado fundámos em 2021 a Cozinhas Tecozi, Móveis e
                        Roupeiros LDA., especializada na área das Cozinhas e
                        Roupeiros, focada na satisfação dos nossos clientes.
                    </p>
                </div>
                <div class="absolute xl:top-28 xl:right-2 right-4 hidden xl:block">
                    <img :src="KitchenWallpaper" alt="kitchen" class="w-[600px] h-auto object-cover" />
                </div>
            </div>
            <div class="flex flex-col items-start mx-10">
                <div class="mb-5">
                    <h1 class="text-2xl xl:text-3xl text-secondary-default mb-5 text-center xl:text-left">
                        Equipa
                    </h1>
                    <p class="text-base xl:text-lg text-center xl:text-left">
                        Profissionais atentos desde o início ao fim de cada
                        projeto
                    </p>
                </div>
                <div class="flex flex-col gap-4 lg:flex-row">
                    <div class="flex flex-wrap justify-center mt-5">
                        <div class="card card-compact bg-base-200 w-[22rem] shadow-xl flex flex-row">
                            <div class="card-body w-[80%]">
                                <h2 class="text-base xl:text-lg text-center bg-primary-default rounded-full text-white px-2">
                                    Dinis Barros
                                </h2>
                                <span class="font-bold text-center text-base xl:text-lg">Gerente</span>
                                <p class="text-center text-base xl:text-lg">
                                    Responsável pela produção
                                </p>
                            </div>
                            <figure class="w-[70%]">
                                <img :src="Dinis" alt="Dinis"
                                    class="w-38 p-2 h-[90%] object-cover border border-primary-default rounded-full" />
                            </figure>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center mt-5">
                        <div class="card card-compact bg-base-200 w-[22rem] shadow-xl flex flex-row">
                            <div class="card-body w-1/2">
                                <h2 class="text-base xl:text-lg text-center bg-primary-default rounded-full text-white px-2">
                                    Paula Nunes
                                </h2>
                                <span class="font-bold text-center text-base xl:text-lg">Gerente</span>
                                <p class="text-center text-base xl:text-lg">
                                    Responsável Financeira, Orçamentação
                                </p>
                            </div>
                            <figure class="w-1/2">
                                <img :src="Paula" alt="Paula"
                                    class="w-38 p-2 h-[85%] object-cover border border-primary-default rounded-full" />
                            </figure>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center mt-5">
                        <div class="card card-compact bg-base-200 w-[22rem] shadow-xl flex flex-row">
                            <div class="card-body w-1/2 mt-10">
                                <h2 class="text-base xl:text-lg text-center bg-primary-default rounded-full text-white px-2">
                                    Joana Barros
                                </h2>
                                <p class="text-center text-base xl:text-lg">Administrativa</p>
                            </div>
                            <figure class="w-1/2">
                                <img :src="Joana" alt="Joana"
                                    class="w-38 p-2 h-[85%] object-cover border border-primary-default rounded-full" />
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-center mt-10">
                    <!-- Cartão de Missão -->
                    <div class="flex flex-wrap justify-center xl:mt-4 xl:pr-4">
                        <div
                            class="card card-compact bg-primary-default w-full xl:w-[750px] h-auto shadow-xl flex flex-row transition-all duration-300 ease-in-out transform">
                            <div
                                class="container mx-auto flex flex-col md:flex-row items-center justify-center gap-6 px-4 py-4">
                                <!-- Ícone e Título -->
                                <div class="flex flex-col items-center justify-center w-1/5">
                                    <img :src="Goal_White" alt="Missao" class="w-16 mb-2" />
                                    <h2 class="text-base xl:text-lg text-white font-bold text-center">Missão</h2>
                                </div>
                                <!-- Parágrafo -->
                                <div
                                    class="text-base xl:text-lg text-white text-center xl:text-left xl:pt-2 w-full xl:w-[80%]">
                                    <p>
                                        Projetar, fabricar e assentar móveis que combinam qualidade, design durabilidade
                                        e funcionalidade para o dia-a-dia.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cartão de Visão -->
                    <div class="flex flex-wrap justify-center mt-5">
                        <div
                            class="card card-compact bg-gray-100 w-full xl:w-[700px] h-auto shadow-xl flex flex-row transition-all duration-300 ease-in-out transform">
                            <div
                                class="container mx-auto flex flex-col md:flex-row items-center justify-center gap-6 px-4 py-4">
                                <!-- Ícone e Título -->
                                <div class="flex flex-col items-center justify-center w-1/5">
                                    <img :src="Eye" alt="Visão" class="w-16 mb-2" />
                                    <h2 class="text-lg text-black font-bold text-center">Visão</h2>
                                </div>
                                <!-- Parágrafo -->
                                <div
                                    class="text-base xl:text-lg  text-black xl:text-left xl:pt-2 w-full xl:w-[80%] text-center">
                                    <p>
                                        Combinar produtos de qualidade e ser a preferência dos nossos clientes.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-center items-center mt-20">
                    <div class="mb-5">
                        <h1 class="text-2xl xl:text-3xl text-primary-default mb-5 text-center xl:text-left">
                            Os nossos
                            <span
                                class="text-2xl xl:text-3xl text-secondary-default text-center xl:text-left">Valores</span>
                        </h1>
                        <p class="text-base xl:text-xl text-center xl:text-left">
                            No cumprimento da sua missão, a Tecozi e os seus
                            profissionais perfilham os seguintes valores e
                            princípios:
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-5">
                    <!-- Card 1: Missão -->
                    <div
                        class="card card-compact w-full h-[220px] xl:w-[350px] xl:h-[240px] bg-base-200 shadow-gray shadow-2xl p-3 text-left">
                        <div class="flex flex-col items-center xl:items-start xl:justify-center">
                            <img :src="Client" alt="Missão" class="w-14 h-14 mb-4" />
                            <p class="text-base xl:text-lg text-center xl:text-left">
                                <strong>(A) Satisfação do Cliente -</strong> <br>
                                Estamos focados nas necessidades e expectativas
                                dos nossos clientes, proporcionando soluções e
                                projetos personalizados.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Visão -->
                    <div
                        class="card card-compact w-full h-[170px] xl:w-[350px] xl:h-[240px] bg-base-200 shadow-gray shadow-2xl p-3 text-left">
                        <div class="flex flex-col items-center xl:items-start xl:justify-center">
                            <img :src="HandShake" alt="Visão" class="w-14 h-14 mb-4" />
                            <p class="text-base xl:text-lg  text-center xl:text-left">
                                <strong>(B) Confiança -</strong> <br> Valorizamos uma
                                relação de confiança com clientes e parceiros.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Qualidade -->
                    <div
                        class="card card-compact w-full h-[190px] xl:w-[350px] xl:h-[240px] bg-base-200 shadow-gray shadow-2xl p-3 text-left">
                        <div class="flex flex-col items-center xl:items-start xl:justify-center">
                            <img :src="Guarantee" alt="Qualidade" class="w-14 h-14 mb-4" />
                            <p class="text-base xl:text-lg  text-center xl:text-left">
                                <strong>(C) Qualidade e Inovação -</strong> <br>
                                Comprometemo-nos com as mais altas normas de
                                qualidade e inovação em todos os projetos.
                            </p>
                        </div>
                    </div>

                    <!-- Card 4: Responsabilidade -->
                    <div
                        class="card card-compact w-full h-[170px] xl:w-[350px] xl:h-[240px] bg-base-200 shadow-gray shadow-2xl p-3 text-left">
                        <div class="flex flex-col items-center xl:items-start xl:justify-center">
                            <img :src="Business" alt="Responsabilidade" class="w-14 h-14 mb-4" />
                            <p class="text-base xl:text-lg  text-center xl:text-left">
                                <strong>(D) Competência -</strong> <br>
                                Profissionalismo e rigor nas diferentes fases do projeto.
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
import KitchenWallpaper from "@/assets/images/about/cozinhas_tecozi_refeito.png";

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
    },
};
</script>

<style scoped>
.card {
    transition: all 0.3s ease-in-out;
    transform-origin: center;
}

.card:hover {
    transform: scale(1.05);
}

.card.scale-105 {
    transform: scale(1.05);
}

.card.shadow-2xl {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}
</style>
