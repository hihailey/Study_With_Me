<template>
  <main id="pomodoro-app">

    <div id="container">
      <div id="timer">
        <div id="time">
          <span
            v-text="minutesShown"
            id="minutes"
          >25</span>
          <span id="colon">:</span>
          <span
            v-text="secondsShown"
            id="seconds"
          >00</span>
        </div>
        <div
          id="filler"
          v-bind:style="{height : fillerHeight+'px'}"
        ></div>
      </div>

      <div id="buttons">
        <button
          id="work"
          v-on:click="startWork"
        >Work</button>
        <button
          id="shortBreak"
          v-on:click="startShortBreak"
        >Short Break</button>
        <button
          id="longBreak"
          v-on:click="startLongBreak"
        >Long Break</button>
        <button
          id="stop"
          v-on:click="stopTimer"
        >Stop</button>
      </div>
    </div>
  </main>
</template>

<script>
new Vue({
  el: '#pomodoro-app',
  events: {
    'hook:ready': function () {
      this.interval = setInterval(this.intervalCallback, 1000);
    },
  },
  data() {
    return {
      minutes: 25,
      seconds: 0,
      interval: null,
      started: false,
      fillerHeight: 0,
      fillerIncrement: 0,
    };
  },
  methods: {
    resetVariables: function (mins, secs, started) {
      this.minutes = mins;
      this.seconds = secs;
      this.started = started;
      this.fillerIncrement = 200 / (this.minutes * 60);
      this.fillerHeight = 0;
    },
    startWork: function () {
      this.resetVariables(25, 0, true);
    },
    startShortBreak: function () {
      this.resetVariables(5, 0, true);
    },
    startLongBreak: function () {
      this.resetVariables(15, 0, true);
    },
    stopTimer: function () {
      this.resetVariables(25, 0, false);
    },
    intervalCallback: function () {
      if (!this.started) return false;
      if (this.seconds == 0) {
        if (this.minutes == 0) {
          this.timerComplete();
          return;
        }
        this.seconds = 59;
        this.minutes--;
      } else {
        this.seconds--;
      }
      this.fillerHeight = this.fillerHeight + this.fillerIncrement;
    },
    timerComplete: function () {
      this.started = false;
      this.fillerHeight = 0;
    },
  },
  computed: {
    secondsShown: function () {
      if (this.seconds < 10) {
        return '0' + parseInt(this.seconds, 10);
      }
      return this.seconds;
    },
    minutesShown: function () {
      if (this.minutes < 10) {
        return '0' + parseInt(this.minutes, 10);
      }
      return this.minutes;
    },
  },
});
</script>

<style scoped>
#container {
  border: 1px solid #333;
  border-radius: 20px;
  width: 400px;
  margin: 20px auto;
  padding: 20px;
  text-align: center;
  background: #333;
}

#timer {
  color: #f00;
  font-size: 50px;
  margin: 10px auto;
  border: 5px solid red;
  border-radius: 50%;
  width: 200px;
  height: 200px;
  overflow: hidden;
  position: relative;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  cursor: default;
}

#time {
  margin-top: 70px;
  z-index: 1;
  position: relative;
}

#filler {
  background: #ddffcc;
  height: 0px;
  width: 200px;
  position: absolute;
  bottom: 0;
}

#buttons button {
  background: #4da6ff;
  border: none;
  color: #fff;
  cursor: pointer;
  padding: 5px;
  width: 90px;
  margin: 10px auto;
  font-size: 14px;
  height: 50px;
  border-radius: 50px;
}

#buttons button#shortBreak {
  background: #0c0;
}

#buttons button#longBreak {
  background: #080;
}

#buttons button#stop {
  background: #f00;
}
</style>