<template>
    <div>
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="/images/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{currentUserInfoName}}</div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-title">Logged in {{lastLoginTimestamp}}</div>
            <a href="#" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item has-icon text-danger" @click.prevent="logoutModalState = 'show'">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <confirm-modal :cfm-btn-class="{btn: true, 'btn-danger': true}"
                       :current-state="logoutModalState"
                       @confirm="logout"
                       @hidden="logoutModalState = 'hide'"
                       body="Confirm Logout?"
                       title="Confirmation"></confirm-modal>
    </div>
</template>

<script>
    import {mapActions, mapState} from 'vuex';
    import moment from 'moment';
    import ConfirmModal from '@components/modal/ConfirmModal';

    moment.updateLocale('en', {
        relativeTime: {
            s: 'a few secs',
            ss: '%d secs',
            m: 'a min',
            mm: '%d mins'
        }
    });

    export default {
        data: () => ({
            logoutModalState: 'hide'
        }),
        computed: {
            ...mapState(['currentUserInfo']),
            lastLoginTimestamp() {
                if (this.currentUserInfo && this.currentUserInfo.last_login_at) {
                    return moment(this.currentUserInfo.last_login_at).fromNow();
                }
            },
            currentUserInfoName() {
                if (this.currentUserInfo && this.currentUserInfo.name) {
                    return this.currentUserInfo.name;
                }
            }
        },
        methods: {
            ...mapActions(['logout'])
        },
        components: {
            ConfirmModal
        }
    }
</script>

<style scoped>

</style>
