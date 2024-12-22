<template>
  <div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-4">Page Management</h1>

    <!-- Create/Edit Form -->
    <div class="mb-6 border p-4 rounded bg-gray-50">
      <h2 class="text-xl font-semibold mb-2">{{ isEdit ? 'Edit Page' : 'Create Page' }}</h2>
      <form @submit.prevent="savePage">
        <div class="mb-4">
          <label class="block font-medium mb-1">
            Parent Page
          </label>
          <select v-model="form.parent_id" class="w-full border px-3 py-2 rounded">
            <option value="">Root</option>
            <option v-for="page in flatPages" :key="page.id" :value="page.id">
              {{ page.title }}
            </option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block font-medium mb-1">
            Title <span class="text-red-500">*</span>
          </label>
          <input
            v-model="form.title"
            type="text"
            class="w-full border px-3 py-2 rounded"
            :class="{'border-red-500': errors.title}"
            @input="clearError('title')"
          />
          <p v-if="errors.title" class="text-red-500 text-sm">{{ errors.title }}</p>
        </div>

        <div class="mb-4">
          <label class="block font-medium mb-1">
            Slug <span class="text-red-500">*</span>
          </label>
          <input
            v-model="form.slug"
            type="text"
            class="w-full border px-3 py-2 rounded"
            :class="{'border-red-500': errors.slug}"
            @input="clearError('slug')"
          />
          <p v-if="errors.slug" class="text-red-500 text-sm">{{ errors.slug }}</p>
        </div>

        <div class="mb-4">
          <label class="block font-medium mb-1">
            Content <span class="text-red-500">*</span>
          </label>
          <textarea
            v-model="form.content"
            rows="4"
            class="w-full border px-3 py-2 rounded"
            :class="{'border-red-500': errors.content}"
            @input="clearError('content')"
          ></textarea>
          <p v-if="errors.content" class="text-red-500 text-sm">{{ errors.content }}</p>
        </div>

        <button
          type="submit"
          class="bg-blue-500 text-white px-4 py-2 rounded"
        >
          {{ isEdit ? 'Update' : 'Create' }}
        </button>
        <button
          v-if="isEdit"
          @click="resetForm"
          type="button"
          class="bg-gray-500 text-white px-4 py-2 rounded ml-2"
        >
          Cancel
        </button>
      </form>
    </div>

    <!-- Page List -->
    <div>
      <h2 class="text-xl font-semibold mb-2">Page List</h2>
      <ul class="border p-4 rounded bg-gray-50">
        <TreeView :pages="pages" @edit="editPage" @delete="deletePage" />
      </ul>
    </div>
  </div>
</template>


<script>
import { ref, reactive, onMounted, computed } from "vue";
import axios from "axios";
import TreeView from "../../components/TreeView.vue";

export default {
  name: 'PageManager',
  components: {
    TreeView,
  },
  setup() {
    const pages = ref([]);
    const form = reactive({
      parent_id: null,
      title: "",
      slug: "",
      content: "",
    });
    const isEdit = ref(false);
    const editId = ref(null);
    const errors = reactive({
      title: "",
      slug: "",
      content: "",
    });

    // Fetch pages
    const fetchPages = () => {
      axios.get("/api/pages")
        .then((res) => {
          pages.value = res.data;
        })
        .catch((error) => {
          console.error("Error fetching pages:", error);
        });
    };

    // Validation function
    const validateForm = () => {
      errors.title = form.title.trim() === "" ? "Title is required" : "";
      errors.slug = form.slug.trim() === "" ? "Slug is required" : "";
      errors.content = form.content.trim() === "" ? "Content is required" : "";

      return !Object.values(errors).some((error) => error !== "");
    };

    // Save page (create or update)
    const savePage = () => {
      if (!validateForm()) return; // Stop if validation fails

      const url = isEdit.value ? `/api/pages/${editId.value}` : "/api/pages";
      const method = isEdit.value ? "put" : "post";

      axios[method](url, form)
        .then(() => {
          fetchPages();
          resetForm();
        })
        .catch((error) => {
          console.error("Error saving page:", error);
        });
    };

    // Edit page (set form for editing)
    const editPage = (page) => {
      isEdit.value = true;
      editId.value = page.id;
      form.parent_id = page.parent_id || null;
      form.title = page.title;
      form.slug = page.slug;
      form.content = page.content;
      errors.title = "";
      errors.slug = "";
      errors.content = "";
    };

    // Delete page
    const deletePage = (id) => {
      if (confirm("Are you sure you want to delete this page?")) {
        axios.delete(`/api/pages/${id}`)
          .then(() => {
            fetchPages();
          })
          .catch((error) => {
            console.error("Error deleting page:", error);
          });
      }
    };

    // Reset form (clear editing state)
    const resetForm = () => {
      isEdit.value = false;
      editId.value = null;
      form.parent_id = null;
      form.title = "";
      form.slug = "";
      form.content = "";
      errors.title = "";
      errors.slug = "";
      errors.content = "";
    };

    // Flatten pages for the parent dropdown
    const flattenPages = (pages, parentId = null, prefix = '') => {
      let flatPages = [];
      pages.forEach(page => {
        const flattenedPage = { ...page, title: prefix + page.title };
        flatPages.push(flattenedPage);
        if (page.children && page.children.length > 0) {
          flatPages = flatPages.concat(flattenPages(page.children, page.id, prefix + '— '));
        }
      });
      return flatPages;
    };

    // Computed property to get flattened pages
    const flatPages = computed(() => flattenPages(pages.value));

    // Clear error when the user starts typing
    const clearError = (field) => {
      errors[field] = "";
    };

    // Lifecycle hooks
    onMounted(() => {
      fetchPages();
    });

    return {
      pages,
      form,
      isEdit,
      editId,
      fetchPages,
      savePage,
      editPage,
      deletePage,
      resetForm,
      flatPages, // Make flattened pages available to the template
      errors, // Expose errors for use in the template
      clearError, // Expose clearError function
    };
  },
};

</script>

<style scoped>
/* Add any additional styling here */
</style>
