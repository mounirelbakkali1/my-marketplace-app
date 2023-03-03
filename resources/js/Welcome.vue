<script>
    export default {
        name: 'Welcome',
        data() {
            return {
                message: 'Welcome Page'
            }
        },
        methods: {
            rating(stars) {
                let y = '⭐⭐⭐⭐⭐🌟🌟🌟🌟🌟';
                return y.splice(5-stars, 10-stars);
            }
        }
    }
</script>
<template>
<h1 class="message">{{ message }}</h1>
<h5 v-text="rating(3)"></h5>
</template>



<style>
    .message {
        color: #00b668;
    }
</style>
