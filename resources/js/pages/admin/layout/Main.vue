<template>
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <top-nav></top-nav>
        <left-nav></left-nav>

        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <div class="section-header-back" v-if="pageBackLink !== null">
                        <router-link :to="pageBackLink" class="btn btn-icon"><i class="fas fa-arrow-left"></i></router-link>
                    </div>
                    <h1>{{currentPageTitle}}</h1>

                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item"
                             v-for="(breadcrumb, index) in breadcrumbList"
                             :key="index">
                            <router-link :to="breadcrumb.link" v-if="breadcrumb.link">{{breadcrumb.name}}</router-link>
                            <span v-else>{{breadcrumb.name}}</span>
                        </div>
                    </div>
                </div>

                <div class="section-body">
                    <router-view></router-view>
                </div>
            </section>
        </div>

        <main-footer></main-footer>
    </div>
</template>

<script>
    import TopNav from './TopNav';
    import LeftNav from "./LeftNav";
    import MainFooter from "./Footer";

    import {mapActions, mapState} from 'vuex';

    export default {
        data: () => ({
            breadcrumbList: []
        }),
        computed: {
            ...mapState(['currentPageTitle', 'pageBackLink'])
        },
        watch: {
            '$route'() {
                this.updateBreadcrumbList();
            }
        },
        methods: {
            ...mapActions(['getCurrentUserInfo']),
            updateBreadcrumbList() {
                this.breadcrumbList = this.$route.meta.breadcrumb;
            }
        },
        components: {
            MainFooter,
            LeftNav,
            TopNav
        },
        mounted() {
            require('@stisla/scripts');
            this.updateBreadcrumbList();
        },
        created() {
            this.getCurrentUserInfo();
        }
    }
</script>

<style scoped>

</style>
