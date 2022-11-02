<template>
    <router-view></router-view>
</template>

<script>
    export default {
        name: "App",
    }
</script>

<style>
    html {
        user-select: none;
        cursor: default;
    }
    body {
        font-family: "Ubuntu", sans-serif;
    }
    .currency-up::after {
        content: "\25B2";
        color: var(--bs-success);
    }
    .currency-down::after {
        content: "\25BC";
        color: var(--bs-danger);
    }

    @media (min-width: 0px)
    {
        html {
            font-size: 16px;
        }
    }
    @media (min-width: 576px)
    {

    }
    @media (min-width: 768px)
    {
        html {
            font-size: 14px;
        }
    }
    @media (min-width: 992px)
    {
        
    }
    @media (min-width: 1200px)
    {

    }
</style>
