<template>
  <div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div v-if="!pageNotFound.value" class="bg-white p-6 rounded-lg shadow-md max-w-4xl w-full">
      <h1 class="text-3xl font-bold text-gray-800 text-center mb-4">
        Page-title: {{ page.title }}
      </h1>

      <h1 class="text-3xl font-bold text-gray-800 text-center mb-4">
        Page-slug: {{ page.slug }}
      </h1>

      <p class="text-lg text-gray-600 text-center mb-6">
        Page-content: {{ page.content }}
      </p>

      <div v-if="page.children && page.children.length > 0">
        <h2 class="text-2xl font-semibold text-gray-700 text-center mb-4">
          Subpages
        </h2>
        <ul class="space-y-4">
          <li v-for="child in page.children" :key="child.id"
            class="bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transform transition-all duration-300 ease-in-out hover:scale-105">
            <router-link :to="'/' + child.slug" class="text-lg font-medium text-blue-600 hover:text-blue-800">
              {{ child.title }}
            </router-link>

            <div v-if="child.children && child.children.length > 0" class="mt-4 pl-4 border-l-4 border-blue-500">
              <ul class="space-y-2">
                <li v-for="subChild in child.children" :key="subChild.id" class="text-blue-500 hover:text-blue-700">
                  <router-link :to="'/' + subChild.slug">{{ subChild.title }}</router-link>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div v-if="pageNotFound.value" class="bg-red-100 p-6 rounded-lg shadow-md max-w-4xl w-full text-center">
      <h1 class="text-3xl font-bold text-red-600">Page Not Found</h1>
      <p class="text-lg text-gray-600">{{ pageNotFound.message }}</p>
    </div>
  </div>
</template>


<script setup>
import { reactive, onMounted } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const page = reactive({
  title: "",
  content: "",
  children: [],
});

const pageNotFound = reactive({
  value: false,
  message: "",
});

const fetchPage = async () => {
  try {
    const slug = Array.isArray(route.params.slug)
      ? route.params.slug.join("/")
      : route.params.slug;

    // Fetch data content of page by the below route
    const response = await fetch(`/api/${slug}`);
    if (response.ok) {
      const data = await response.json();
      page.title = data.title;
      page.slug = data.slug;
      page.content = data.content;
      page.children = data.children;
      pageNotFound.value = false;
    } else {
      pageNotFound.value = true;
      pageNotFound.message = "Page not found"; // Setting the error message here
    }
  } catch (error) {
    pageNotFound.value = true;
    pageNotFound.message = "An error occurred while fetching the page"; // Setting the error message here
    console.error("Error fetching page:", error);
  }
};

onMounted(() => {
  fetchPage();
});
</script>


<!-- added custom styles for view here -->
<style scoped>
*,
*::before,
*::after {
  box-sizing: border-box;
}

body {
  font-family: 'Arial', sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f7fafc;
}

.flex {
  display: flex;
}

.justify-center {
  justify-content: center;
}

.items-center {
  align-items: center;
}

.min-h-screen {
  min-height: 100vh;
}

.bg-white {
  background-color: #ffffff;
}

.p-6 {
  padding: 1.5rem;
}

.rounded-lg {
  border-radius: 0.5rem;
}

.shadow-md {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.max-w-4xl {
  max-width: 800px;
}

.w-full {
  width: 100%;
}


.text-3xl {
  font-size: 1.875rem;
}

.font-bold {
  font-weight: 700;
}

.text-gray-800 {
  color: #2d3748;
}

.text-center {
  text-align: center;
}

.mb-4 {
  margin-bottom: 1rem;
}


.text-lg {
  font-size: 1.125rem;
}

.text-gray-600 {
  color: #718096;
}

.mb-6 {
  margin-bottom: 1.5rem;
}


.space-y-4 {
  margin-top: 1rem;
  margin-bottom: 1rem;
}

.space-y-2 {
  margin-top: 0.5rem;
  margin-bottom: 0.5rem;
}

.bg-gray-50 {
  background-color: #f9fafb;
}

.p-4 {
  padding: 1rem;
}

.rounded-lg {
  border-radius: 0.5rem;
}

.shadow-sm {
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.hover\:shadow-md:hover {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.transform {
  transition: all 0.3s ease-in-out;
}

.hover\:scale-105:hover {
  transform: scale(1.05);
}

.text-blue-600 {
  color: #3182ce;
}

.hover\:text-blue-800:hover {
  color: #2b6cb0;
}

.transition-colors {
  transition: color 0.3s ease-in-out;
}

.text-blue-500 {
  color: #3b82f6;
}

.hover\:text-blue-700:hover {
  color: #2563eb;
}

/* Nested child list styling */
.pl-4 {
  padding-left: 1rem;
}

.border-l-4 {
  border-left-width: 4px;
}

.border-blue-500 {
  border-color: #3b82f6;
}

@media (max-width: 768px) {
  .max-w-4xl {
    max-width: 100%;
    padding-left: 1rem;
    padding-right: 1rem;
  }

  .text-3xl {
    font-size: 1.5rem;
  }

  .text-lg {
    font-size: 1rem;
  }

  .space-y-4 {
    margin-top: 1rem;
    margin-bottom: 1rem;
  }

  .mb-6 {
    margin-bottom: 1.25rem;
  }

  .mb-4 {
    margin-bottom: 0.75rem;
  }
}
</style>
