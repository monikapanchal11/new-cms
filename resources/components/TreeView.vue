<template>
  <ul class="pl-4">
    <li v-for="page in pages" :key="page.id" class="mb-2 mt-2">

      <div class="flex items-center justify-between">
        <span class="font-medium">{{ page.title }} ({{ page.slug }})</span>
        <div>
          <button
            @click="$emit('edit', page)"
            class="bg-green-500 text-white px-2 py-1 rounded mr-2"
          >
            Edit
          </button>
          <button
            @click="$emit('delete', page.id)"
            class="bg-red-500 text-white px-2 py-1 rounded"
          >
            Delete
          </button>
        </div>
      </div>

      <TreeView
        v-if="page.children && page.children.length > 0"
        :pages="page.children"
        @edit="$emit('edit', $event)"
        @delete="$emit('delete', $event)"
        :depth="depth + 1"
      />
    </li>
  </ul>
</template>

  
<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  pages: {
    type: Array,
    required: true,
  },
  depth: {
    type: Number,
    default: 0,
  },
});
</script>
  
 
<style scoped>

.pl-4 {
  padding-left: 1rem;
}

li {
  list-style-type: none;
}

button {
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #38b2ac; 
}

li:not(:last-child) {
  border-bottom: 1px solid #e2e8f0;
}

li > div {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem 0;
}

button {
  margin-left: 0.5rem;
}

ul {
  margin-left: 20px;
}
</style>
  

