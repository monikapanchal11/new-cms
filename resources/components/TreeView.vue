<template>
    <ul>
      <li v-for="page in pages" :key="page.id" class="mb-2 mt-2">
        <div class="flex items-center justify-between">
          <span class="font-medium">{{ page.title }}</span>
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
          v-if="page.children"
          :pages="page.children"
          @edit="$emit('edit', $event)"
          @delete="$emit('delete', $event)"
        />
      </li>
    </ul>
  </template>
  
  <script>
  export default {
    props: ["pages"],
  };
  </script>
  
  <style scoped>
  ul {
    list-style: none;
    padding-left: 1rem;
  }
  </style>
  