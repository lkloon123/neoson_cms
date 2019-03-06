<template>
    <div>
        <top-nav></top-nav>
        <section>
            <left-nav></left-nav>
            <right-nav></right-nav>
        </section>
        <section class="content">
            <router-view></router-view>
        </section>
    </div>
</template>

<script>
    import TopNav from './TopNav';
    import LeftNav from "./LeftNav";
    import RightNav from "./RightNav";

    export default {
        components: {
            RightNav,
            LeftNav,
            TopNav
        }
    }
</script>

<style scoped>

</style>
