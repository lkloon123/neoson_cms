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
                    <a><i class="fas fa-file"></i><span>Pages</span></a>
                </router-link>
                <li class="dropdown" :class="{active: subIsActive('/post')}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-highlighter"></i> <span>Blogging</span>
                    </a>
                    <ul class="dropdown-menu">
                        <router-link to="/posts" tag="li">
                            <a><i class="fas fa-align-left"></i> <span>Posts</span></a>
                        </router-link>
                    </ul>
                </li>
                <router-link to="/forms" tag="li">
                    <a><i class="fas fa-file-signature"></i><span>Forms</span></a>
                </router-link>
                <router-link to="/file-manager" tag="li">
                    <a><i class="fas fa-folder-open"></i><span>File Manager</span></a>
                </router-link>
                <li class="dropdown" :class="{active: subIsActive('/menu')}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-paint-brush"></i> <span>Appearance</span>
                    </a>
                    <ul class="dropdown-menu">
                        <router-link to="/menu" tag="li">
                            <a><i class="fas fa-compass"></i> <span>Menu</span></a>
                        </router-link>
                    </ul>
                </li>
            </ul>
        </aside>
    </div>
</template>

<script>
    export default {
        methods: {
            subIsActive(input) {
                const paths = Array.isArray(input) ? input : [input];
                return paths.some(path => {
                    return this.$route.path.indexOf(path) === 0
                })
            }
        }
    }
</script>

<style scoped>

</style>
