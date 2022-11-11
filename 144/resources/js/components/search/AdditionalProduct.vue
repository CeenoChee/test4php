<template>
<div class="product-info">
    <a
        class="image-s"
        :href="'/' + locale + '/search/product/' + product.Termek_ID"
    >
        <div
            class="image"
            :style="{ backgroundImage: `url(${product.Kep})`}"
            :title="product.Kod"
        />
    </a>
    <a
        :href="'/' + locale + '/search/product/' + product.Termek_ID"
        class="text-inherit"
    >
        <div class="text-xs font-semibold">{{ product.Kod }}</div>
        <div class="text-2xs">{{ product.Nev }}</div>
    </a>
</div>
</template>

<script>
export default {
    name: 'AdditionalProduct',
    props: {
        product: {
            type: Object,
            required: false,
            default: function () {
                return {
                    Termek_ID: '',
                    Kep: '',
                    Kod: '',
                }
            },
        },
        locale: {
            type: String,
            required: false,
            default: 'hu',
        },
    },

}
</script>

