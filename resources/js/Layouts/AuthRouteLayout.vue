<script lang="ts">
import SimpleLayoutForLogin from "./SimpleLayoutForLogin.vue";

export default {
    components: {
        SimpleLayoutForLogin,
    },
};
</script>
<template>
    <SimpleLayoutForLogin> 
        <slot></slot>
        
    </SimpleLayoutForLogin>
</template>
<style scoped></style>
