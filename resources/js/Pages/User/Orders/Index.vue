<template>
    <div class="container">
        <div class="text-center py-2 border-bottom border-2 bg-white sticky-top">
            <div class="d-flex bd-highlight">
                <div class="me-auto p-2 bd-highlight w-100">
                    <h3 class="fw-bolder">
                        Mis Ordenes
                    </h3>
                </div>
                <div class="p-2 bd-highlight">
                    <button type="button" class="btn btn-sm btn-light">
                        <i class="fa-solid fa-headset fa-2x"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="my-2 row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <div class="col" v-for="order in myOrders" :key="order.id">
                <div class="card text-dark shadow bg-body rounded">
                    <div class="pt-0 card-header d-flex justify-content-between bg-white border-0 pb-0">
                        <h5 class="pt-2 card-title fw-bolder mb-0 d-inline">{{ moment(order.created_at).format("DD/MM/YY") }}</h5>
                        <span class="badge bg-info text-white pt-2">Rescatada</span>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row row-cols-2">
                            <div class="col">
                                <span class="d-block">Tienda: {{ order.shop.name }}</span>
                                <span class="d-block">N° de orden: {{ order.id }}</span>
                                <span class="d-block">Monto total: {{ twoDecimals(calculateTotal(order)) }}</span>
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
        calculateTotal(order) {
            var total_products = 0;
            order.details.map((item) => {
                if (item.amount){
                    total_products += item.amount;
                }
            });

            var delivery = (order.shop.delivery)? (order.shop.delivery.percent/100) * total_products: 0;

            return total_products + delivery;
        },
    }

})
</script>