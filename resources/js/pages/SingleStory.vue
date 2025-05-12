<script setup>
import { ref, watch, computed, onMounted } from 'vue';
import { storyId, chapterId, readMode, isLastChapter } from '@/store/story';
import { useFetchJson } from '@/composables/useFetchJson';
import { useJsonStorage } from '@/composables/useJsonStorage';
import SingleChapter from "../components/SingleChapter.vue";

// Fetch story details using the story ID from the store
const { data: story, loading: storyLoading, error: storyError } = useFetchJson({
  url: `stories/${storyId.value}`,
  method: 'GET'
});

// ID du chapitre actuel
const currentChapterId = ref(chapterId.value);

// Reference for chapter data that will be loaded
const chapter = ref(null);
const chapterLoading = ref(true);
const chapterError = ref(null);

// Function to fetch chapter data
function fetchChapterData(chId) {
  if (!chId) return;
  
  chapterLoading.value = true;
  chapterError.value = null;
  
  // Create a new fetch call for the chapter
  const { data, loading, error } = useFetchJson({
    url: `chapters/${chId}`,
    method: 'GET'
  });
  
  // Watch for the data to be loaded
  watch(data, (newData) => {
    if (newData) {
      chapter.value = newData;
      chapterLoading.value = false;
      
      // Check if this is the last chapter (no choices or empty choices array)
      const hasNoChoices = !newData.choices || newData.choices.length === 0;
      isLastChapter.value = hasNoChoices;
      useJsonStorage('isLastChapter', hasNoChoices);
    }
  });
  
  // Watch for errors
  watch(error, (newError) => {
    if (newError) {
      chapterError.value = newError;
      chapterLoading.value = false;
    }
  });
}

// When a choice is made, load the next chapter
function loadNextChapter(targetChapterId) {
  // Update local ref and persistent store
  currentChapterId.value = targetChapterId;
  chapterId.value = targetChapterId;
  useJsonStorage('chapterId', targetChapterId);
  
  // Fetch the new chapter data
  fetchChapterData(targetChapterId);
}

// Function to return to the story list
function returnToStoryList() {
  // Reset all story-related state
  readMode.value = false;
  isLastChapter.value = false;
  storyId.value = null;
  chapterId.value = null;
  
  // Update localStorage
  useJsonStorage('readMode', false);
  useJsonStorage('isLastChapter', false);
  useJsonStorage('storyId', null);
  useJsonStorage('chapterId', null);
}

// Initial load of chapter
onMounted(() => {
  if (currentChapterId.value) {
    fetchChapterData(currentChapterId.value);
  }
});

// Watch for changes in currentChapterId from external sources
watch(currentChapterId, (newValue, oldValue) => {
  if (newValue && newValue !== oldValue) {
    fetchChapterData(newValue);
  }
});

// Debug values
const debugInfo = computed(() => {
  return {
    storyId: storyId.value,
    currentChapterId: currentChapterId.value,
    isLastChapter: isLastChapter.value,
    hasChapter: !!chapter.value,
    hasChoices: chapter.value && chapter.value.choices && chapter.value.choices.length > 0,
    choicesCount: chapter.value?.choices?.length || 0
  };
});
</script>

<template>
  <div v-if="storyLoading || chapterLoading">Chargement...</div>
  <div v-else-if="storyError || chapterError">
    <p>Erreur lors du chargement: {{ storyError || chapterError }}</p>
  </div>
  <div v-else-if="story && chapter" class="story-container">
    <h1>{{ story.title }}</h1>
    
    <!-- Display the chapter content -->
    <SingleChapter :chapter="chapter" />
    
    <!-- Display the choices if it's not the last chapter -->
    <div v-if="chapter.choices && chapter.choices.length > 0" class="choices-container">
      <h3>Que choisir?</h3>
      <div v-for="choice in chapter.choices" :key="choice.id" class="choice">
        <button @click="loadNextChapter(choice.target_chapter_id)" class="choice-button">
          {{ choice.label }}
        </button>
      </div>
    </div>
    
    <!-- Display the end of story message and return button if it's the last chapter -->
    <div v-else class="story-end">
      <p>Fin de l'histoire</p>
      <button @click="returnToStoryList" class="return-button">
        Retourner à la liste des histoires
      </button>
    </div>
    
    <!-- Debug info if needed -->
    <!-- <pre class="debug">{{ debugInfo }}</pre> -->
  </div>
</template>

<style scoped>
.story-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.choices-container {
  margin-top: 30px;
}

.choice {
  margin-bottom: 10px;
}

.choice-button {
  width: 100%;
  padding: 10px;
  background-color: #f0f0f0;
  border: 1px solid #ddd;
  border-radius: 5px;
  cursor: pointer;
  text-align: left;
  transition: background-color 0.2s;
}

.choice-button:hover {
  background-color: #e0e0e0;
}

.story-end {
  margin-top: 30px;
  padding: 15px;
  background-color: #f8f8f8;
  border-radius: 5px;
  text-align: center;
}

.return-button {
  margin-top: 15px;
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.2s;
}

.return-button:hover {
  background-color: #45a049;
}

.debug {
  margin-top: 30px;
  padding: 15px;
  background-color: #f0f0f0;
  border: 1px solid #ddd;
  font-family: monospace;
  white-space: pre-wrap;
}
</style>
