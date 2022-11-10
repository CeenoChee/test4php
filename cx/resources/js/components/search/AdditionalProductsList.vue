<template>
<div
    v-if="getAdditionalProducts.length != 0"
    class="additional-section text-center"
>
    <div class="additional-title-row">
        <p class="additional-title uppercase text-xs mt-8 mb-4 text-left font-semibold">
            {{ title }}
        </p>
    </div>
    <div class="additional-product-list grid grid-cols-3 lg:grid-cols-5 gap-4">
        <div
            v-for="product in getAdditionalProducts"
            :key="product.Termek_ID"
            class="additional-product"
        >
            <additional-product
                :product="product"
                :locale="locale"
            />
        </div>
    </div>
</div>
</template>

<script>
import AdditionalProduct from './AdditionalProduct';

export default {
    name: 'AdditionalProductsList',
    components: {
        AdditionalProduct,
    },
    props: {
        locale: {
            type: String,
            required: true,
        },
        title: {
            type: String,
            required: false,
            default: '',
        },
        filteredProducts: {
            type: Array,
            required: false,
            default: function () {
                return [];
            },
        },
        products: {
            type: Array,
            required: false,
            default: function () {
                return [];
            },
        },
    },
    computed: {
        getAdditionalProductsID() {
            return this.flatten(this.filteredProducts);
        },
        getAdditionalProducts() {
            return this.filteredAdditionalProducts(this.getAdditionalProductsID).slice(0, 8);
        },
    },
    methods: {
        flatten(arr) {
            var flat = [];
            for (var i = 0; i < arr.length; i++) {
                flat = flat.concat(arr[i].KiegeszitoTermek_IDS);
            }
            return flat;
        },
        filteredAdditionalProducts(ids) {
            return this.products.filter(product => ids.includes(product.Termek_ID.toString()));
        },
    },
}
</script>
