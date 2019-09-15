<template>
    <input :aria-describedby="getId"
           :id="getId"
           :value="value"
           @input="$emit('input', $event.target.value)"
           class="form-control"
           type="text"/>
</template>

<script>
    import Mixin from './mixin';

    export default {
        mixins: [Mixin]
    }
</script>

<style scoped>

</style>
