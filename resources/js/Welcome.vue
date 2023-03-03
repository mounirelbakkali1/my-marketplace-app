<script>
    export default {
        name: 'Welcome',
        data() {
            return {
                message: 'Welcome Page'
            }
        }
    }
</script>
<template>
<h1 class="message">{{ message }}</h1>
</template>



<style>
    .message {
        color: #00b668;
    }
</style>
