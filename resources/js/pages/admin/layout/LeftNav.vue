<template>
    <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <router-link to="/dashboard">NeoSon<strong>CMS</strong></router-link>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <router-link to="/dashboard">NEO</router-link>
            </div>

            <ul class="sidebar-menu">
                <router-link to="/dashboard" tag="li">
                    <a><i class="fas fa-fire"></i><span>Dashboard</span></a>
                </router-link>
                <router-link to="/pages" tag="li">
                    <a><i class="far fa-file"></i><span>Pages</span></a>
                </router-link>
            </ul>
        </aside>
    </div>
</template>

<script>
    export default {}
</script>

<style scoped>

</style>
