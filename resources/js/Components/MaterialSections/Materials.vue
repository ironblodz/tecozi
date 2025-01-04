<template>
    <section class="container mx-auto">
        <img :src="kitchen" class="absolute top-0 right-0 w-48 xl:w-60 xl:-mt-10 opacity-80 z-0 scale-x-[-1]" alt="Fundo Superior Direito" />

        <!-- Imagem de fundo meio esquerda -->
        <img :src="kitchen" class="absolute top-1/2 left-0 w-48 xl:w-60 xl:mt-16 opacity-80 transform -translate-y-1/2 z-0"
            alt="Fundo Meio Esquerda" />


        <!-- Imagem de fundo inferior direita -->
        <img :src="kitchen" class="absolute bottom-0 right-0 w-48 opacity-80 z-0 xl:w-60 scale-x-[-1]" alt="Fundo Inferior Direito" />

        <div class="flex flex-col justify-center items-center mx-auto mt-36">
            <div class="flex flex-col mx-5 justify-center items-center xl:items-start">
                <h1 class="text-primary-default text-2xl xl:text-3xl text-center xl:text-left mb-5">
                    Trabalhamos com as <span class="text-secondary-default text-2xl xl:text-3xl">melhores marcas</span>
                    do mundo
                </h1>
                <p class="text-base xl:text-lg text-center xl:text-left mb-10">
                    Trabalho de qualidade acompanhado dos melhores materiais em cada
                    projeto realizado! Os materiais que garantem o melhor resultado
                </p>
            </div>

            <!-- Hero 1 - Imagem à esquerda, texto à direita -->
            <div class="hero flex justify-center items-center">
                <div class="hero-content flex-col lg:flex-row">
                    <!-- Imagem à esquerda -->
                    <div class="image-container relative">
                        <!-- Forma sólida para a sombra -->
                        <div class="shadow-div -top-6 -left-6 absolute rounded-xl bg-primary-default"></div>
                        <!-- Imagem original -->
                        <img :src="Material2" class="original-image relative max-w-xs rounded-xl"
                            alt="Descrição da imagem" />
                    </div>


                    <!-- Texto à direita -->
                    <div class="flex flex-col items-center xl:items-start mx-12">
                        <h2
                            class="text-xl xl:text-2xl bg-primary-default text-white rounded-full text-center w-40 xl:w-56 mt-5">
                            Madeiras</h2>
                        <p class="py-4 text-base xl:text-lg text-center xl:text-left xl:max-w-lg">
                            Apresentamos um vasto catálogo de materiais, de cores e decors madeira para cozinhas atuais
                            e modernas
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hero 2 -->
            <div class="hero flex justify-center items-center">
                <div class="hero-content flex-col lg:flex-row-reverse">
                    <!-- Imagem à esquerda -->
                    <div class="image-container relative">
                        <!-- Forma sólida para a sombra -->
                        <div class="shadow-div top-6 left-6 absolute rounded-xl bg-secondary-default"></div>
                        <!-- Imagem original -->
                        <img :src="Material3" class="original-image relative max-w-xs rounded-xl"
                            alt="Descrição da imagem" />
                    </div>

                    <!-- Texto à direita -->
                    <div class="flex flex-col text-center items-center xl:items-start mx-12">
                        <h2
                            class="text-xl xl:text-2xl bg-primary-default text-white rounded-full text-center w-40 xl:w-56 mt-5">
                            Ferragens
                        </h2>
                        <p class="py-4 text-base xl:text-lg xl:text-left xl:max-w-md">
                            As escolhas das ferragens são muito importantes para uma boa funcionalidade, durabilidade e
                            conforto.
                            Nas cozinhas, privilegiamos os sistemas de amortecedor integrados nas gavetas e dobradiças
                            para um fecho silencioso.
                            Nos roupeiros, há a possibilidade de colocar amortecedores nas portas de abrir e correr. Nas
                            gavetas, corrediças ocultas com amortecedores.
                            E muito mais para ver...
                        </p>
                    </div>
                </div>
            </div>


            <!-- Hero 3 -->
            <div class="hero flex justify-center items-center">
                <div class="hero-content flex-col lg:flex-row">
                    <!-- Imagem à esquerda -->
                    <div class="image-container relative">
                        <!-- Forma sólida para a sombra -->
                        <div class="shadow-div -top-6 -left-6 absolute rounded-xl bg-primary-default"></div>
                        <!-- Imagem original -->
                        <img :src="Material2" class="original-image relative max-w-xs rounded-xl"
                            alt="Descrição da imagem" />
                    </div>
                    <!-- Texto à direita -->
                    <div class="flex flex-col text-center items-center xl:items-start mx-12">
                        <h2
                            class="text-xl xl:text-2xl  bg-primary-default text-white rounded-full text-center w-40 xl:w-56 mt-5">
                            Acessórios</h2>
                        <p class="py-4 text-base xl:text-lg  xl:text-left xl:max-w-lg">
                            Completamos com acessórios multifuncionais, para equipamento interior dos móveis das
                            cozinhas e dos roupeiros.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hero 4 -->
            <div class="hero flex justify-center items-center ">
                <div class="hero-content flex-col lg:flex-row-reverse">
                    <!-- Imagem à esquerda -->
                    <div class="image-container relative">
                        <!-- Forma sólida para a sombra -->
                        <div class="shadow-div top-6 left-6 absolute rounded-xl bg-secondary-default"></div>
                        <!-- Imagem original -->
                        <img :src="Material3" class="original-image relative max-w-xs rounded-xl"
                            alt="Descrição da imagem" />
                    </div>

                    <!-- Texto à direita -->
                    <div class="flex flex-col text-center items-center xl:items-start mx-12">
                        <h2
                            class="text-xl xl:text-2xl  bg-primary-default text-white rounded-full text-center w-48 xl:w-56 mt-5">
                            Equipamento</h2>
                        <p class="py-4 text-base xl:text-lg xl:text-left xl:max-w-lg">
                            Podemos fornecer lava-loiça, exaustor, entre outros. Também efetuamos o serviço de
                            assentamento dos eletrodomésticos quando fornecidos por nós.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hero 5 -->
            <div class="hero flex justify-center items-center">
                <div class="hero-content flex-col lg:flex-row">
                    <!-- Imagem à esquerda -->
                    <div class="image-container relative">
                        <!-- Forma sólida para a sombra -->
                        <div class="shadow-div -top-6 -left-6 absolute rounded-xl bg-primary-default"></div>
                        <!-- Imagem original -->
                        <img :src="Material2" class="original-image relative max-w-xs rounded-lg"
                            alt="Descrição da imagem" />
                    </div>
                    <!-- Texto à direita -->
                    <div class="flex flex-col text-center items-center xl:items-start mx-12">
                        <h2
                            class="text-xl xl:text-2xl  bg-primary-default text-white rounded-full text-center w-40 mt-5">
                            Portaros</h2>
                        <p class="py-4 text-base xl:text-lg xl:text-left xl:max-w-md">
                            Portas interiores de qualidade, com diversos tipos de acabamento: Lacados, CPL, HPL,
                            Folheado a madeiras diversas: wengé, carvalho, teka...
                            Portas com kits completos compostos por aro, porta, guarnição, dobradiças e puxador de
                            qualidade.
                        </p>
                    </div>
                </div>
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
            Material2,
            Material3,
            Material4,
            Material5,
            Material6,
            kitchen
        };
    },
};
</script>

<style scoped>
.container {
    position: relative;
}

.image-container {
    position: relative;
    display: inline-block;
}

.shadow-div {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 0;
}

.original-image {
    position: relative;
    z-index: 1;
    border-radius: inherit;
}

img {
    pointer-events: none;
    /* Impede interação com as imagens de fundo */
}
</style>
