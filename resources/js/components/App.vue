<template>
    <div>
        <h1>Vue dentro do Laravel com Vite!</h1>
        <button @click="contar">Cliquei {{ contador }} vezes</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            contador: 0
        };
    },
    methods: {
        contar() {
            this.contador++;
        }
    }
};
</script>
