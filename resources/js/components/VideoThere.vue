<template>
  <video
    class="video-there"
    ref="video-there"
    autoplay
  ></video>
</template>

<script>
import Peer from 'simple-peer';
export default {
  name: 'videoThere',
  props: ['userId', 'peer'],
  data() {
    return {};
  },
  mounted() {
    // this.$parent.test();
    this.$parent.startVideoChat(this.userId);
    this.peer.on('stream', (stream) => {
      const videoThere = this.$refs['video-there'];
      videoThere.srcObject = stream;
    });
  },
  methods: {},
};
</script>