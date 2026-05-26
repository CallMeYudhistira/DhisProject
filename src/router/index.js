import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ProjectList from '../views/projects/ProjectList.vue'
import ProjectCreate from '../views/projects/ProjectCreate.vue'
import ProjectEdit from '../views/projects/ProjectEdit.vue'
import ErrorView from '../views/ErrorView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/projects',
      name: 'project-list',
      component: ProjectList,
      meta: { requiresAuth: true }
    },
    {
      path: '/projects/create',
      name: 'project-create',
      component: ProjectCreate,
      meta: { requiresAuth: true }
    },
    {
      path: '/projects/:id/edit',
      name: 'project-edit',
      component: ProjectEdit,
      meta: { requiresAuth: true }
    },
    {
      path: '/error',
      name: 'error',
      component: ErrorView
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: ErrorView
    }
  ],
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return { el: to.hash, behavior: 'smooth' }
    }
    return { top: 0 }
  }
})

// Authentication guard matching Lumen's JS logic
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const sessionKey = 'dhis_auth';
    const authCode = import.meta.env.VITE_MANAGEMENT_KEYWORD;
    
    if (localStorage.getItem(sessionKey) === authCode) {
      next();
    } else {
      const input = prompt("Verification required to access management page:");
      if (input === authCode) {
        localStorage.setItem(sessionKey, authCode);
        next();
      } else {
        alert("Unauthorized access!");
        next({ name: 'home' });
      }
    }
  } else {
    next();
  }
});

export default router
