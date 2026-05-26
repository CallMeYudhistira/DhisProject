<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="fw-bold">Create Project</h2>
          <router-link to="/projects" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back
          </router-link>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body p-4">
            <form @submit.prevent="saveProject">
              <div class="mb-3">
                <label class="form-label fw-bold">Title</label>
                <input type="text" class="form-control" v-model="form.title" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea class="form-control" rows="4" v-model="form.description" required></textarea>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Preview Image URL</label>
                <input type="text" class="form-control" v-model="form.preview" placeholder="https://...">
                <div class="form-text">Provide a direct link to an image.</div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold">Project URL</label>
                <input type="text" class="form-control" v-model="form.url" placeholder="https://...">
              </div>

              <button type="submit" class="btn btn-dark w-100" :disabled="saving">
                <span v-if="saving" class="spinner-border spinner-border-sm me-2"></span>
                Save Project
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { supabase } from '../../supabase'

const router = useRouter()
const saving = ref(false)

const form = ref({
  title: '',
  description: '',
  preview: '',
  url: ''
})

const saveProject = async () => {
  saving.value = true
  const { error } = await supabase
    .from('projects')
    .insert([
      {
        title: form.value.title,
        description: form.value.description,
        preview: form.value.preview,
        url: form.value.url
      }
    ])
    
  saving.value = false
  
  if (!error) {
    router.push('/projects')
  } else {
    alert('Error saving project: ' + error.message)
  }
}
</script>
