<template>
  <div>
    <div class="card card-default timer-container">
      <div class="card-header center">Pomodoro Timer</div>
      <div class="card-body">
        <div class="setter">
          <div
            id="down"
            class="toggle"
            @click="changeTime"
          >-</div>
          <div id="userTime">{{displayUserTime}}</div>
          <div
            id="up"
            class="toggle"
            @click="changeTime"
          >+</div>
        </div>

        <div id="time-box">
          <div id="timer">{{displayTime}}</div>
        </div>
        <div
          id="goPause-btn"
          @click="goPause"
          class="stopped"
        >{{goPauseBtnText}}</div>
        <div
          id="reset-btn"
          @click="reset"
        >Reset</div>
      </div>
    </div>
  </div>
  <!--/#app-->
</template>

<script>
export default {
  el: '#app',
  data() {
    return {
      clockCount: 1500,
      count: 1500,
      countdownStatus: 'stopped',
    };
  },
  methods: {
    changeTime: function (e) {
      if (this.countdownStatus === 'stopped') {
        switch (e.target.id) {
          case 'up':
            this.clockCount += 60;
            this.count = this.clockCount;
            break;
          case 'down':
            if (this.clockCount > 60) {
              this.clockCount -= 60;
              this.count = this.clockCount;
            }
            break;
        }
      } // end countdownStatus if
    },
    goPause: function () {
      var status = this.countdownStatus;
      if (status === 'stopped') {
        this.countdownStatus = 'started';
        this.startClock();
      }
      if (status === 'started') {
        this.countdownStatus = 'stopped';
        this.stopClock();
      }
    },
    startClock: function () {
      this.countdownID = setInterval(this.countDown, 1000);
    },
    countDown: function () {
      this.count--;
      if (this.count === 0) {
        alert('Good job! Take a break.');
        this.stopClock();
        this.reset();
      }
    },
    stopClock: function () {
      clearInterval(this.countdownID);
      this.countdownID = undefined;
    },
    reset: function () {
      if (this.countdownStatus === 'started') {
        this.countdownStatus = 'stopped';
      }
      this.stopClock();
      this.count = this.clockCount;
    },
  },
  computed: {
    displayUserTime: function () {
      return (this.clockCount / 60).toString();
    },
    displayTime: function () {
      var mins, secs, timeStr;

      mins = Math.floor(this.count / 60).toString();
      secs = (this.count % 60).toString();

      if (secs.length < 2) {
        secs = '0' + secs;
      }
      timeStr = mins + ':' + secs;

      return timeStr;
    },
    goPauseBtnText: function () {
      if (this.countdownStatus === 'stopped') {
        return 'Go!';
      }
      if (this.countdownStatus === 'started') {
        return 'Pause';
      }
    },
    timerBoxStyle: function () {
      var transparent = (this.clockCount - this.count) / this.clockCount;
      if (transparent === 0 && this.countdownStatus === 'stopped') {
        return { 'background-color': 'rgba(226, 72, 72, 1' };
      } else {
        return { 'background-color': 'rgba(226, 72, 72,' + transparent };
      }
    },
  },
};
</script>

<style scoped>
body {
  font-size: 32px;
  font-family: 'Rajdhani', sans-serif;
}
.timer-container {
  color: #01345b;
  text-align: center;
  display: flex;
  justify-content: center;
  height: 100%;
}
.setter {
  background-color: #db95bb;
  color: #01345b;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  margin: 16px 25%;
}

#time-box {
  background-color: #b7e4e5;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  text-align: center;
  margin: 16px auto;
  border: 1px solid #b7e4e5;
  position: relative;
}

#timer {
  color: #01345b;
  position: absolute;
  font-size: 2rem;
  width: 300px;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -moz-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  -o-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

#goPause-btn {
  background-color: #ffcf43;
  color: #01345b;
  margin: 16px 25%;
}

#goPause-btn:hover {
  background-color: #1fb57b;
}

#goPause-btn:active {
  background-color: #1fb57b;
}

.toggle {
  width: 33.33%;
}
.toggle:hover {
  background-color: white;
}

#reset-btn {
  display: inline-block;
  background-color: #db95bb;
  color: #01345b;
  font-size: 16px;
  margin: 10px auto;
  padding: 5px;
  border-radius: 1em;
}

#reset-btn:hover {
  background-color: white;
}
</style>