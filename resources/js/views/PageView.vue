<template>
    <div class="p-6 max-w-4xl mx-auto">
      <h1 class="text-3xl font-bold mb-4">{{ page.title }}</h1>
      <p class="text-lg">{{ page.content }}</p>
  
      <!-- Render nested pages (children) -->
      <div v-if="page.children.length > 0" class="ml-4 mt-4">
        <h2 class="text-2xl font-semibold">Subpages:</h2>
        <ul>
          <li v-for="child in page.children" :key="child.id">
            <router-link :to="'/' + child.slug">{{ child.title }}</router-link>
            <div v-if="child.children.length > 0" class="ml-4">
              <ul>
                <li v-for="subChild in child.children" :key="subChild.id">
                  <router-link :to="'/' + subChild.slug">{{ subChild.title }}</router-link>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import { reactive, onMounted } from 'vue';
  import { useRoute } from 'vue-router';
  
  export default {
    name: 'PageView',
    setup() {
      const route = useRoute();
      const page = reactive({
        title: '',
        content: '',
        children: []
      });
  
      const fetchPage = async () => {
        try {
          const response = await fetch(`/${route.params.slug}`);
          if (response.ok) {
            const data = await response.json();
            page.title = data.title;
            page.content = data.content;
            page.children = data.children;  // Set children pages
          } else {
            console.error('Page not found');
          }
        } catch (error) {
          console.error('Error fetching page:', error);
        }
      };
  
      onMounted(() => {
        fetchPage();
      });
  
      return { page };
    },
  };
  </script>
  