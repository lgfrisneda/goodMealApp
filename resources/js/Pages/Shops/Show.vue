<template>
    <div class="container bg-white">
        <div class="row">
            <div class="col-12">
                <div class="mb-2">
                    <div class="relative mb-5">
                        <img class="w-100" src="https://picsum.photos/700/300" alt="Shop banner" style="max-height:300px;">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="position-absolute d-flex justify-content-end me-4">
                                <img class="rounded-circle border border-white border-1 w-50" :src="shop.image" :alt="shop.name">
                            </div>
                        </div>
                        <div class="py-4 w-50">
                            <h3 class="fw-bolder">Acerca de la tienda</h3>
                            <div>
                                <i class="fa-sharp fa-solid fa-location-dot fa-lg"></i>
                                {{ shop.address }}
                            </div>
                            <div>
                                <i class="fa-solid fa-clock fa-lg"></i>
                                Hora de retiro: Hoy de 09:00 a 21:00 hrs
                            </div>
                            <div>
                                <span class="fw-bolder">Calificacion: </span>
                                <i class="fa-solid fa-star fa-lg"></i>
                                4.4 / 5.0
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="nav d-flex justify-content-between py-2 border-bottom border-2">
            <jet-nav-link href="#" active="#">
                <span class="text-dark">
                    Ver todo
                </span>
            </jet-nav-link>
            <jet-nav-link href="#" active="#">
                <span class="text-dark">
                    Snacks
                </span>
            </jet-nav-link>
            <jet-nav-link href="#" active="#">
                <span class="text-dark">
                    Lácteos y quesos
                </span>
            </jet-nav-link>
            <jet-nav-link href="#" active="#">
                <span class="text-dark">
                    Congelados
                </span>
            </jet-nav-link>
        </ul>
        <div class="my-2 row row-cols-1 row-cols-sm-3 row-cols-md-3 g-4">
            <div class="col" v-for="product in shop.products" :key="product.id">
                <div class="card h-100 shadow bg-body rounded">
                    <div class="card-header border-0 bg-white text-center">
                        <img :src="product.image" class="card-img-top rounded-4 w-75" :alt="product.name">
                        <div class="card-img-overlay h-25">
                            <div class="d-flex justify-content-end">
                                <div class="position-absolute d-flex justify-content-end">
                                    <button type="button" @click="addToCart(product)" class="bg-white border border-2 border-danger btn btn-sm btn-link rounded-circle text-decoration-none">
                                        <i class="fa-solid fa-plus fa-2x text-danger"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-title text-center fw-bolder">
                            <h5 class="fw-bolder d-inline me-2">{{`$${this.twoDecimals(this.discount(product))}` }}</h5>
                            <h5 class="text-secondary d-inline text-decoration-line-through">{{`$${this.twoDecimals(product.price)}` }}</h5>
                        </div>
                        <p class="text-center">
                            <span class="badge bg-secondary">{{`${product.discount_percent}% dcto`}}</span>
                        </p>
                        <p class="card-text">
                            <span class="d-block">{{ product.name }}</span>
                            {{ product.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <ul class="text-center py-4 sticky-bottom bg-white">
            <div v-if="!myCart" class="text-muted">
                Agrega algun producto a tu carrito de compras
            </div>
            <Link href="#" class="btn btn-outline-primary btn-lg" v-else @click="this.$inertia.get(route('shoppingCart.show'))">
                Ir al carrito de compras
            </Link>
        </ul>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import JetNavLink from '@/Jetstream/NavLink.vue'
import MenuFooter from '@/components/MenuFooter.vue'

export default defineComponent({
    components: {
        Link,
        JetNavLink,
        MenuFooter,
    },
    props: ['shop', 'myCart'],
    methods: {
        discount(product){
            var amount_discount = (product.discount_percent/100) * product.price;
            return product.price - amount_discount;
        },
        addToCart(product){
            var amount_discount = this.twoDecimals(this.discount(product));
            this.$inertia.post(route('shoppingCart.add', product), {
                amount_discount: amount_discount
            });
        }
    }

})
</script>