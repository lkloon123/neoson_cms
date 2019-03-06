<template>
    <aside id="leftsidebar" class="sidebar">
        <!-- user info -->
        <div class="user-info">
            <div class="image">
                <img src="https://gurayyarar.github.io/AdminBSBMaterialDesign/images/user.png" width="48" height="48"/>
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">John Doe</div>
                <div class="email">john.doe@example.com</div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="#"><i class="material-icons">person</i>Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="material-icons">group</i>Followers</a></li>
                        <li><a href="#"><i class="material-icons">shopping_cart</i>Sales</a></li>
                        <li><a href="#"><i class="material-icons">favorite</i>Likes</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#" @click.prevent="logout"><i class="material-icons">input</i>Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">Main</li>
                <li>
                    <a href="#">
                        <i class="material-icons">home</i>
                        <span>Home</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- #menu -->
    </aside>
</template>

<script>
    export default {
        methods: {
            logout() {
                axios.post('/logout')
                    .then(() => {
                        window.location = '/';
                    });
            }
        }
    }
</script>

<style scoped>

</style>
