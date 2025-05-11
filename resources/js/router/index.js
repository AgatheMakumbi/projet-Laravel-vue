import { createRouter, createWebHistory } from 'vue-router';
import StoryList from '@/pages/StoryList.vue';
import SingleStory from '@/pages/SingleStory.vue';

const routes = [
  { path: '/', name: 'StoryList', component: StoryList },
  { path: '/story/:id', name: 'SingleStory', component: SingleStory, props: true }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
