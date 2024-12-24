<template>
    <div class="carousel w-full relative">
        <!-- Slide 1 -->
        <div id="slide1" class="carousel-item relative w-full">
            <img :src="carousel" class="w-full object-cover h-96 md:h-[36rem]" />
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white gap-6 px-4 text-center">
                <h1 class="text-xl md:text-5xl font-bold mt-12">
                    {{ $t('carrousel.carrousel') }}
                </h1>
                <p class="text-sm md:text-lg px-3">
                    {{ $t('carrousel.carrouselp') }}
                </p>
                <button class="rounded-full bg-primary-default text-white py-2 px-8 text-sm md:text-base">
                    {{ $t('carrousel.readmore') }}
                </button>
            </div>
            <div class="absolute left-4 right-4 top-[72%] xl:top-[50%] flex -translate-y-1/2 transform justify-between">
                <a href="#slide4">
                    <img :src="arrowleft" alt="arrowleft" class="w-10 md:w-12" />
                </a>
                <a href="#slide2">
                    <img :src="arrowright" alt="arrowright" class="w-10 md:w-12" />
                </a>
            </div>
        </div>

        <!-- Slide 2 -->
        <div id="slide2" class="carousel-item relative w-full">
            <img :src="carousel2" class="w-full object-cover h-96 md:h-[36rem]" />
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white gap-6 px-4 text-center">
                <h1 class="text-xl md:text-5xl font-bold mt-12">
                    {{ $t('carrousel.carrousel2') }}
                </h1>
                <p class="text-sm md:text-lg px-3">
                    {{ $t('carrousel.carrousel2p') }}
                </p>
                <button class="rounded-full bg-primary-default text-white py-2 px-8 text-sm md:text-base">
                    {{ $t('carrousel.readmore') }}
                </button>
            </div>
            <div class="absolute left-4 right-4 top-[72%] xl:top-[50%] flex -translate-y-1/2 transform justify-between">
                <a href="#slide1">
                    <img :src="arrowleft" alt="arrowleft" class="w-10 md:w-12" />
                </a>
                <a href="#slide3">
                    <img :src="arrowright" alt="arrowright" class="w-10 md:w-12" />
                </a>
            </div>
        </div>

        <!-- Slide 3 -->
        <div id="slide3" class="carousel-item relative w-full">
            <img :src="carousel3" class="w-full object-cover h-96 md:h-[36rem]" />
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white gap-6 px-4 text-center">
                <h1 class="text-xl md:text-5xl font-bold mt-12">
                    {{ $t('carrousel.carrousel3') }}
                </h1>
                <p class="text-sm md:text-lg px-3">
                    {{ $t('carrousel.carrousel3p') }}
                </p>
                <button class="rounded-full bg-primary-default text-white py-2 px-8 text-sm md:text-base">
                    {{ $t('carrousel.readmore') }}
                </button>
            </div>
            <div class="absolute left-4 right-4 top-[72%] xl:top-[50%] flex -translate-y-1/2 transform justify-between">
                <a href="#slide2">
                    <img :src="arrowleft" alt="arrowleft" class="w-10 md:w-12" />
                </a>
                <a href="#slide4">
                    <img :src="arrowright" alt="arrowright" class="w-10 md:w-12" />
                </a>
            </div>
        </div>

        <!-- Slide 4 -->
        <div id="slide4" class="carousel-item relative w-full">
            <img :src="carousel4" class="w-full object-cover h-96 md:h-[36rem]" />
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white gap-6 px-4 text-center">
                <h1 class="text-xl md:text-5xl font-bold mt-12">
                    {{ $t('carrousel.carrousel4') }}
                </h1>
                <p class="text-sm md:text-lg px-3">
                    {{ $t('carrousel.carrousel4p') }}
                </p>
                <button class="rounded-full bg-primary-default text-white py-2 px-8 text-sm md:text-base">
                    {{ $t('carrousel.readmore') }}
                </button>
            </div>
            <div class="absolute left-4 right-4 top-[72%] xl:top-[50%] flex -translate-y-1/2 transform justify-between">
                <a href="#slide3">
                    <img :src="arrowleft" alt="arrowleft" class="w-10 md:w-12" />
                </a>
                <a href="#slide1">
                    <img :src="arrowright" alt="arrowright" class="w-10 md:w-12" />
                </a>
            </div>
        </div>
    </div>
</template>


<script>
import carousel from "@/assets/images/carousel/carousel1.svg";
import carousel2 from "@/assets/images/carousel/carousel2.svg";
import carousel3 from "@/assets/images/carousel/carousel3.svg";
import carousel4 from "@/assets/images/carousel/carousel4.svg";
import arrowright from "@/assets/images/carousel/arrowright.svg";
import arrowleft from "@/assets/images/carousel/arrowleft.svg";

export default {
    name: "Carousel",
    data() {
        return {
            carousel,
            carousel2,
            carousel3,
            carousel4,
            arrowright,
            arrowleft,
        };
    },
};
</script>
