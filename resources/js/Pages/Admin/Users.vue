<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold">Manage Users</h1>
        <table class="w-full mt-4 bg-white shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Role</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td class="p-2">{{ user.name }}</td>
                    <td class="p-2">{{ user.email }}</td>
                    <td class="p-2">{{ user.roles[0]?.name || 'No Role' }}</td>
                </tr>
            </tbody>
        </table>
    </AdminLayout>
</template>

<script>
import { defineProps } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

export default {
    components: { AdminLayout },
    props: ['users']
};
</script>
