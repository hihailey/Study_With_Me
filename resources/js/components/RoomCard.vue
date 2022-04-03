<template>
    <div class="card-container">
        <div class="name-wrapper">
            <div class="card-title">{{room.name}}</div>
            <div class="card-limit">Limit: {{room.limit}}</div>
        </div>
        <a :href="'/streaming/'+room.name"><button class="green-btn">Join</button></a>
    </div>
</template>

<script>

export default {
  name: 'roomCard',
  props: ['room', 'currentSubject']
};
</script>

<style>
  @import '../../css/roomStyle.css';
</style>
