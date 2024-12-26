<template>
    <section>
        <img :src="kitchenwallpaper" alt="kitchenwallpaper"
            class="absolute top-[575px] right-2 object-cover w-[300px]" />
        <div class="container mx-auto w-full grid grid-col justify-center items-center">
            <div class="flex flex-col z-20">
                <p class="text-base xl:text-lg text-center mt-10">
                    {{ $t("projectdone.paragraph") }}
                </p>
                <h1 class="text-xl xl:text-3xl text-center text-primary-default mt-10">
                    {{ $t("projectdone.title") }}
                    <span class="text-secondary-default text-xl xl:text-3xl">
                        {{ $t("projectdone.titlev2") }}</span>
                </h1>
            </div>
            <div
                class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 justify-items-center gap-12 mt-20">
                <div
                    class="card bg-primary-default rounded-b-none border-b-8 border-secondary-default text-primary-content w-[70%] xl:w-[300px] group hover:border-t-8 hover:border-b-0 transition-all duration-300">
                    <div class="card-body relative">
                        <!-- Imagem que será oculta no hover -->
                        <img :src="user"
                            class="w-20 absolute -top-10 left-1/2 transform -translate-x-1/2 transition-opacity duration-300 opacity-100 group-hover:opacity-0"
                            alt="user" />

                        <!-- Título que será oculto no hover -->
                        <h2
                            class="text-white text-center text-base xl:text-lg mt-7 transition-opacity duration-300 opacity-100 group-hover:opacity-0">
                            {{ $t("projectdone.visite") }}
                        </h2>

                        <!-- Descrição que aparece no hover -->
                        <p
                            class="absolute inset-0 flex items-center justify-center text-white text-sm xl:text-base px-6 text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $t("projectdone.visitep") }}
                        </p>
                    </div>
                </div>

                <div
                    class="card bg-primary-default rounded-b-none border-b-8 border-secondary-default text-primary-content w-[70%] xl:w-[300px] group hover:border-t-8 hover:border-b-0 transition-all duration-300">
                    <div class="card-body relative">
                        <img :src="ruler"
                            class="w-20 absolute -top-10 left-1/2 transform -translate-x-1/2 transition-opacity duration-300 opacity-100 group-hover:opacity-0"
                            alt="ruler" />
                        <h2
                            class="text-white text-center text-base xl:text-lg mt-7 transition-opacity duration-300 opacity-100 group-hover:opacity-0">
                            {{ $t("projectdone.project") }}
                        </h2>
                        <p
                            class="absolute inset-0 flex items-center justify-center text-white text-center text-sm xl:text-base px-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $t("projectdone.projectp") }}
                        </p>
                    </div>
                </div>

                <div
                    class="card bg-primary-default rounded-b-none border-b-8 border-secondary-default text-primary-content w-[70%] xl:w-[300px] group hover:border-t-8 hover:border-b-0 transition-all duration-300">
                    <div class="card-body relative">
                        <img :src="tape"
                            class="w-20 absolute -top-10 left-1/2 transform -translate-x-1/2 transition-opacity duration-300 opacity-100 group-hover:opacity-0"
                            alt="tape" />
                        <h2
                            class="text-white text-center text-base xl:text-lg mt-7 transition-opacity duration-300 opacity-100 group-hover:opacity-0">
                            {{ $t("projectdone.retification") }}
                        </h2>
                        <p
                            class="absolute inset-0 flex items-center justify-center text-white text-center text-sm xl:text-base px-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $t("projectdone.retificationp") }}
                        </p>
                    </div>
                </div>

                <div
                    class="card bg-primary-default rounded-b-none border-b-8 border-secondary-default text-primary-content w-[70%] xl:w-[300px] group hover:border-t-8 hover:border-b-0 transition-all duration-300">
                    <div class="card-body relative">
                        <img :src="drill"
                            class="w-20 absolute -top-10 left-1/2 transform -translate-x-1/2 transition-opacity duration-300 opacity-100 group-hover:opacity-0"
                            alt="drill" />
                        <h2
                            class="text-white text-center text-base xl:text-lg mt-7 transition-opacity duration-300 opacity-100 group-hover:opacity-0">
                            {{ $t("projectdone.execution") }}
                        </h2>
                        <p
                            class="absolute inset-0 flex items-center justify-center text-white text-center text-sm xl:text-base px-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $t("projectdone.executionp") }}
                        </p>
                    </div>
                </div>

                <div
                    class="card bg-primary-default rounded-b-none border-b-8 border-secondary-default text-primary-content w-[70%] xl:w-[300px] group hover:border-t-8 hover:border-b-0 transition-all duration-300">
                    <div class="card-body relative">
                        <img :src="kitchen"
                            class="w-20 absolute -top-10 left-1/2 transform -translate-x-1/2 transition-opacity duration-300 opacity-100 group-hover:opacity-0"
                            alt="kitchen" />
                        <h2
                            class="text-white text-center text-base xl:text-lg mt-7 transition-opacity duration-300 opacity-100 group-hover:opacity-0">
                            {{ $t("projectdone.finishes") }}
                        </h2>
                        <p
                            class="absolute inset-0 flex items-center justify-center text-white text-center text-sm xl:text-base px-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $t("projectdone.finishesp") }}
                        </p>
                    </div>
                </div>

                <div
                    class="card bg-primary-default rounded-b-none border-b-8 border-secondary-default text-primary-content w-[70%] xl:w-[300px] group hover:border-t-8 hover:border-b-0 transition-all duration-300">
                    <div class="card-body relative">
                        <img :src="premier"
                            class="w-20 absolute -top-10 left-1/2 transform -translate-x-1/2 transition-opacity duration-300 opacity-100 group-hover:opacity-0"
                            alt="premier" />
                        <h2
                            class="text-white text-center text-base xl:text-lg mt-7 transition-opacity duration-300 opacity-100 group-hover:opacity-0">
                            {{ $t("projectdone.sells") }}
                        </h2>
                        <p
                            class="absolute inset-0 flex items-center justify-center text-white text-center text-sm xl:text-base px-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $t("projectdone.sellsp") }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import user from "@/assets/images/home/user.svg";
import ruler from "@/assets/images/home/ruler.svg";
import tape from "@/assets/images/home/tape.svg";
import drill from "@/assets/images/home/drill.svg";
import kitchen from "@/assets/images/home/kitchen.svg";
import premier from "@/assets/images/home/premier.svg";
import kitchenwallpaper from "@/assets/images/services/kitechenwallpapergrey.svg";

export default {
    name: "ProjectDone",
    data() {
        return {
            user,
            ruler,
            tape,
            drill,
            kitchen,
            premier,
            kitchenwallpaper,
        };
    },
};
</script>
