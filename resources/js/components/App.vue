<template>
    <div id="app">
        <house-component/>
        <notifications position="bottom left"/>
    </div>
</template>

<script>
    import HouseComponent from "./HouseComponent.vue"

    export default {
        name: "App",
        components: {
            HouseComponent
        }
    }
</script>

<style scoped>

</style>