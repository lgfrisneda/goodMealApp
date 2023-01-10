<template>
    <div class="container">
        <div class="text-center py-2 border-bottom border-2 bg-white sticky-top">
            <div class="d-flex bd-highlight">
                <div class="p-2 bd-highlight">
                    <Link class="btn btn-sm btn-light" :href="route('shops.show', shop.id)">
                        <i class="fa-solid fa-arrow-left fa-2x"></i>
                    </Link>
                </div>
                <div class="me-auto p-2 bd-highlight w-100">
                    <h3 class="fw-bolder">
                        Carrito de compras
                    </h3>
                </div>
            </div>
        </div>
        <div class="my-2">
            <div class="card text-dark shadow bg-body rounded">
                <div class="pt-0 card-header d-flex justify-content-between bg-white border-0 pb-0">
                    <h5 class="pt-2 card-title fw-bolder mb-0 d-inline">{{ shop.name }}</h5>
                </div>
                <div class="card-body pt-0">
                    <span class="d-block">Direccion: {{ shop.address }}</span>
                    <hr>
                    <span class="d-block">Productos</span>
                    <div class="row" v-for="(product, index) in myCart" :key="index">
                        <div class="col-3">
                            {{ product.quantity }}
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <button type="button" @click="editToCart(index, 'add')" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                                <button v-show="product.quantity > 1" type="button" @click="editToCart(index, 'remove')" class="btn btn-sm btn-outline-secondary">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-5">
                            {{ product.product_name }}
                        </div>
                        <div class="col text-end me-2">
                            {{`$${product.amount}`}}
                            <button type="button" @click="removeElementToCart(index)" class="btn btn-sm btn-outline-danger">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
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
                    <div class="row">
                        <div class="col">
                            Monto total
                        </div>
                        <div class="col text-end me-2">
                            {{ `$${twoDecimals(this.amount_total)}` }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-grid gap-2">
                            <button class="btn btn-success" type="button" @click="this.$inertia.post(route('orders.generate'))">Pagar</button>
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
    props: ['myCart', 'shop'],
    mounted(){
        if(this.shop.delivery){
            this.amount_delivery = this.calculateDelivery();
        }
        this.amount_total = this.calculateTotal();
    },
    methods: {
        calculateTotalProducts() {
            var total = 0;
            for (const [key, value] of Object.entries(this.myCart)) {
                total += value.amount;
            }

            return total;
        },
        calculateDelivery(){
            return (this.shop.delivery.percent/100) * this.calculateTotalProducts(this.myCart)
        },
        calculateTotal(){
            return this.calculateTotalProducts() + this.amount_delivery
        },
        discount(product){
            var amount_discount = (product.discount_percent/100) * product.price;
            return product.price - amount_discount;
        },
        editToCart(productId, option){
            this.$inertia.patch(route('shoppingCart.update'), {
                option,
                productId
            }, {
                onSuccess: () => {
                    this.amount_delivery = this.calculateDelivery() ?? 0;
                    this.amount_total = this.calculateTotal();
                }
            });
        },
        removeElementToCart(productId){
            this.$inertia.delete(route('shoppingCart.remove', {productId}), {
                onSuccess: () => {
                    this.amount_delivery = this.calculateDelivery() ?? 0;
                    this.amount_total = this.calculateTotal();
                }
            });
        }
    }

})
</script>