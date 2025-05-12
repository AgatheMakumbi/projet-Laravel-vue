<script setup>
import { ref } from 'vue';
import { storyId, chapterId, readMode } from '@/store/story';
import { useJsonStorage } from '@/composables/useJsonStorage';
import { useFetchJson } from '@/composables/useFetchJson';


// Appel API 
const { data: stories, loading, error } = useFetchJson({ url: '/stories', method: 'GET' });

function saveData(id, firstChapterId) {                           
  console.log(`Navigating to story with ID: ${id} and chapter ID: ${firstChapterId}`);
  // sauvegarder l'ID de l'histoire et le chapitre dans le localStorage et si je suis en lectureou pas -> UseJsonStorage
  if(id && chapterId) {
    storyId.value = id;
    chapterId.value = firstChapterId;
    readMode.value = true;
    useJsonStorage('storyId', id);
    useJsonStorage('chapterId', firstChapterId);
    useJsonStorage('readMode', true);
  } else {
    console.error('Invalid story ID or chapter ID');
  }
}

</script>

<template>
  <div>
    <h1>Liste des histoires</h1>

    <p v-if="loading">Chargement...</p>
    <p v-if="error">Erreur : {{ error.message }}</p>

    <div v-if="stories" class="stories-list">
      <div v-for="story in stories" :key="story.id" class="story-card">
        <h2>{{ story.title }}</h2>
        <p>{{ story.description }}</p>
        <button 
          @click="saveData(story.id, story.chapters.id)" 
          class="start-button"
        >
          Commencer l'histoire
        </button>
      </div>
    </div>
    <p v-if="!loading && !stories">Aucune histoire trouvée.</p>
  </div>
</template>

<style scoped>
.stories-list {
  display: grid;
  gap: 2rem;
  padding: 1rem;
}

.story-card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 1.5rem;
  background: white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.story-card h2 {
  margin-top: 0;
  color: #333;
}

.story-card p {
  color: #666;
  margin-bottom: 1.5rem;
}

.start-button {
  background-color: #4CAF50;
  color: white;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.2s;
}

.start-button:hover {
  background-color: #45a049;
}
</style>
