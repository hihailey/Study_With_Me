VideoChat.vue
<template>
  <div class="container">
    <h1 class="text-center">Study With Me!</h1>
    <div
      class="video-container"
      ref="video-container"
    >
      <video
        class="video-here"
        ref="video-here"
        autoplay
      ></video>
      <video
        class="video-there"
        ref="video-there"
        autoplay
      ></video>
      <div
        class="text-right"
        v-for="(name,userId) in users"
        :key="userId"
      >
        <button
          @click="startVideoChat(userId)"
          v-text="`Talk with ${name}`"
        />
      </div>
    </div>
  </div>
</template>
<script>
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
export default {
  // props: ['user', 'others', 'pusherKey', 'pusherCluster', 'usersInRoom'],
  props: ['user', 'pusherKey', 'pusherCluster'],
  data() {
    return {
      channel: null,
      stream: null,
      peers: {},
      users: [],
      groupId: '',
    };
  },
  mounted() {
    this.setupVideoChat();
    this.listen();
  },
  methods: {
    listen() {
      var vm = this;
      const url = window.location.href;
      const groupId = url.split('/').slice(-1)[0];
      // const groupId = url.split('/').slice(-1)[0];
      Echo.join('send' + groupId)
        .here((user) => {
          this.users = user;
        })
        .joining((user) => {
          // this.typing = user.name + ' is online';
          // this.users.push(user);
          // this.typingTimer = setTimeout(() => {
          //   this.typing = '';
          // }, 3000);
          console.log('chat online' + user.id);
        })
        .leaving((user) => {
          this.typing = user.name + ' is off line';
          // this.typingTimer = setTimeout(() => {
          //   this.typing = '';
          // }, 3000);
        });
    },
    startVideoChat(userId) {
      this.getPeer(userId, true);
    },
    getPeer(userId, initiator) {
      if (this.peers[userId] === undefined) {
        let peer = new Peer({
          initiator,
          stream: this.stream,
          trickle: false,
        });
        peer
          .on('signal', (data) => {
            this.channel.trigger(`client-signal-${userId}`, {
              userId: this.user.id,
              data: data,
            });
          })
          .on('stream', (stream) => {
            const videoThere = this.$refs['video-there'];
            videoThere.srcObject = stream;
          })
          .on('close', () => {
            const peer = this.peers[userId];
            if (peer !== undefined) {
              peer.destroy();
            }
            delete this.peers[userId];
          });
        this.peers[userId] = peer;
      }
      return this.peers[userId];
    },
    async setupVideoChat() {
      // To show pusher errors
      // Pusher.logToConsole = true;
      const stream = await navigator.mediaDevices.getUserMedia({
        video: true,
        audio: true,
      });
      // audio : false

      const videoHere = this.$refs['video-here'];
      // We need to put this in array! -> To make more video

      videoHere.srcObject = stream;
      this.stream = stream;
      const pusher = this.getPusherInstance();
      this.channel = pusher.subscribe('presence-video-chat');

      console.log(this.users);
      // console.log(this.usersInRoom);
      //See the all users

      this.channel.bind(`client-signal-${this.user.id}`, (signal) => {
        const peer = this.getPeer(signal.userId, false);
        peer.signal(signal.data);
      });
    },
    getPusherInstance() {
      return new Pusher(this.pusherKey, {
        authEndpoint: '/auth/video_chat',
        cluster: this.pusherCluster,
        auth: {
          headers: {
            'X-CSRF-Token': document.head.querySelector(
              'meta[name="csrf-token"]'
            ).content,
          },
        },
      });
    },
  },
};
</script>
<style>
.video-container {
  width: 500px;
  height: 380px;
  margin: 8px auto;
  border: 3px solid #000;
  position: relative;
  box-shadow: 1px 1px 1px #9e9e9e;
}
.video-here {
  width: 130px;
  position: absolute;
  left: 10px;
  bottom: 16px;
  border: 1px solid #000;
  border-radius: 2px;
  z-index: 2;
}
.video-there {
  width: 100%;
  height: 100%;
  z-index: 1;
}
.text-right {
  text-align: right;
}
</style>