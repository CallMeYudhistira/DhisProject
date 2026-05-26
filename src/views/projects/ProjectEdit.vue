<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="fw-bold">Edit Project</h2>
          <router-link to="/projects" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back
          </router-link>
        </div>

        <div v-if="loading" class="text-center py-5">
          <div class="spinner-border text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>

        <div v-else class="card shadow-sm border-0 rounded-4">
          <div class="card-body p-4">
            <form @submit.prevent="updateProject">
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
                Update Project
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { supabase } from '../../supabase'

const router = useRouter()
const route = useRoute()

const loading = ref(true)
const saving = ref(false)

const form = ref({
  title: '',
  description: '',
  preview: '',
  url: ''
})

const fetchProject = async () => {
  const { data, error } = await supabase
    .from('projects')
    .select('*')
    .eq('id', route.params.id)
    .single()
    
  if (data) {
    form.value = {
      title: data.title,
      description: data.description,
      preview: data.preview,
      url: data.url
    }
  } else {
    alert('Project not found!')
    router.push('/projects')
  }
  loading.value = false
}

const updateProject = async () => {
  saving.value = true
  const { error } = await supabase
    .from('projects')
    .update({
      title: form.value.title,
      description: form.value.description,
      preview: form.value.preview,
      url: form.value.url,
      updated_at: new Date().toISOString()
    })
    .eq('id', route.params.id)
    
  saving.value = false
  
  if (!error) {
    router.push('/projects')
  } else {
    alert('Error updating project: ' + error.message)
  }
}

onMounted(() => {
  fetchProject()
})
</script>
