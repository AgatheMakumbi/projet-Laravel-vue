<script setup>
import { useRouter } from 'vue-router';
import { useFetchJson } from '@/composables/useFetchJson';

const router = useRouter();

// Appel API : /stories/get
const { data: stories, loading, error } = useFetchJson({ url: '/stories/get', method: 'GET' });

// Redirige vers SingleStory avec l'ID
function goToStory(id) {
  router.push({ name: 'SingleStory', params: { id } });
}
</script>

<template>
  <div>
    <h1>Liste des histoires</h1>

    <p v-if="loading">Chargement...</p>
    <p v-if="error">Erreur : {{ error.message }}</p>

    <ul v-if="stories">
      <li v-for="story in stories" :key="story.id" @click="goToStory(story.id)" style="cursor: pointer;">
        <h2>{{ story.title }}</h2>
        <p>{{ story.description }}</p>
      </li>
    </ul>
  </div>
</template>
