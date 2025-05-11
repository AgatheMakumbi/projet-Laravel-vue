<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useFetchJson } from '@/composables/useFetchJson';

const route = useRoute();
const storyId = parseInt(route.params.id, 10); // Récupère l'ID de l'histoire

// ID du chapitre actuel
const currentChapterId = ref(null);

// Composable pour charger un chapitre (par ID de chapitre)
const {
  data: chapter,
  error,
  loading,
  execute: fetchChapter
} = useFetchJson({ url: '/chapters/get', method: 'GET', immediate: false });

// Fonction de chargement d’un chapitre donné
function loadChapter(id) {
  currentChapterId.value = id;
  fetchChapter({ id }); // passe l’ID en GET -> /chapters/get?id=...
}

// Composable pour récupérer le **premier chapitre** de l’histoire
const {
  data: firstChapter,
  execute: fetchFirstChapter
} = useFetchJson({ url: '/chapters/get', method: 'GET', immediate: false });

onMounted(async () => {
  await fetchFirstChapter({ story_id: storyId }); // /chapters/get?story_id=...

  if (firstChapter.value?.id) {
    loadChapter(firstChapter.value.id); // Charge le premier chapitre
  }
});

// Fonction appelée lors d’un clic sur un choix
function handleChoiceClick(targetId) {
  loadChapter(targetId); // Charge le chapitre suivant
}
</script>

<template>
  <div>
    <h1>Lecture de l’histoire</h1>

    <p v-if="loading">Chargement du chapitre...</p>
    <p v-if="error">Erreur : {{ error.message }}</p>

    <div v-if="chapter">
      <h2>{{ chapter.title }}</h2>
      <p>{{ chapter.content }}</p>

      <img v-if="chapter.image" :src="chapter.image" alt="Illustration" style="max-width: 100%;" />

      <h3 v-if="chapter.choices?.length">Que souhaitez-vous faire ?</h3>
      <ul>
        <li v-for="choice in chapter.choices" :key="choice.id">
          <button @click="handleChoiceClick(choice.target_chapter_id)">
            {{ choice.text }}
          </button>
        </li>
      </ul>

      <p v-if="!chapter.choices?.length">Fin de l’histoire.</p>
    </div>
  </div>
</template>
