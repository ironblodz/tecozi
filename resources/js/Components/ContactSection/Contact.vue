<template>
    <section>
        <div class="flex flex-col xl:flex-row justify-center mt-20 ">
            <!-- Primeira Coluna com Informações -->
            <div class="flex flex-col mx-5 mt-12">
                <div class="bg-gray-100 rounded-xl px-6 w-full mx-auto">
                    <div class="flex flex-row justify-center items-center">
                        <h1
                            class="bg-primary-default text-white rounded-lg w-44 text-center text-2xl relative -top-16 xl:-top-14 mt-12">
                            Contactos
                        </h1>
                    </div>
                    <div class="-mt-[45px] mb-4">
                        <p class="text-center text-base font-bold">Produção</p>
                        <p class="text-center text-base">+351 968 433 620</p>
                        <p class="text-center text-base mb-4">(Chamada para rede móvel nacional)</p>
                        <p class="text-center text-base font-bold">Financeiro</p>
                        <p class="text-center text-base">+351 966 122 406</p>
                        <p class="text-center text-base mb-4">(Chamada para rede móvel nacional)</p>
                        <p class="text-center text-base font-bold">Geral</p>
                        <p class="text-center text-base">+351 236 926 148</p>
                        <p class="text-center text-base mb-4">(Chamada para rede fixa nacional)</p>
                        <p class="text-center text-base">E-mail: tecozi11@gmail.com</p>
                    </div>
                </div>

                <div class="bg-gray-100 rounded-xl p-6 mt-4 w-full mx-auto">
                    <div class="flex flex-row justify-center items-center">
                        <h1
                            class="bg-primary-default text-white rounded-lg w-44 text-center text-2xl relative -top-10 xl:-top-12">
                            Horário
                        </h1>
                    </div>
                    <div class="-mt-[20px] mb-2">
                        <p class="text-center text-base">Segunda-feira a Sexta-feira <br /> 8h:00 às 17h:00</p>
                        <p class="text-center text-base">Descanso semanal sábado e domingo</p>
                    </div>
                </div>

                <div class="bg-gray-100 rounded-xl p-6 mt-4 mb-5 w-full mx-auto">
                    <div class="flex flex-row justify-center items-center">
                        <h1
                            class="bg-primary-default text-white rounded-lg w-44 text-center text-2xl relative -top-10 xl:-top-12">
                            Localização
                        </h1>
                    </div>
                    <div class="-mt-[20px]">
                        <p class="text-center text-base">
                            Rua da Lagoinha, nº29 <br />Milhariças, 3100-046 Abiul
                        </p>
                    </div>
                </div>
            </div>

            <!-- Segunda Coluna com o Formulário -->
            <div class="flex flex-col mx-5 mt-12 xl:flex-row">
                <div class="border border-primary-default rounded-xl p-6 w-full xl:h-[620px] xl:w-[800px]">
                    <h1 class="text-primary-default text-2xl font-bold">Contacte-nos</h1>
                    <p class="text-base mt-2">Estamos à disposição para qualquer dúvida ou questão</p>
                    <form @submit.prevent="submitForm" class="flex flex-col space-y-5 mt-5">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <label for="first_name" class="text-base text-primary-default">Primeiro Nome<span
                                        class="text-secondary-default"> *</span></label>
                                <input id="first_name" v-model="form.first_name" type="text"
                                    class="p-2 border border-primary-default rounded-xl outline-none focus:border-primary-default transition-colors mt-1"
                                    placeholder="O seu Nome" required />
                                <span v-if="errors.first_name" class="text-red-500 text-sm">{{ errors.first_name[0]
                                    }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label for="nickname" class="text-base text-primary-default">Apelido<span
                                        class="text-secondary-default"> *</span></label>
                                <input id="nickname" v-model="form.nickname" type="text"
                                    class="p-2 border border-primary-default rounded-xl outline-none focus:border-primary-default transition-colors mt-1"
                                    placeholder="O seu Apelido" required />
                                <span v-if="errors.nickname" class="text-red-500 text-sm">{{ errors.nickname[0]
                                    }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <label for="email" class="text-base text-primary-default">E-mail<span
                                        class="text-secondary-default"> *</span></label>
                                <input id="email" type="email" v-model="form.email"
                                    class="p-2 border border-primary-default rounded-xl outline-none focus:border-primary-default transition-colors mt-1"
                                    placeholder="O seu E-mail" required />
                            </div>
                            <div class="flex flex-col">
                                <label for="phone" class="text-base text-primary-default">Telemóvel</label>
                                <input id="phone" type="text" v-model="form.phone"
                                    class="p-2 border border-primary-default rounded-xl outline-none focus:border-primary-default transition-colors mt-1"
                                    placeholder="O seu Telemóvel" />
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label for="subject" class="text-base text-primary-default">Assunto<span
                                    class="text-secondary-default"> *</span></label>
                            <div
                                class="flex flex-col lg:flex-row items-start lg:items-center space-y-2 lg:space-y-0 lg:space-x-4 mt-2">
                                <label class="flex items-center">
                                    <input type="radio" name="subject" value="Informações" v-model="form.subject"
                                        class="mr-2 border-none bg-gray-100" required>
                                    <p class="text-primary-default">Informações</p>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="subject" value="Pedido de Orçamento"
                                        v-model="form.subject" class="mr-2 border-none bg-gray-100" required>
                                    <p class="text-primary-default">Pedido de Orçamento</p>
                                </label>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label for="message" class="text-base text-primary-default">Mensagem<span
                                    class="text-secondary-default"> *</span></label>
                            <textarea id="message"
                                class="p-2 border border-primary-default rounded-xl bg-transparent outline-none focus:border-primary-default transition-colors mt-1 h-32"
                                placeholder="Escreva a sua Mensagem" v-model="form.message" required></textarea>
                        </div>

                        <div
                            class="flex flex-col lg:flex-row justify-between items-start lg:items-center mt-5 space-y-4 lg:space-y-0">
                            <label class="flex items-center">
                                <input type="radio" name="agreement" value="Li e concordo com a política de privacidade"
                                    class="mr-2 border-none bg-gray-100" required>
                                <p class="text-primary-default">Li e concordo com a política de privacidade<span
                                        class="text-secondary-default"> *</span></p>
                            </label>
                            <button type="submit"
                                class="bg-primary-default text-white p-3 rounded-xl hover:bg-primary-dark transition-colors w-full lg:w-auto">
                                Enviar Mensagem
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Iframe do Google Maps -->
        <div class="flex flex-col items-center mt-10 mb-10">
            <div class="w-full max-w-4xl xl:max-w-[74rem] px-4">
                <div class="relative w-full overflow-hidden rounded-xl" style="padding-top: 30.25%;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d48987.39309502312!2d-8.49835630115621!3d39.88068702937121!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22637ec1534ef5%3A0xae6b6f8154aee9b0!2sCozinhas%20Tecozi%20Lda!5e0!3m2!1spt-PT!2spt!4v1729005435063!5m2!1spt-PT!2spt"
                        class="absolute top-0 left-0 w-full h-full border-none" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

    </section>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
    name: "Contacts",
    setup() {
        // Definindo o objeto `form` como um `ref` reativo
        const form = ref({
            first_name: '',
            nickname: '',
            email: '',
            phone: '',
            subject: '',
            message: ''
        });

        // Definindo um objeto para armazenar os erros de validação
        const errors = ref({
            first_name: '',
            nickname: '',
            email: '',
            phone: '',
            subject: '',
            message: ''
        });

        // Função para submeter o formulário
        const submitForm = async () => {
            // Limpar erros anteriores
            errors.value = {};

            try {
                console.log(form.value); // Verifique os dados do formulário
                const response = await axios.post('/backoffice/contacts/store', form.value);

                if (response.status === 200) {
                    alert('Mensagem enviada com sucesso!');
                    // Limpar o formulário após o envio
                    form.value = {
                        first_name: '',
                        nickname: '',
                        email: '',
                        phone: '',
                        subject: '',
                        message: ''
                    };
                }
            } catch (error) {
                // Verificar se houve erro de validação (422)
                if (error.response && error.response.status === 422) {
                    // Preencher os erros a partir da resposta da validação
                    errors.value = error.response.data.errors;
                } else {
                    console.error('Erro ao enviar o formulário:', error);
                    alert('Erro ao enviar a mensagem. Tente novamente mais tarde.');
                }
            }
        };


        return {
            form,
            submitForm,
            errors // Expor os erros para o template
        };
    }
};
</script>


<style scoped>
.error-message {
    color: red;
    font-size: 12px;
}
</style>
