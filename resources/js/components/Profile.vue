<template>
  <div id="profile">
    <div class="title">Profile</div>
    <h3>{{name}}</h3>
    <p>Currently studying: {{currentSubject}}</p>
    <!-- <div class="align-bottom">
      <log-out-button />
    </div> -->
  </div>
</template>

<script>
import logOutButton from '../components/Buttons/Logout.vue';
export default {
  name: 'profile',
  components: { logOutButton },
  data() {
    return {
      user: {
        name: '',
        currentSubject: '',
      },
    };
  },
  methods: {},
};
</script>

<style>
@import '../../css/profile.css';
</style>