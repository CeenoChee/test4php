<template>
<div class="search-prod grid grid-cols-2 lg:grid-cols-3 gap-4 text-gray-500">
    <div
        v-for="product in filteredProducts"
        :key="product.Termek_ID"
    >
        <search-product
            :product="product"
            :locale="locale"
            :rielactive="rielactive"
            :trans="trans"
            :keyword="keyword"
        />
    </div>
</div>
</template>

<script>
import SearchProduct from './SearchProduct';

export default {
    name: 'SearchProductsList',
    components: {
        SearchProduct,
    },
    props: {
        filteredProducts: {
            type: Array,
            required: false,
            default: function () {
                return []
            },
        },
        locale: {
            type: String,
            required: true,
        },
        rielactive: {
            type: String,
            required: true,
        },
        trans: {
            type: Object,
            required: false,
            default: function () {
                return {}
            },
        },
        keyword: {
            type: String,
            required: false,
            default: '',
        },
    },
}
</script>
