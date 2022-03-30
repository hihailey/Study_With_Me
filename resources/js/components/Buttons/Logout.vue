<template>
  <button class="red-btn">
    {{text}}
  </button>
</template>

<script>
export default {
  name: 'logout-button',
  data() {
    return {
      text: 'Logout',
    };
  },
  methods: {
    async logout() {
      console.log('user logging out');
    },
  },
};
</script>