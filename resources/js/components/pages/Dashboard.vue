<template>
  <div class="dashboard-container">
    <profile
      :username="username"
      @subjectSelected="updateSubject($event)"
    />
    <div class="container d-flex flex-column">
      <make-table />
      <room
        :currentSubject="currentSubject"
        :groupAll="groupAll"
      />
    </div>
  </div>
</template>

<script>
import Room from '../Room.vue';
import Profile from '../Profile.vue';
import MakeTable from '../MakeTable.vue';

export default {
  components: { Room, Profile, MakeTable },
  props: ['username', 'userId'],
  mounted() {
    console.log(this.username, this.userId);
    this.test();
  },
  data() {
    return {
      currentSubject: '',
    };
  },
  methods: {
    updateSubject(subject) {
      this.currentSubject = subject;
      console.log('dash: ', this.currentSubject);
    },
  },
};
</script>

<style>
@import '../../../css/dashboard.css';
</style>
