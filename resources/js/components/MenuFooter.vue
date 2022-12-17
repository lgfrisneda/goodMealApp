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
            <jet-nav-link href="#" :class="'text-center'">
                <span class="text-dark">
                    <i class="fa-regular fa-user d-block fa-2x"></i>
                    Usuario
                </span>
            </jet-nav-link>
        </ul>
</template>
<script>
import { defineComponent } from 'vue'
import JetNavLink from '@/Jetstream/NavLink.vue'

export default defineComponent({
    components: {
        JetNavLink,
    },
    setup() {
        
    },
})
</script>
