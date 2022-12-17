<template>
    <div class="container">
        <div class="text-center py-2 border-bottom border-2 bg-white sticky-top">
            <h3 class="fw-bolder">
                Mis Ordenes
            </h3>
        </div>
        <div class="my-3 row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <div class="col" v-for="order in myOrders" :key="order.id">
                <div class="card text-dark shadow bg-body rounded">
                    <div class="card-header d-flex justify-content-between bg-white border-0 pb-0">
                        <h5 class="card-title fw-bolder mb-0 d-inline">{{ moment(order.created_at).format("DD/MM/YY") }}</h5>
                        <span class="badge bg-info text-white">Rescatada</span>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row row-cols-2">
                            <div class="col">
                                <span class="d-block">Tienda: {{ order.shop.name }}</span>
                                <span class="d-block">N° de orden: {{ order.id }}</span>
                                <span class="d-block">Monto total: {{ calculateTotal(order.details) }}</span>
                                <span class="d-block">Horario: 09:00 a 16:00</span>
                            </div>
                            <div class="col text-end mt-4">
                                <Link :href="route('orders.show', order)" class="btn btn-sm btn-light">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <menu-footer/>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import JetNavLink from '@/Jetstream/NavLink.vue'
import MenuFooter from '@/components/MenuFooter.vue'
import moment from 'moment';

export default defineComponent({
    components: {
        Link,
        JetNavLink,
        MenuFooter,
    },
    data() {
        return {
            moment: moment
        }
    },
    props: ['myOrders'],
    methods: {
        calculateTotal(products) {
            var total = 0;
            products.map((item) => {
                if (item.amount){
                    total += item.amount;
                }
            });

            return total;
        },
    }

})
</script>