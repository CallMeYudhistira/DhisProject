<template>
  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold">Manage Projects</h2>
      <div>
        <router-link to="/" class="btn btn-outline-secondary me-2">
          <i class="fa-solid fa-house"></i> Home
        </router-link>
        <router-link to="/projects/create" class="btn btn-dark">
          <i class="fa-solid fa-plus"></i> New Project
        </router-link>
      </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th class="ps-4">Title</th>
                <th>Preview</th>
                <th>URL</th>
                <th class="text-end pe-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="project in projects" :key="project.id">
                <td class="ps-4 fw-medium">{{ project.title }}</td>
                <td>
                  <img v-if="project.preview" :src="project.preview" style="height: 40px; width: 60px; object-fit: cover;" class="rounded">
                  <span v-else class="text-muted small">No image</span>
                </td>
                <td>
                  <a v-if="project.url" :href="project.url" target="_blank" class="text-decoration-none">
                    <i class="fa-solid fa-up-right-from-square"></i> Link
                  </a>
                  <span v-else class="text-muted small">-</span>
                </td>
                <td class="text-end pe-4">
                  <router-link :to="`/projects/${project.id}/edit`" class="btn btn-sm btn-outline-primary me-2">
                    <i class="fa-solid fa-pen"></i> Edit
                  </router-link>
                  <button @click="deleteProject(project.id)" class="btn btn-sm btn-outline-danger">
                    <i class="fa-solid fa-trash"></i> Delete
                  </button>
                </td>
              </tr>
              <tr v-if="projects.length === 0">
                <td colspan="4" class="text-center py-4 text-muted">
                  No projects found.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase } from '../../supabase'

const projects = ref([])

const fetchProjects = async () => {
  const { data, error } = await supabase
    .from('projects')
    .select('*')
    .order('created_at', { ascending: false })
  
  if (data) {
    projects.value = data
  }
}

const deleteProject = async (id) => {
  if (confirm('Are you sure you want to delete this project?')) {
    const { error } = await supabase
      .from('projects')
      .delete()
      .eq('id', id)
      
    if (!error) {
      projects.value = projects.value.filter(p => p.id !== id)
    } else {
      alert('Error deleting project: ' + error.message)
    }
  }
}

onMounted(() => {
  fetchProjects()
})
</script>
