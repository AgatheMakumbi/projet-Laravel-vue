<script setup>
import { useFetchJson } from "@/composables/useFetchJson";
import SingleChapter from "../components/SingleChapter.vue";


// Ici, on récupère les données du chapitre 1 depuis l'API
const { data: chapter, loading, error } = useFetchJson('chapters/1');
const { data: stories, loading, error  } = useFetchJson("stories");
const { data: myStory,loading, error  } = useFetchJson("stories/1");
//const { data: delTest, error: delError} = useFetchJson({url: 'test', method: 'DELETE' });
console.log(stories);
console.log(myStory);
</script>

<template>
    <div>
        <h1>Page Example</h1>
        <ul v-if="stories">
            <li v-for="story in stories" :key="story.id">
                {{ story.title }} — {{ story.description }}
            </li>
        </ul>
        <SingleChapter/>
    </div>
    <div>
    <h1>Chapitre en vedette</h1>

    <p v-if="loading">Chargement...</p>
    <p v-else-if="error">Erreur : {{ error.message }}</p>

    <!-- Affichage du chapitre si les données sont disponibles -->
    <SingleChapter v-if="chapter" :chapter="chapter" />
  </div>
</template>

<style scoped></style>
