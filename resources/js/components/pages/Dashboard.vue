<template>
  <div class="dashboard-container">
    <profile :username="username" @subjectSelected="updateSubject($event)"/>
    <room :currentSubject="currentSubject"  />
  </div>
</template>

<script>
import Room from '../Room.vue';
import Profile from '../Profile.vue';

export default {
  components: { Room, Profile },
    props: ['username', 'userId'],
    mounted () {
        console.log(this.username, this.userId)
    },
    data() {
        return {
            currentSubject: '',
        }
    },
    methods: {
        updateSubject(subject) {
            this.currentSubject = subject;
            console.log('dash: ', this.currentSubject)
        },
    }
};
</script>

<style>
  @import '../../../css/dashboard.css';
</style>
