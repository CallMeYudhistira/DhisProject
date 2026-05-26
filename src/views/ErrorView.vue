<template>
  <div class="min-vh-100 d-flex flex-column align-items-center justify-content-center bg-light text-center px-4">
    <h1 class="display-1 fw-bold text-dark mb-2">{{ errorCode }}</h1>
    <h3 class="fs-4 text-muted mb-4">{{ errorMessage }}</h3>
    
    <p class="text-secondary mb-5" style="max-width: 500px;">
      {{ errorDescription }}
    </p>

    <router-link to="/" class="btn btn-dark rounded-pill px-4 py-2 transition-hover">
      <i class="fa-solid fa-arrow-left me-2"></i> Back to Home
    </router-link>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const errorCode = computed(() => {
  // If it's explicitly passed as a query param (e.g. from Nginx redirect)
  if (route.query.code) {
    return route.query.code
  }
  // Default to 404 for unmatched routes
  return '404'
})

const errorMessage = computed(() => {
  switch (errorCode.value) {
    case '404':
      return 'Not Found'
    case '429':
      return 'Too Many Requests'
    case '500':
    case '502':
    case '503':
    case '504':
      return 'Server Error'
    default:
      return 'An Error Occurred'
  }
})

const errorDescription = computed(() => {
  switch (errorCode.value) {
    case '404':
      return "The page you are looking for might have been removed, had its name changed, or is temporarily unavailable."
    case '429':
      return "You have sent too many requests in a given amount of time. Please wait a moment before trying again."
    default:
      return "Something went wrong on our end. Please try again later."
  }
})
</script>

<style scoped>
.transition-hover {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.transition-hover:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}
</style>
