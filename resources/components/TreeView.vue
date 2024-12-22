<template>
    <ul>
      <li v-for="page in pages" :key="page.id" class="mb-2 mt-2">
        <div class="flex items-center justify-between">
        <!-- Title and action buttons -->
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
        
        v-if="page.children && page.children.length > 0"
        :pages="page.children"
        @edit="$emit('edit', $event)"
        @delete="$emit('delete', $event)"
        :depth="(depth || 0) + 1"
      />
      </li>
    </ul>
  </template>
  
  <script>
  export default {
    props: {
      pages: Array,
      depth: {
        type: Number,
        default: 0,
      },
    },
  };
  </script>
  
  <style scoped>
  /* Style list items */
  ul {
    list-style: none;
    padding-left: 1rem;
  }
  
  /* Add indentation based on depth */
  li {
    padding-left: calc(1rem * var(--depth));
  }
  
  li > div {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  li > div span {
    font-size: 1rem;
    font-weight: 500;
  }
  </style>
  

