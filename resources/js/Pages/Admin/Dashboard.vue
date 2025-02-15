<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <p>Welcome, {{ user.name }}</p>
    </AdminLayout>
</template>

<script>
import { usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

export default {
    components: { AdminLayout },
    setup() {
        const page = usePage();
        return { user: page.props.auth.user };
    }
};
</script>
