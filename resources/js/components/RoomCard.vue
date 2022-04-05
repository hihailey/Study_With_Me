<template>
  <div class="card-container">
    <div class="name-wrapper">
      <div class="card-title">{{room.name}}</div>

    </div>
    <form
      method="POST"
      action="/group/join"
    >
      <input
        type="hidden"
        name="_token"
        :value="csrf"
      >
      <input
        type="hidden"
        :value="room.id"
        name="tableId"
      >
      <input
        id="code"
        type="hidden"
        name="code"
        :value="room.code"
        required
      >
      <button
        type="submit"
        class="green-btn"
      >Join</button>
    </form>
  </div>
</template>

<script>
export default {
  name: 'roomCard',
  props: ['room', 'currentSubject'],
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content'),
    };
  },
};
</script>

<style>
@import '../../css/roomStyle.css';
</style>
