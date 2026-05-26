<template>
  <div>
    <nav :class="['navbar', 'fixed-top', 'transition-navbar', { 'navbar-scrolled': isScrolled }]" id="mainNavbar">
      <div class="container">
        <div class="ms-auto d-flex align-items-center justify-content-center">
          <a href="https://github.com/CallMeYudhistira" target="_blank" class="nav-link px-2 px-sm-3 fs-4 transition-hover">
            <i class="fa-brands fa-github text-dark"></i>
          </a>
          <a href="https://wa.me/6281316560366" target="_blank" class="nav-link px-2 px-sm-3 fs-4 transition-hover">
            <i class="fa-brands fa-whatsapp text-dark"></i>
          </a>
          <a href="https://www.linkedin.com/in/yudhis-tira-063b95382/" target="_blank" class="nav-link px-2 px-sm-3 fs-4 transition-hover">
            <i class="fa-brands fa-linkedin text-dark"></i>
          </a>
          <a href="mailto:tiray9272@gmail.com" target="_blank" class="nav-link px-2 px-sm-3 fs-4 transition-hover">
            <i class="fa-regular fa-envelope text-dark"></i>
          </a>
          <a href="https://www.instagram.com/callmeudiss" target="_blank" class="nav-link px-2 px-sm-3 fs-4 transition-hover">
            <i class="fa-brands fa-instagram text-dark"></i>
          </a>
          <a href="https://www.youtube.com/@callmeyudhistira9805" target="_blank" class="nav-link px-2 px-sm-3 fs-4 transition-hover">
            <i class="fa-brands fa-youtube text-dark"></i>
          </a>
        </div>
      </div>
    </nav>

    <section id="home" class="hero d-flex align-items-center text-center min-vh-100 bg-light">
      <div class="container px-4">
        <h1 class="display-2 fw-bolder mb-4 tracking-tight">DhisLab</h1>
        <p class="fs-4 text-secondary mb-4">
          <span id="typed-text">{{ typedTextValue }}</span><span class="cursor">|</span>
        </p>
        <a href="#portfolio" class="btn-dark rounded-pill transition-hover mt-4 btn btn-lg px-4">
          View My Work <i class="fa-solid fa-arrow-down ms-2"></i>
        </a>
      </div>
    </section>

    <div id="portfolio">
      <template v-if="projects.length > 0">
        <section
          v-for="(project, index) in projects"
          :key="project.id"
          :class="['project-section', 'min-vh-100', 'd-flex', 'align-items-center', index % 2 !== 0 ? 'bg-light' : 'bg-white', 'py-5']"
        >
          <div class="container px-3">
            <div :class="['row', 'align-items-center', index % 2 !== 0 ? 'flex-row-reverse' : '', 'g-4', 'g-lg-5']">
              <div class="col-12 col-lg-6">
                <div class="shadow-lg rounded-4 overflow-hidden transition-hover" style="aspect-ratio: 16 / 9;">
                  <img
                    v-if="project.preview"
                    :src="project.preview"
                    class="w-100 h-100"
                    :alt="project.title"
                    style="object-fit: cover;"
                  />
                  <div v-else class="bg-secondary d-flex align-items-center justify-content-center text-white w-100 h-100">
                    <i class="fa-regular fa-image fs-1 opacity-25"></i>
                  </div>
                </div>
              </div>

              <div class="col-12 col-lg-6">
                <div :class="['project-info', index % 2 !== 0 ? 'pe-lg-5' : 'ps-lg-5', 'text-center', 'text-lg-start']">
                  <span class="badge bg-dark mb-3 px-3 py-2 rounded-pill">
                    0{{ index + 1 }} / Project
                  </span>
                  <h2 class="display-4 fw-bold mb-4">{{ project.title }}</h2>
                  <p class="lead text-muted mb-4" style="line-height: 1.8;">
                    {{ project.description }}
                  </p>
                  <a
                    v-if="project.url"
                    class="btn btn-outline-dark btn-lg rounded-pill px-4"
                    :href="project.url"
                    target="_blank"
                  >
                    Live Preview <i class="fa-solid fa-up-right-from-square ms-2 small"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </section>
      </template>
      <template v-else>
        <section class="min-vh-100 d-flex align-items-center justify-content-center bg-light text-center">
          <div class="container px-4">
            <i class="fa-solid fa-box-open fs-1 text-muted mb-4 opacity-25"></i>
            <h2 class="fw-bold mb-3">No projects yet</h2>
            <p class="text-muted lead mb-4">The showcase is currently empty.</p>
          </div>
        </section>
      </template>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { supabase } from '../supabase'

const isScrolled = ref(false)
const projects = ref([])
const typedTextValue = ref('')

const texts = [
  "Hello World.",
  "Aku Yudis, Kamu Apa?",
]
let textIndex = 0
let charIndex = 0
let isDeleting = false
let typeTimeout = null

const typeEffect = () => {
  const currentText = texts[textIndex]
  if (!isDeleting) {
    typedTextValue.value = currentText.substring(0, charIndex + 1)
    charIndex++
    if (charIndex === currentText.length) {
      typeTimeout = setTimeout(() => { isDeleting = true; typeEffect(); }, 1000)
      return
    }
  } else {
    typedTextValue.value = currentText.substring(0, charIndex - 1)
    charIndex--
    if (charIndex === 0) {
      isDeleting = false
      textIndex = (textIndex + 1) % texts.length
    }
  }
  const speed = isDeleting ? 40 : 60
  typeTimeout = setTimeout(typeEffect, speed)
}

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

const fetchProjects = async () => {
  const { data, error } = await supabase
    .from('projects')
    .select('*')
    .order('created_at', { ascending: true })
  
  if (data) {
    projects.value = data
  }
}

onMounted(() => {
  typeEffect()
  window.addEventListener('scroll', handleScroll)
  fetchProjects()
})

onUnmounted(() => {
  if (typeTimeout) clearTimeout(typeTimeout)
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.transition-navbar {
  padding: 25px 0;
  transition: all 0.4s ease;
}

.navbar-scrolled {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(15px);
  padding: 12px 0;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.tracking-tight {
  letter-spacing: -0.05em;
}

.transition-hover {
  transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.transition-hover:hover {
  transform: translateY(-10px);
}

.hero {
  min-height: 100vh;
  color: black;
  padding: 0 15px;
}

.hero h1 {
  font-size: 2.7rem;
  animation: floating 3s ease-in-out infinite;
}

@keyframes floating {
  0% { transform: translateY(0px); }
  50% { transform: translateY(-15px); }
  100% { transform: translateY(0px); }
}

.hero p {
  font-size: clamp(1rem, 3vw, 1.3rem);
  max-width: 600px;
  margin: 0 auto;
}

.cursor {
  display: inline-block;
  margin-left: 4px;
  animation: blink 1s infinite;
}

@keyframes blink {
  0%, 100% { opacity: 1; }
  50% { opacity: 0; }
}

/* Responsive spacing fixes */
@media (max-width: 576px) {
  .py-5 {
    padding-top: 3rem !important;
    padding-bottom: 3rem !important;
  }
  .px-4 {
    padding-left: 1.5rem !important;
    padding-right: 1.5rem !important;
  }
}
</style>

<style>
html {
  scroll-behavior: smooth;
}
</style>
