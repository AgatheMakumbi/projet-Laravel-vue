<script setup>
  import { ref } from 'vue';
  import { readMode } from '@/store/story';
  import StoryList from '@/pages/StoryList.vue';
  import SingleStory from '@/pages/SingleStory.vue';

</script>

<template>
  <div>
    <main>
      <StoryList v-if="!readMode"></StoryList>
      <SingleStory v-if="readMode"></SingleStory>
      
    </main>
  </div>
</template>

<style scoped>

</style>