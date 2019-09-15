<template>
    <input :aria-describedby="getId"
           :checked="value"
           :id="getId"
           @click="$emit('input', $event.target.checked)"
           type="checkbox">
</template>

<script>
    import Mixin from './mixin';

    export default {
        mixins: [Mixin]
    }
</script>

<style scoped>

</style>
