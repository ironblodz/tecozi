<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

const { props } = usePage();

const contact = ref({
    name: "",
    img: null // Armazena o arquivo da nova imagem
});

const errors = ref({});
const previewImage = ref(null); // Armazena a URL para a pré-visualização da imagem

// Função para redirecionar ao cancelar
const cancel = () => {
    window.location = `/backoffice/contacts`;
};

// Função para atualizar o contato
const updateContact = async () => {

    const formData = new FormData();
    formData.append('id', contact.value.id);
    formData.append('first_name', contact.value.first_name);
    formData.append('nickname', contact.value.nickname);
    formData.append('email', contact.value.email);
    formData.append('phone', contact.value.phone);
    formData.append('subject', contact.value.subject);
    formData.append('message', contact.value.message);

    try {
        const response = await axios.post(`/backoffice/contacts/update/`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        console.log('Contact updated:', response.data);
        Toastify({text: "Contato atualizado com sucesso!"}).showToast();
    } catch (error) {
        console.error('Error updating contact:', error);
        Toastify({text: "" + error.message}).showToast();
    }
};

// Inicializa os dados do contato ao montar o componente
onMounted(() => {
    contact.value = props.contact;
});

</script>

<template>
    <Head title="Editar Contacto" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <a class="text-gray-800 flex-initial w-8" href="/backoffice/contacts">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 ml-2">Visualizar/Atualizar Contacto</h2>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto p-4 bg-white shadow rounded-lg">
                <div class="bg-blue-600 text-white py-4 px-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-semibold">Informações sobre o contacto:</h2>
                </div>
                <div class="p-6">
                    <form @submit.prevent="updateContact" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Primeiro Nome</label>
                            <input v-model="contact.first_name" id="name" type="text" 
                                class="border border-gray-300 rounded-lg px-4 py-2 w-full">                           
                        </div>
                        <div class="mb-4">
                            <label for="nickname" class="block text-gray-700 text-sm font-bold mb-2">Apelido</label>
                            <input v-model="contact.nickname" id="nickname" type="text"
                                class="border border-gray-300 rounded-lg px-4 py-2 w-full">                           
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input v-model="contact.email" id="email" type="email" 
                                class="border border-gray-300 rounded-lg px-4 py-2 w-full">                           
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Telefone</label>
                            <input v-model="contact.phone" id="phone" type="text" 
                                class="border border-gray-300 rounded-lg px-4 py-2 w-full">                           
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Assunto</label>
                            <input v-model="contact.subject" id="subject" type="text"
                                class="border border-gray-300 rounded-lg px-4 py-2 w-full">                           
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Mensagem</label>
                            <textarea v-model="contact.message" id="message"></textarea>                       
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" @click="cancel"
                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Voltar</button>
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.text-black {
    color: #000000;
}
</style>
