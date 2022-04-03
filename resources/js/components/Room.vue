<template>
    <div class="room-container">
        <div class="title">Rooms</div>
        <div v-for="room in defaultRooms" v-bind:key="room.name">
        <roomCard v-bind:room="room" :currentSubject="currentSubject"/>
        </div>
    </div>
</template>

<script>
import roomCard from './RoomCard.vue';

export default {
  name: 'room',
    props:['currentSubject'],
  components: { roomCard },
  data(){
    return {
      defaultRooms: [{name: 'Great Hall', limit: '2/8'},{name: 'Silent Study', limit: '2/10'}]
    }
  }
};
</script>

<style>
  @import '../../css/roomStyle.css';
</style>
