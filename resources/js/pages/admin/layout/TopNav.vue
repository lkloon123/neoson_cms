<template>
  <nav class="navbar navbar-expand-lg main-navbar">
    <div class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li>
          <a
            href="#"
            data-toggle="sidebar"
            class="nav-link nav-link-lg"
          ><i class="fas fa-bars" /></a>
        </li>
      </ul>
    </div>
    <ul class="navbar-nav navbar-right">
      <li class="dropdown dropdown-list-toggle">
        <a
          href="#"
          data-toggle="dropdown"
          class="nav-link notification-toggle nav-link-lg beep"
        >
          <i class="far fa-bell" />
        </a>
        <div class="dropdown-menu dropdown-list dropdown-menu-right">
          <div class="dropdown-header">
            Notifications
            <div class="float-right">
              <a href="#">Mark All As Read</a>
            </div>
          </div>
          <div class="dropdown-list-content dropdown-list-icons" />
          <div class="dropdown-footer text-center">
            <a href="#">View All <i class="fas fa-chevron-right" /></a>
          </div>
        </div>
      </li>
      <li class="dropdown">
        <user-box />
      </li>
      <li class="dropdown">
        <locale-selector />
      </li>
    </ul>
  </nav>
</template>

<script>
import LocaleSelector from '@components/LocaleSelector';
import UserBox from './UserBox';

export default {
  components: {
    LocaleSelector, UserBox,
  },
};
</script>

<style scoped>

</style>
