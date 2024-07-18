<script lang="ts">
export default {
    // mixins: [AuthRouteLayoutMixin],
    layout: [SimpleLayoutForLogin],
};
</script>
<script setup lang="ts">
import SimpleLayoutForLogin from "@/Layouts/SimpleLayoutForLogin.vue";
import { textMap } from "@/constants/text";
import { validationRules } from "@/helper/validation";
import { Head, useForm } from "@inertiajs/vue3";
import {
    VBtn,
    VTextField,
    VToolbar,
    VCard,
    VCardTitle,
    VCardActions,
    VCardText,
    VCardSubtitle,
    VForm,
} from "vuetify/components";
import { ref } from "vue";

export type ILoginDataForm = {
    email: string;
    password: string;
    remember: boolean;
};

const loginFormRef = ref(null);

const showingPassword = ref(false);

const formData = useForm<ILoginDataForm>({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    const isValid = loginFormRef.value?.validate();
    if (!isValid) {
        return;
    }
    formData
        .transform((data) => ({
            ...data,
            remember: formData.remember ? "on" : "",
        }))
        .post(window.route("login"), {});
};
</script>

<template>
    <Head title="Log in"></Head>
    <VForm ref="loginFormRef" @submit.prevent="submit">
        <VCard elevation="0">
            <VCardTitle>{{ textMap.messages.welcome }}. </VCardTitle>
            <VCardSubtitle class="text-on-surface">
                {{ textMap.messages.pleaseLogin }}
            </VCardSubtitle>
            <VCardText>
                <VTextField
                    :rules="[
                        validationRules.required(),
                        validationRules.email(),
                    ]"
                    v-model="formData.email"
                    :label="textMap.nouns.email"
                    type="email"
                    :error-messages="
                        $processBackendErrorMsg(
                            formData.errors.email,
                            'địa chỉ email'
                        )
                    "
                ></VTextField>
                <VTextField
                    :rules="[validationRules.required()]"
                    :type="showingPassword ? 'text' : 'password'"
                    v-model="formData.password"
                    :label="textMap.nouns.password"
                    :error-messages="
                        $processBackendErrorMsg(formData.errors.password)
                    "
                    :append-icon="!showingPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showingPassword = !showingPassword"
                ></VTextField>
            </VCardText>
            <VCardActions>
                <VBtn type="submit" variant="flat" color="primary">
                    {{ textMap.verbs.login }}
                </VBtn>
            </VCardActions>
        </VCard>
    </VForm>
</template>
<style scoped></style>
