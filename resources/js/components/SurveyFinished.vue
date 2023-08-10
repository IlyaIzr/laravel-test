<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">Survey Finished</div>
      <div class="card-body">
        <template v-if="status === 'loading'">
          <div class="text-center">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </template>
        <template v-else-if="status === 'success'">
          <p class="text-success">Thank you for completing the survey!</p>
        </template>
        <template v-else-if="status === 'error'">
          <p class="text-danger">An error occurred while submitting the survey. Please try again later.</p>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    status: String,
  },
};
</script>
