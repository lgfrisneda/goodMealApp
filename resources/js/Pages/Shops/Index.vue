<template>
    <div class="">
        <div class="sticky-top bg-white">
            <div class="d-flex bd-highlight">
                <div class="me-auto p-2 bd-highlight">
                    <h3 class="fw-bolder">
                        <i class="fa-sharp fa-solid fa-location-dot fa-lg"></i> Ubicacion
                    </h3>
                </div>
                <div class="p-2 bd-highlight">
                    <button type="button" class="btn btn-sm btn-light">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
                <div class="p-2 bd-highlight">
                    <button type="button" class="btn btn-sm btn-light bg-pink-light pink-official">
                        <i class="fa-solid fa-sliders"></i>
                    </button>
                </div>
            </div>
            <ul class="nav d-flex justify-content-between py-2 border-bottom border-2">
                <jet-nav-link :href="route('shops.index')" :active="route().current('shops.index')">
                    <span class="pink-official">
                        Con Stock
                    </span>
                </jet-nav-link>
                <jet-nav-link :href="route('shops.index')" :active="route().current('shops.index')">
                    <span class="text-dark">
                        Sin Stock
                    </span>
                </jet-nav-link>
                <jet-nav-link :href="route('shops.index')" :active="route().current('shops.index')">
                    <span class="text-dark">
                        Favoritos
                    </span>
                </jet-nav-link>
            </ul>
        </div>
        <div class="my-2 row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <div class="col" v-for="shop in shops" :key="shop.id">
                <div class="card text-dark shadow bg-body rounded">
                    <div class="d-flex justify-content-end">
                        <div class="position-absolute me-3">
                            <i class="fa-solid fa-bookmark fa-3x text-secondary"></i>
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="bi bi-bookmark-heart-fill" viewBox="0 0 16 16">
                                <path d="M2 15.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v13.5zM8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z"/>
                            </svg> -->
                        </div>
                    </div>
                    <img src="https://picsum.photos/600/300" class="card-img-top" style="height: 90px;" alt="#">
                    <div class="card-img-overlay" style="height: 90px;">
                        <h5><span class="badge rounded-pill bg-pink">Hoy 09:00 - 19:00 hrs</span></h5>
                        <h5><span class="badge rounded-pill bg-pink-light pink-official">{{ (shop.options == 'both')? 'pick-up o delivery': shop.options}}</span></h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="position-absolute d-flex justify-content-end me-4">
                            <img class="rounded-circle border border-white border-1 w-25" :src="shop.image" :alt="shop.name">
                        </div>
                    </div>
                    <div class="card-body h-50 pb-0">
                        <h5 class="card-title fw-bolder mb-0 w-75">{{ shop.name }}</h5>
                        <p class="card-text fw-bolder pink-official">Desde</p>
                    </div>
                    <div class="card-footer bg-white pt-1">
                        <div class="row">
                            <div class="col">
                                <i class="fa-solid fa-person-walking fa-lg"></i>
                                Time
                            </div>
                            <div class="col">
                                <i class="fa-sharp fa-solid fa-location-dot fa-lg"></i>
                                distance
                            </div>
                            <div class="col-4 text-end">
                                <Link :href="route('shops.show', shop)" class="text-decoration-none text-dark">
                                    <h4 class="fw-bolder d-inline me-2">{{ shop.products.length }}</h4>
                                    <i class="fa-solid fa-bag-shopping fa-2x"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import JetNavLink from '@/Jetstream/NavLink.vue'
import Template from '@/Layouts/Template.vue'

export default defineComponent({
    layout:Template,
    components: {
        Link,
        JetNavLink        
    },
    props: ['shops'],

})
</script>