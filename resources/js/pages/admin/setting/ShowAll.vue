<template>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-large-icons">
                <div class="card-icon bg-primary text-white"><i class="fas fa-cog"></i></div>
                <div class="card-body">
                    <h4>General</h4>
                    <p>General settings such as site title, description and so on.</p>
                    <router-link class="card-cta" to="/settings/general">Change Setting</router-link>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-large-icons">
                <div class="card-icon bg-primary text-white"><i class="fas fa-user-lock"></i></div>
                <div class="card-body">
                    <h4>Roles And Permission</h4>
                    <p>Roles and permission setting.</p>
                    <router-link class="card-cta" to="/settings/roles">Change Setting</router-link>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-large-icons">
                <div class="card-icon bg-primary text-white"><i class="fas fa-user"></i></div>
                <div class="card-body">
                    <h4>User Management</h4>
                    <p>Manage user setting</p>
                    <router-link class="card-cta" to="/settings/users">Change Setting</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Settings');
        }
    }
</script>

<style scoped>

</style>
