<template>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white p-5 space-y-6">
            <h2 class="text-xl font-bold">Admin Panel</h2>
            <nav>
                <inertia-link class="block py-2 hover:bg-gray-700" href="/admin">Dashboard</inertia-link>
                <inertia-link v-if="userHasPermission('manage users')" class="block py-2 hover:bg-gray-700" href="/admin/users">Users</inertia-link>
                <inertia-link v-if="userHasPermission('manage roles')" class="block py-2 hover:bg-gray-700" href="/admin/roles">Roles</inertia-link>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <slot />
        </main>
    </div>
</template>

<script>
import { usePage } from '@inertiajs/vue3';

export default {
    setup() {
        const page = usePage();
        const userHasPermission = (permission) => {
            return page.props.auth.user.permissions.includes(permission);
        };
        return { userHasPermission };
    }
};
</script>
