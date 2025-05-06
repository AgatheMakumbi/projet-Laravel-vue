<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  chapter: {
    type: Object,
    required: true
  }
});
</script>

<template>
  <div>
    <h2>Chapitre {{ chapter.id }}</h2>
    <p><em>{{ chapter.description }}</em></p>
    <p>{{ chapter.content }}</p>
    <img v-if="chapter.image" :src="chapter.image" alt="Image du chapitre" />
  </div>
</template>

