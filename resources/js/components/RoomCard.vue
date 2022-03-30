<template>
    <div class="card-container">
        <div class="name-wrapper">
            <div class="card-title">{{room.name}}</div>
            <div class="card-limit">Limit: {{room.limit}}</div>
        </div>
        <button class="green-btn">Join</button>
    </div>
</template>

<script>

export default {
  name: 'roomCard',
  props: ['room']
};
</script>

<style>
  @import '../../css/roomStyle.css';
</style>