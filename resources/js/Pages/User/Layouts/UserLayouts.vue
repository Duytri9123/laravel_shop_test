<template>
    <div >
    <!-- header -->
    <Header/>
    <!-- main Content -->
    <!-- content -->
    <slot/>
    <!-- footer -->
    <Footer/>

    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import Footer from './Footer.vue';
import Header from './Header.vue';
import { initFlowbite } from 'flowbite';
onMounted(()=>
{
    initFlowbite();
})

</script>

<style lang="scss" scoped>

</style>
