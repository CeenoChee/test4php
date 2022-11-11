<template
    xmlns:v-on="http://www.w3.org/1999/xhtml"
    xmlns:v-bind="http://www.w3.org/1999/xhtml"
>
<div>
    <button
        class="search-button button"
        :data-tooltip="tooltip"
        @click="searchButton()"
    >
        <i class="fal fa-search" />
    </button>

    <div
        class="search-nav"
        :class="searchNav ? 'block' : 'hidden'"
    >
        <div
            class="absolute border-b border-neutral-200 h-10 left-0 top-[50px] bg-white w-full z-20 shadow-2xl py-2"
            style="height: 58px"
        >
            <form
                :action="`/${locale}/search/all/product`"
                method="GET"
                class="lg:w-1/2 mx-auto relative h-10"
            >
                <button
                    class="search-submit absolute z-30 text-riel-light w-10 h-10"
                    type="submit"
                >
                    <i class="fal fa-search" />
                </button>
                <input
                    ref="searchText"
                    v-model="keyword"
                    class="text-black !py-1 !px-10 text-lg bottom-[15px] h-10 main-search"
                    type="text"
                    autocorrect="off"
                    autocapitalize="off"
                    name="keyword"
                    :placeholder="translations.global.placeholder.search"
                    autocomplete="off"
                    @keydown.esc="searchReset"
                    @keydown.enter="pressEnter"
                >
                <button
                    class="search-reset absolute z-30 text-gray-500 w-10 h-10 right-0"
                    @click="searchReset()"
                >
                    <i class="fal fa-times" />
                </button>
            </form>

            <div
                class="topsearch relative top-[10px] mx-auto lg:w-3/4 overflow-y-scroll lg:overflow-y-auto h-[600px] lg:h-auto"
                :class="open ? 'block' : 'hidden'"
            >
                <div class="bg-white border border-neutral-200 relative text-gray-500 lg:flex text-left shadow-search">
                    <div class="search-related basis-1/3 border-r border-neutral-200">
                        <filtered-elements-list
                            v-if="filteredCategories.length > 0"
                            :title="trans.categories"
                            :elements="filteredCategories"
                            :elementType="'category'"
                            :locale="locale"
                            :keyword="keyword"
                        />
                        <filtered-elements-list
                            v-if="filteredKnowledge.length > 0"
                            :title="trans.knowledge"
                            :elements="filteredKnowledge"
                            :showAllText="trans.show_all"
                            :showAllUrl="urls.knowledge"
                            :elementType="'knowledge'"
                            :locale="locale"
                            :keyword="keyword"
                        />
                        <filtered-elements-list
                            v-if="filteredDownloads.length > 0"
                            :title="trans.downloads"
                            :elements="filteredDownloads"
                            :showAllText="trans.show_all"
                            :showAllUrl="urls.download"
                            :elementType="'download'"
                            :locale="locale"
                            :keyword="keyword"
                        />
                    </div>

                    <div class="basis-2/3">
                        <div class="search-text-bar bg-sky-100 font-thin p-2 text-xs text-center uppercase text-gray-600">
                            {{ trans.products }}
                        </div>
                        <div class="p-4">
                            <search-products-list
                                :filteredProducts="filteredProducts"
                                :locale="locale"
                                :rielactive="rielactive"
                                :trans="trans"
                                :keyword="keyword"
                            />
                            <additional-products-list
                                :products="products"
                                :filteredProducts="filteredProducts"
                                :title="trans.additional_products"
                                :locale="locale"
                            />
                            <div class="search-text text-riel-light text-center mt-8 mb-4 text-2sm">
                                <a :href="'/' + locale + '/search/all/product?keyword=' + encodeURIComponent(keyword)">{{
                                    trans.more_products
                                }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import SearchProductsList from './search/SearchProductsList';
import FilteredElementsList from './search/FilteredElementsList';
import axios from 'axios'
import AdditionalProductsList from './search/AdditionalProductsList';

export default {
    name: 'TheSearch',
    components: {
        FilteredElementsList,
        AdditionalProductsList,
        SearchProductsList,
    },
    props: {
        url: {
            type: String,
            required: true,
        },
        rielactive: {
            type: String,
            required: true,
        },
        locale: {
            type: String,
            required: true,
        },
        tooltip: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            searchNav: false,
            open: false,
            keyword: '',

            isLoaded: false,
            trans: {},
            urls: {},

            categories: [],
            knowledge: [],
            downloads: [],
            products: [],

            filteredCategories: [],
            filteredKnowledge: [],
            filteredDownloads: [],
            filteredProducts: [],
        }
    },
    computed: {
        translations() {
            return window.translations;
        },
    },
    watch: {
        keyword() {
            this.search();
        },
    },
    mounted() {
        let vm = this;

        $(document).mousedown(function (e) {
            if(!$(e.target).closest('.search-nav').length){
                vm.searchReset();
            }

        });

    },
    methods: {
        close() {
            this.searchNav = false;
        },
        searchButton() {
            this.searchNav = !this.searchNav;

            var that = this;

            if (this.searchNav) {

                $('.blurable').addClass('blur-xs').append('<div class="overlay"></div>');

                setTimeout(function () {
                    that.$refs.searchText.focus();
                }, 500);
            } else {
                $('.blurable').removeClass('blur-xs');
            }

            if (!this.isLoaded) {
                this.isLoaded = true;
                this.loadProducts();
            }
        },
        addToCart(product) {
            axios.post('/' + this.locale + '/cart/add/' + product.Termek_ID).then((response) => {
                if (!response.data.error) {
                    document.getElementById('little-cart').innerHTML = response.data.little_cart_content;
                }
            }).catch((e) => {
                console.error(e)
            });
        },
        incQty(product) {
            product.qty++;
        },
        decQty(product) {
            product.qty--;
        },
        productUrl(product) {
            return '/search/redirect/' + product.Termek_ID;
        },
        searchReset() {
            $('.blurable').removeClass('blur-xs');
            $('.overlay').remove();
            this.searchNav = false;
            this.keyword = '';
        },
        pressEnter() {
            window.location.href = '/' + this.locale + '/search/all/product?keyword=' + encodeURIComponent(this.keyword);
        },
        loadProducts() {

            axios.get(this.url).then((response) => {
                this.trans = response.data.trans;
                this.urls = response.data.urls;
                this.categories = response.data.categories;
                this.knowledge = response.data.knowledge;
                this.downloads = response.data.downloads;
                this.products = response.data.products;

                this.products.forEach(product => {
                    let additionalInfo = product.KiegeszitoTermek_IDS;
                    let replacementInfo = product.HelyettesitoTermek_Kodok;
                    product.KiegeszitoTermek_IDS = additionalInfo == null ? [] : additionalInfo.split(',');
                    product.HelyettesitoTermek_SzovegKod = replacementInfo == null ? '' : replacementInfo;
                    product.HelyettesitoTermek_Kodok = replacementInfo == null ? [] : replacementInfo.split(',');
                })

                if (this.keyword.trim().length > 0) {
                    this.search();
                    this.open = true;

                }
            }).catch((e) => {
                console.error(e)
            });
        },
        search() {
            if (this.products === null) {
                this.filteredProducts = [];
            }

            const keyword = this.keyword.toLowerCase().trim();

            this.open = true;

            //Termékek szűrése
            this.filteredProducts = keyword ? this.products.filter(product => keyword.split(' ').every(part => product.Kod.toLowerCase().includes(part) || product.Nev.toLowerCase().includes(part) || product.Gyarto.toLowerCase().includes(part))).slice(0, 6)
                : this.products.slice(0, 6);

            //Kategóriák szűrés
            this.filteredCategories = keyword ? this.categories.filter(category => keyword.split(' ').every(part => category.path.toLowerCase().includes(part))).slice(0, 3) : this.categories.slice(0, 3);

            //Letöltések szűrése
            this.filteredDownloads = keyword ? this.downloads.filter(download => keyword.split(' ').every(part => download.name.toLowerCase().includes(part) || download.version.toLowerCase().includes(part))).slice(0, 3) : this.downloads.slice(0, 3);

            //Tudástár szűrése
            this.filteredKnowledge = keyword ? this.knowledge.filter(knowledgeItem => keyword.split(' ').every(part => knowledgeItem.title.toLowerCase().includes(part.toLowerCase()))).slice(0, 3) : this.knowledge.slice(0, 3);

            //Ha a termékek hossza kevesebb mint 6, akkor helyettesítő termékeket keresünk, amivel kiegészíthetjük a jelenlegi terméklistát
            if (this.filteredProducts.length != 6) {
                var keywordArray = keyword.split(' ');
                this.filteredProducts = this.filteredProducts.concat(this.products.filter(product => {
                    for (let i = 0; i < product.HelyettesitoTermek_Kodok.length; i++) {
                        var j = 0;
                        for (j; j < keywordArray.length; j++) {
                            if (!(product.HelyettesitoTermek_Kodok[i].includes(keywordArray[j].toUpperCase()))) {
                                break;
                            }
                        }
                        if (j == keywordArray.length) {
                            return true;
                        }
                    }
                    return false;
                })).slice(0, 6);
            }
        },
    },
}
</script>
