<template>
    <div class="text-center py-2 border-bottom border-2 bg-white sticky-top">
        <div class="d-flex bd-highlight">
            <div class="p-2 bd-highlight">
                <Link :href="route('orders.myOrders')" class="btn btn-sm btn-light">
                    <i class="fa-solid fa-arrow-left fa-2x"></i>
                </Link>
            </div>
            <div class="me-auto p-2 bd-highlight w-100">
                <h3 class="fw-bolder">
                    Detalle de la orden
                </h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="my-2">
            <div class="card text-dark shadow bg-body rounded">
                <div class="pt-0 card-header d-flex justify-content-between bg-white border-0 pb-0">
                    <h5 class="pt-2 card-title fw-bolder mb-0 d-inline">{{ myOrder.shop.name }}</h5>
                    <span class="badge bg-blue-sea text-white rounded-0 rounded-bottom mb-2">Rescatada</span>
                </div>
                <div class="card-body pt-0">
                    <div class="d-block"><span class="fw-bolder">Direccion:</span> {{ myOrder.shop.address }}</div>
                    <div class="d-block"><span class="fw-bolder">Horario de retiro:</span>  09:00 a 16:00 hrs</div>
                    <div class="d-block"><span class="fw-bolder">Fecha de retiro:</span>  {{ moment(myOrder.created_at).format("DD/MM/YY") }}</div>
                    <div class="d-block"><span class="fw-bolder">N° de orden:</span>  {{ myOrder.id }}</div>
                    <hr>
                    <span class="d-block fw-bolder">Productos</span>
                    <div class="row" v-for="detail in myOrder.details" :key="detail.id">
                        <div class="col-2">
                            {{ detail.quantity }}
                        </div>
                        <div class="col-6">
                            {{ detail.product_name }}
                        </div>
                        <div class="col text-end me-2">
                            {{`$${detail.amount}`}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            Delivery
                        </div>
                        <div class="col text-end me-2">
                            {{ `$${twoDecimals(this.amount_delivery)}` }}
                        </div>
                    </div>
                    <div class="row fw-bolder">
                        <div class="col">
                            Monto total
                        </div>
                        <div class="col text-end me-2">
                            {{ `$${twoDecimals(this.amount_total)}` }}
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
import moment from 'moment';

export default defineComponent({
    layout:Template,
    components: {
        Link,
        JetNavLink,
    },
    data() {
        return {
            moment: moment,
            amount_delivery: 0,
            amount_total: 0
        }
    },
    props: ['myOrder'],
    mounted(){
        if(this.myOrder.shop.delivery){
            this.amount_delivery = this.calculateDelivery();
        }
        this.amount_total = this.calculateTotal();

        if (!Object.values(this.$page.props.messages).every(element => element === null)) {
            let to_toast = Object.entries(this.$page.props.messages).find(([key, value]) => value !== null);
            this.$toast.open({
                message: to_toast[1],
                type: to_toast[0],
            });
        }
    },
    methods: {
        calculateTotalProducts() {
            var total = 0;
            this.myOrder.details.map((item) => {
                if (item.amount){
                    total += item.amount;
                }
            });

            return total;
        },
        calculateDelivery(){
            return (this.myOrder.shop.delivery.percent/100) * this.calculateTotalProducts(this.myOrder.details)
        },
        calculateTotal(){
            return this.calculateTotalProducts() + this.amount_delivery
        }
    }

})
</script>