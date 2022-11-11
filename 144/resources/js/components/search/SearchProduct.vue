<template>
<div class="search-prod-item">
    <div class="lg:flex">
        <a
            class="block"
            :href="'/' + locale + '/search/product/' + product.Termek_ID"
        >
            <div
                class="w-[50px] h-[50px] bg-no-repeat bg-center bg-contain mr-2"
                :style="{ backgroundImage: `url(${product.Kep})`}"
                :title="product.Kod"
            />
        </a>
        <div class="prod-base">
            <div
                class="manuf uppercase font-thin text-2xs"
                v-html="getFormattedManufacturer"
            />
            <a
                :href="'/' + locale + '/search/product/' + product.Termek_ID"
                class="text-inherit"
            >
                <div
                    class="code text-2sm font-semibold"
                    v-html="getFormattedCode"
                />
                <div
                    class="description text-2xs"
                    v-html="getFormattedName"
                />
            </a>
            <div
                v-if="productHasAnyPromotion(product)"
                class="tag flex relative gap-2 mt-2"
            >
                <div
                    v-if="productHasAnyPromotion(product)"
                    class="bg-red-600 rounded-md py-1 px-2 text-white text-xs"
                >
                    <template v-if="product.AkcioNev !==''">
                        {{ product.AkcioNev }}
                    </template>
                    <template v-else>
                        {{ trans.sale }}
                    </template>
                </div>
                <div
                    v-if="product.Projekt !== '0'"
                    class="rounded-md py-1 px-2 bg-sky-200 text-gray-600 border border-gray-300 text-xs"
                >
                    {{ trans.project }}
                </div>
                <div
                    v-if="product.Ujdonsag !== '0'"
                    class="rounded-md py-1 px-2 bg-sky-200 text-gray-600 border border-gray-300 text-xs"
                >
                    {{ trans.news }}
                </div>
            </div>
        </div>
    </div>
    <div
        v-if="rielactive"
        class="prod-data lg:ml-[58px] mt-2"
    >
        <div
            v-if="product.Ar !== null && product.Ar != 0"
            :data-tax="'+' + trans.vat"
            class="userprice"
        >
            <div class="text-2xs text-gray-500 leading-none">
                {{ trans.discounted_price }}
            </div>
            <div class="font-bold text-lg text-riel-light">
                {{ product.Ar }} <span class="text-gray-500 text-2xs">+ {{ trans.vat }}</span>
            </div>
        </div>
        <div
            v-else
            :data-tax="trans.no_price"
            class="userprice"
        />
        <!--
          <div class="cart cart-form">
              <input type="text" class="qty" v-model="product.qty">
              <div class="controls">
                  <button class="control qty-inc" v-on:click="incQty(product)"><i
                          class="fal fa-caret-up"></i></button>
                  <button class="qty-dec" v-on:click="decQty(product)"><i
                          class="fal fa-caret-down"></i></button>
              </div>
              <button class="cart-button" v-on:click="addToCart(product)"><i
                      class="fal fa-shopping-bag"></i>Kosárba
              </button>
          </div>
          -->
    </div>
</div>
</template>

<script>
export default {
    name: 'SearchProduct',
    props: {
        product: {
            type: Object,
            required: false,
            default: function () {
                return {}
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
    computed: {
        getFormattedManufacturer() {
            return this.getFormattedText(this.product.Gyarto);
        },
        getFormattedCode() {
            return this.getFormattedText(this.product.Kod);
        },
        getFormattedName() {
            return this.getFormattedText(this.product.Nev);
        },

    },
    methods: {
        getFormattedText(text) {
            var formattedText = text;
            var keyword = this.keyword.trim().replace(new RegExp('(\\?\\.|\\?\\*)', 'gm'), '');
            if (keyword.length > 0) {
                keyword.split(' ').filter((v, i, a) => v.length > 0 && a.indexOf(v) === i)
                    .sort((a, b) => b.length - a.length)
                    .every(part => formattedText = formattedText.replace(new RegExp(part, 'gmi'), (match) => `?.${match}?*`));

                //
                formattedText = formattedText.replace(new RegExp('\\?\\*\\?\\.', 'gm'), '');
                formattedText = formattedText.replace(new RegExp('\\?\\.', 'gm'), '<span class="highlight-text">');
                formattedText = formattedText.replace(new RegExp('\\?\\*', 'gm'), '</span>');
                return formattedText;
            }
            return formattedText;
        },

        productHasAnyPromotion(product) {
            return (product.hasOwnProperty('Akcios') && product.Akcios !== '0') || product.hasOwnProperty('AkcioNev') && product.AkcioNev !== '';
        },
    },
}
</script>
