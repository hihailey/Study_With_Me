<template>
  <div id="profile">
    <div class="title">Profile</div>
    <h3>{{username}}</h3>
    <h4>Currently studying:</h4>
      <select class="form-select" aria-label="Default select example" v-model="currentSubject" @change="handleSubject">
          <option v-for="subject in subjectList" v-bind:key="subject.Id" v-bind:value="subject">{{ subject.Name }}</option>
      </select>
    <!-- <div class="align-bottom">
      <log-out-button />
    </div> -->
  </div>
</template>

<script>
import logOutButton from '../components/Buttons/Logout.vue';
export default {
  name: 'profile',
    props: ['username', 'updateSubject'],
  components: { logOutButton },
  data() {
    return {
        currentSubject: '',
        subjectList: [
            {'Id': '', 'Name': 'Select subject'},
            {'Id': '1', 'Name': 'Programming'},
            {'Id': '2', 'Name': 'Video Editing'},
            {'Id': '3', 'Name': 'English'},
            {'Id': '4', 'Name': 'Math'}]
    };
  },
    mounted(){
      this.subjectList.push({'Id': '5', 'Name': 'PHP'});
      },
  methods: {
      handleSubject(e){
          this.$emit('subjectSelected', this.currentSubject)
          console.log(this.currentSubject.Name)
      }
  },
};
</script>

<style>
@import '../../css/profile.css';
</style>
