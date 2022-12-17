<template>
    <ul class="nav d-flex justify-content-between py-2 border-bottom border-2 bg-white sticky-bottom">
        <jet-nav-link :href="route('shops.index')" :active="route().current('shops.index')" :class="'text-center'">
            <span class="text-dark">
                <i class="fa-sharp fa-solid fa-house d-block fa-2x"></i>
                Inicio
            </span>
        </jet-nav-link>
        <jet-nav-link :href="route('orders.myOrders')" :active="route().current('orders.myOrders')" :class="'text-center'">
            <span class="text-dark">
                <i class="fa-solid fa-file-lines d-block fa-2x"></i>
                Ordenes
            </span>
        </jet-nav-link>
        <jet-dropdown id="settingsDropdown" :class="'text-center'">
            <template #trigger>
                <span class="text-dark">
                    <i class="fa-regular fa-user d-block fa-2x"></i>
                    Usuario
                </span>
            </template>

            <template #content>
            <!-- Authentication -->
            <form @submit.prevent="logout">
                <jet-dropdown-link as="button">
                    Log out
                </jet-dropdown-link>
            </form>
            </template>
        </jet-dropdown>
    </ul>
</template>
<script>
import { defineComponent } from 'vue'
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue'

export default defineComponent({
    components: {
        JetNavLink,
        JetDropdown,
        JetDropdownLink,
    },
    setup() {
        
    },
    methods: {
        switchToTeam(team) {
            this.$inertia.put(route('current-team.update'), {
                'team_id': team.id
            }, {
                preserveState: false
            })
        },

        logout() {
            this.$inertia.post(route('logout'));
        },
    },
})
</script>
