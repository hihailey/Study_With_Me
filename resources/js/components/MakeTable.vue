<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="title">Make a Table</div>
      <div class="card-body form">

        <form
          method="POST"
          action="/group/create"
        >

          <input
            type="hidden"
            name="_token"
            :value="csrf"
          >
          <div class="form-group row">
            <label
              for="name"
              class="col-4 col-form-label text-md-right"
            >Table name</label>

            <div class="col-6">
              <input
                id="name"
                type="text"
                class="form-control"
                name="name"
                value=""
                required
                autocomplete="name"
                autofocus
              >

            </div>
          </div> <br>

          <div class="form-group row mb-2">
            <div class="col-md-6 offset-md-3">
              <button
                type="submit"
                class="btn btn-primary"
              >
                Create a Table
              </button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'make-table',
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content'),
    };
  },
  mounted() {
    console.log('Component mounted.');
  },
};
</script>

<style scoped>
.container {
  background-color: #ffcf43;
  color: #01345b;
  border-radius: 1rem;
  padding: 2rem 1.5rem;
  text-align: center;
  margin-bottom: 2rem;
}
</style>
