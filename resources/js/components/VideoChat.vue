VideoChat.vue
<template>
  <div class="">
    <div class="card card-default">
      <div class="card-header">Study Buddy</div>
      <div class="card-body p-0 black">
        <div class="container">
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

          </div>
          <div class="d-flex wrap justify-content-around">
            <div
              class="btn-container"
              v-for="(user,index) in users"
              :key="index"
            >

              <!--
        <videoThere
          ref="video-here${name}"
          :peer="peer.peer"
          :userId="peer.userId"
        ></videoThere> -->

              <button
                class="study-btn"
                @click="startVideoChat(user.id)"
                v-text="`Study with ${user.name}`"
              />
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>
<script>
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
import videoThere from './VideoThere.vue';
export default {
  // props: ['user', 'others', 'pusherKey', 'pusherCluster', 'usersInRoom'],
  props: ['user', 'pusherKey', 'pusherCluster'],
  components: { videoThere },
  data() {
    return {
      channel: null,
      stream: null,
      peers: {},
      users: [],
    };
  },
  mounted() {
    this.listen();
    this.setupVideoChat();
    this.startVideoChat(this.user.id);
  },
  methods: {
    test() {
      alert('parent function called!');
    },
    listen() {
      var vm = this;
      const url = window.location.href;
      const groupId = url.split('/').slice(-1)[0];
      vm.groupId = groupId;
      // const groupId = url.split('/').slice(-1)[0];
      Echo.join('send' + groupId)
        .here((user) => {
          console.log('groudId_chat', groupId);
          this.users = user;
          console.log(this.users);
        })
        .joining((user) => {
          // this.typing = user.name + ' is online';
          this.users.push(user);
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
      console.log('idididididi', userId);
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
            console.log('data', data);
            const url = window.location.href;
            const groupId = url.split('/').slice(-1)[0];
            this.channel.trigger('client-' + groupId, {
              userId: this.user.id,
              data: data,
            });
          })
          .on('stream', (stream) => {
            const videoThere = this.$refs['video-there'];
            console.log('vidoeThere', videoThere);
            console.log('STREAMMMMMM', stream);
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
        // this.peers.push({ userId: userId, peer: peer });
        // console.log('hehehe', Object.entries(this.peers));
      }
      return this.peers[userId];
      // return this.peers.find((peer) => peer.userId === this.userID);
    },
    async setupVideoChat() {
      // To show pusher errors
      // Pusher.logToConsole = true;
      const stream = await navigator.mediaDevices.getUserMedia({
        video: true,
        audio: false,
      });
      // audio : false
      const url = window.location.href;
      const groupId = url.split('/').slice(-1)[0];
      const videoHere = this.$refs['video-here'];
      // We need to put this in array! -> To make more video

      videoHere.srcObject = stream;
      this.stream = stream;
      const pusher = this.getPusherInstance();
      this.channel = pusher.subscribe('presence-video-chat');

      console.log('channel', this.channel);
      // console.log(this.usersInRoom);
      //See the all users

      this.channel.bind('client-' + groupId, (signal) => {
        console.log('SIGNAAAAAL', signal);
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
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')
              .content,
          },
        },
      });
    },
  },
};
</script>
<style>
.video-container {
  width: 100%;
  height: 390px;
  margin: 8px auto;
  border: 1px solid #9e9e9e;
  /* position: relative; */
  /* box-shadow: 1px 1px 1px #9e9e9e; */
}
.video-here {
  width: 130px;
  height: 98px;
  background-color: #fff;
  position: absolute;
  left: 12px;
  top: 350px;
  border: 1px solid #9e9e9e;
  border-radius: 2px;
  z-index: 2;
}
.video-there {
  width: 100%;
  height: 90%;
  z-index: 1;
}
.text-right {
  text-align: right;
  margin-top: 2rem;
}

.study-btn {
  background-color: #b7e4e5;
  border: none;
  color: #01345b;
  padding: 10px;
  border-radius: 10px;
  width: fit-content;
}

.btn-container {
  padding-bottom: 0.5rem;
  margin: 5px;
  display: inline;
}
</style>