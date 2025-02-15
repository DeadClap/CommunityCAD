<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold mb-4">Manage Roles</h1>

        <!-- Create New Role -->
        <form @submit.prevent="createRole" class="flex items-center space-x-2 mb-6">
            <input 
                v-model="roleName" 
                placeholder="New Role" 
                class="border p-2 rounded-md w-1/3 focus:ring focus:ring-blue-300"
            >
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Create Role
            </button>
        </form>

        <!-- List of Roles -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="role in roles" :key="role.id" class="bg-white shadow-md rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-lg">{{ role.name }}</h3>
                    <button 
                        @click="openDeleteModal(role.id)" 
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                    >
                        Delete
                    </button>
                </div>

                <!-- Permissions -->
                <div class="mt-2">
                    <label v-for="permission in permissions" :key="permission.id" class="block">
                        <input 
                            type="checkbox"
                            :checked="selectedPermissions[role.id]?.includes(permission.name)"
                            @change="togglePermission(role.id, permission.name)"
                            class="mr-2"
                        >
                        {{ permission.name }}
                    </label>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
                <p>Are you sure you want to delete this role? This action cannot be undone.</p>
                <div class="flex justify-end space-x-2 mt-4">
                    <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                        Cancel
                    </button>
                    <button @click="deleteRole" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Delete
                    </button>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

export default {
    components: { AdminLayout },
    props: ['roles', 'permissions'],
    setup(props) {
        const roleName = ref("");
        const selectedPermissions = ref({});
        const showDeleteModal = ref(false);
        const roleToDelete = ref(null);

        // Preload assigned permissions per role
        const initializePermissions = () => {
            props.roles.forEach(role => {
                selectedPermissions.value[role.id] = role.permissions.map(p => p.name);
            });
        };

        onMounted(() => {
            initializePermissions();
        });

        const createRole = () => {
            router.post('/admin/roles', { name: roleName.value });
        };

        const togglePermission = (roleId, permission) => {
            const currentPermissions = selectedPermissions.value[roleId] || [];
            if (currentPermissions.includes(permission)) {
                selectedPermissions.value[roleId] = currentPermissions.filter(p => p !== permission);
            } else {
                selectedPermissions.value[roleId].push(permission);
            }
            updatePermissions(roleId);
        };

        const updatePermissions = (roleId) => {
            router.put(`/admin/roles/${roleId}/permissions`, {
                permissions: selectedPermissions.value[roleId]
            });
        };

        const openDeleteModal = (roleId) => {
            roleToDelete.value = roleId;
            showDeleteModal.value = true;
        };

        const deleteRole = () => {
            if (roleToDelete.value) {
                router.delete(`/admin/roles/${roleToDelete.value}`);
                showDeleteModal.value = false;
                roleToDelete.value = null;
            }
        };

        return { 
            roleName, 
            createRole, 
            selectedPermissions, 
            togglePermission, 
            showDeleteModal, 
            openDeleteModal, 
            deleteRole 
        };
    }
};
</script>
