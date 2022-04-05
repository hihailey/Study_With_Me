<template>
  <div class="room-container">
    <div class="title">Tables</div>
    <div
      v-for="room in groups"
      v-bind:key="room.id"
    >
      <roomCard
        v-bind:room="room"
        :currentSubject="currentSubject"
      />
    </div>
  </div>
</template>

<script>
import roomCard from './RoomCard.vue';

export default {
  name: 'room',
  props: ['currentSubject', 'groupAll'],
  components: { roomCard },
  data() {
    return {
      defaultRooms: [
        { name: 'Great Hall', limit: '2/8' },
        { name: 'Silent Study', limit: '2/10' },
      ],
      groups: null,
    };
  },
  methods: {
    getGroups() {
      axios.get('/groups').then((response) => {
        this.groups = response.data.groupsAll;
      });
    },
  },
  mounted() {
    this.getGroups();
  },
};
</script>

<style>
@import '../../css/roomStyle.css';
</style>
