<template>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">{{ page.title }}</h1>
        <p class="text-lg">{{ page.content }}</p>
    </div>
</template>

<script>
import { reactive, onMounted } from 'vue';
import { useRoute } from 'vue-router';

export default {
    name: 'PageView',
    setup() {
        const route = useRoute();
        const page = reactive({ title: '', content: '' });

        const fetchPage = async () => {
            try {
                const response = await fetch(`/${route.params.slug}`);
                if (response.ok) {
                    Object.assign(page, await response.json());
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
