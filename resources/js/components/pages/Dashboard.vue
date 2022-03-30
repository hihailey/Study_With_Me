<template>
  <div class="dashboard-container">
    <profile />
    <room />
  </div>
</template>

<script>
import Room from '../Room.vue';
import Profile from '../Profile.vue';

export default {
  components: { Room, Profile },
};
</script>

<style>
  @import '../../../css/dashboard.css';
</style>