<template>
    <section>
        <div class="container mx-auto mt-10 w-4/5 mb-10">
            <div class="bg-neutral-default rounded-xl p-6 text-left flex flex-col lg:flex-row justify-between items-center">
                <div class="lg:w-2/3">
                    <h1 class="text-secondary-default text-xl xl:text-3xl">{{ $t('contact.title') }}</h1>
                    <p class="text-base xl:text-lg mt-4">{{ $t('contact.description') }}</p>
                    <button class="bg-primary-default p-2 px-4 mt-4 rounded-full text-white text-base xl:text-lg">
                        <a :href="route('contacts')">{{ $t('contact.button') }}</a>
                    </button>
                </div>
                <div class="relative lg:w-1/3 mt-6 lg:mt-0 flex-shrink-0">
                    <img :src="Wallpaper1" class="w-96 h-auto rounded-xl" alt="Imagem Principal" />
                    <img :src="Wallpaper2"
                        class="absolute -bottom-8 -right-4 xl:right-12 w-32 h-auto rounded-xl border-2 border-white"
                        alt="Imagem Sobreposta" />
                </div>
            </div>
        </div>

        <blockquote class="text-center mb-10">
            <p class="font-bold text-base xl:text-lg">{{ $t('quote.text') }}</p>
            <cite>{{ $t('quote.author') }}</cite>
        </blockquote>
    </section>
</template>

<script>
import Wallpaper1 from '@/assets/images/home/wallpapercontact1.svg';
import Wallpaper2 from '@/assets/images/home/wallpapercontact2.svg';

export default {
    name: "ContactSection",
    data() {
        return {
            Wallpaper1,
            Wallpaper2
        }
    }
}
</script>
