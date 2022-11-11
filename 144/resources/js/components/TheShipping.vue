<template>
<div>
    <div class="mb-8">
        <h2 class="text-center text-riel-dark text-3lg mb-12 font-thin mt-12">
            {{ translations.pages.orders.takeover }}
        </h2>

        <div class="flex justify-center">
            <div
                v-for="(shippingMethod, shIndex) in shippingMethods"
                :key="shIndex"
                class="bg-white inline-block text-center mx-auto px-8 py-4 border-neutral-200 border rounded-md hover:cursor-pointer w-[200px] mx-4"
                :class="{'border-sky-500 text-riel-light' : shippingMethod.active }"
                @click="shippingMethodClicked(shippingMethod.id)"
            >
                <div>
                    <i
                        class="fal"
                        :class="shippingMethod.iconClass + ' text-xl'"
                    />
                    <input
                        :id="shippingMethod.id"
                        name="atvetel"
                        type="radio"
                        class="hidden"
                        :checked="shippingMethod.active"
                        :value="shippingMethod.value"
                    >
                    <div
                        class=""
                        :for="shippingMethod.id"
                    >
                        {{ shippingMethod.text }}
                    </div>
                </div>
            </div>
        </div>

        <input-error
            v-if="errors.hasOwnProperty('atvetel')"
            :message="errors.atvetel[0]"
        />
    </div>

    <div
        v-if="activeShippingMethodSlug === 'personal'"
        class="ib-group"
    >
        <h2 class="text-center text-riel-dark text-3lg my-12 font-thin mt-12">
            {{ translations.pages.orders.takeover_address }}
        </h2>

        <div class="flex justify-center mb-8">
            <div
                v-for="(pickupLocation, plIndex) in pickupLocations"
                :key="plIndex"
                class="bg-white inline-block text-center mx-auto px-8 py-4 border-neutral-200 border rounded-md hover:cursor-pointer w-[200px] mx-4"
                :class="{'border-sky-500 text-riel-light' : pickupLocation.active }"
            >
                <div @click="pickupLocationClicked(pickupLocation.SzemAtvevohely_ID, pickupLocation.Orszag_ID)">
                    <i
                        class="fal"
                        :class="pickupLocation.iconClass + ' text-xl'"
                    />
                    <div>{{ pickupLocation.Nev }}</div>
                    <input
                        :id="'atvevohely_' + pickupLocation.SzemAtvevohely_ID"
                        name="atvevohely"
                        type="radio"
                        class="hidden"
                        :checked="pickupLocation.active"
                        :value="pickupLocation.SzemAtvevohely_ID"
                    >
                    <div
                        :for="'atvevohely_' + pickupLocation.SzemAtvevohely_ID"
                        class="text-xs"
                    >
                        {{ pickupLocation.IrSzam }} {{ pickupLocation.Helyseg }},<br>
                        {{ pickupLocation.UtcaHSzam }}
                    </div>
                </div>
            </div>
        </div>

        <div
            v-for="(pickupLocation, plIndex) in pickupLocations"
            :id="pickupLocation.SzemAtvevohely_ID + '_map'"
            :key="plIndex"
            :class="{ hidden: !pickupLocation.active}"
        >
            <google-map
                :id="`atvevohely-map-iframe-${pickupLocation.SzemAtvevohely_ID}`"
                :address="pickupLocation.address"
            />
        </div>
        <input-error
            v-if="errors.hasOwnProperty('atvevohely')"
            :message="errors.atvevohely[0]"
        />
    </div>

    <div
        v-if="activeShippingMethodSlug === 'delivery'"
        class="ib-group mb-8"
    >
        <h2 class="text-center text-riel-dark text-3lg my-12 font-thin">
            {{ translations.pages.orders.shipping_address }}
        </h2>

        <div class="flex justify-center">
            <div
                v-for="(addressPickerType, aptIndex) in addressPickerTypes"
                :key="aptIndex"
                class="bg-white inline-block text-center mx-auto px-8 py-4 border-neutral-200 border rounded-md hover:cursor-pointer w-[200px] mx-4"
                :class="{'border-sky-500 text-riel-light' : addressPickerType.active }"
                @click="addressPickerTypeClicked(addressPickerType.id)"
            >
                <div>
                    <i
                        class="fal"
                        :class="addressPickerType.iconClass + ' text-xl'"
                    />
                    <input
                        :id="addressPickerType.id"
                        name="szallitasi_cim_tipus"
                        type="radio"
                        class="hidden"
                        :checked="addressPickerType.active"
                        :value="addressPickerType.value"
                    >
                    <div :for="addressPickerType.id">
                        {{ addressPickerType.text }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <the-addresses
        v-if="activeShippingMethodSlug === 'delivery'"
        ref="addresses"
        page="shipping"
        :initialCustomer="initialCustomer"
        :filtered="activeAddressPickerTypeSlug === 'copy' ? initialCart.UgyfelCim_ID : ''"
        :countries="countries"
        :title="translations.pages.orders.shipping_address"
        :initialErrors="errors"
        :creatable="activeAddressPickerTypeSlug === 'copy' ? false : true"
        @updateOrderPrices="updateOrderPrices"
    />

    <div class="ib-group">
        <h2 class="text-center text-riel-dark text-3lg my-12 font-thin mt-12">
            {{ translations.pages.orders.part_delivery }}
        </h2>
        <div
            id="szallitas"
            class="flex justify-center"
        >
            <div
                class="bg-white inline-block text-center mx-auto px-8 py-4 border-neutral-200 border rounded-md hover:cursor-pointer w-[200px] mx-4"
                :class="{'text-riel-light border-sky-500' : cart.partial_shipping === 1 }"
                @click="partialShippingClicked(1)"
            >
                <div>
                    <i class="fal fa-check text-xl" />
                    <input
                        id="szallitas_tetelresz"
                        name="szallitas"
                        type="radio"
                        class="hidden"
                        value="szallitas_tetelresz"
                        :checked="cart.partial_shipping === 1"
                    >
                    <div
                        for="szallitas_tetelresz"
                    >
                        {{ translations.global.yes }}
                    </div>
                </div>
            </div>
            <div
                class="bg-white inline-block text-center mx-auto px-8 py-4 border-neutral-200 border rounded-md hover:cursor-pointer w-[200px] mx-4"
                :class="{'text-riel-light border-sky-500' : cart.partial_shipping === 0 }"
                @click="partialShippingClicked(0)"
            >
                <div>
                    <i class="fal fa-times text-xl" />
                    <input
                        id="szallitas_egesz"
                        name="szallitas"
                        type="radio"
                        class="hidden"
                        value="szallitas_egesz"
                        :checked="cart.partial_shipping === 0"
                    >
                    <div
                        for="szallitas_egesz"
                    >
                        {{ translations.global.no }}
                    </div>
                </div>
            </div>
        </div>
        <input-error
            v-if="errors.hasOwnProperty('szallitas')"
            :message="errors.szallitas[0]"
        />
    </div>

    <div
        v-if="activeShippingMethodSlug === 'delivery'"
        id="visszaru-group"
        class=""
    >
        <h2 class="text-center text-riel-dark text-3lg my-12 font-thin mt-12">
            {{ translations.pages.orders.return }}
        </h2>
        <div
            id="visszaru"
            class="flex justify-center"
        >
            <div
                class="bg-white inline-block text-center mx-auto px-8 py-4 border-neutral-200 border rounded-md hover:cursor-pointer w-[200px] mx-4"
                :class="{'text-riel-light border-sky-500' : cart.Visszaru == 1 }"
                @click="returnGoodsClicked(1)"
            >
                <div>
                    <i class="fal fa-check text-xl" />
                    <input
                        id="visszaru_igen"
                        name="visszaru"
                        type="radio"
                        class="hidden"
                        value="visszaru_igen"
                        :checked="cart.Visszaru == 1"
                    >
                    <div
                        for="visszaru_igen"
                    >
                        {{ translations.global.yes }}
                    </div>
                </div>
            </div>
            <div
                class="bg-white inline-block text-center mx-auto px-8 py-4 border-neutral-200 border rounded-md hover:cursor-pointer w-[200px] mx-4"
                :class="{'text-riel-light border-sky-500' : cart.Visszaru == 0 }"
                @click="returnGoodsClicked(0)"
            >
                <i class="fal fa-times text-xl" />
                <input
                    id="visszaru_nem"
                    name="visszaru"
                    type="radio"
                    class="hidden"
                    value="visszaru_nem"
                    :checked="cart.Visszaru == 0"
                >
                <div
                    for="visszaru_nem"
                >
                    {{ translations.global.no }}
                </div>
            </div>
        </div>
        <input-error
            v-if="errors.hasOwnProperty('visszaru')"
            :message="errors.visszaru[0]"
        />
        <div
            v-if="cart.Visszaru == 1"
            id="visszaru_message"
            class="text-red-600 text-center text-xs my-8"
        >
            {{ translations.pages.orders.return_goods_message }}
        </div>
    </div>

    <button
        type="button"
        class="btn mx-auto mt-8 !bg-green-500"
        @click="checkSelectedAddress()"
    >
        {{ translations.form.next }}
    </button>
</div>
</template>

<script>
import InputError from './InputError';
import GoogleMap from './GoogleMap';
import TheAddresses from './TheAddresses';
import Vue from 'vue';

export default {
    name: 'TheShipping',
    components: {
        InputError,
        GoogleMap,
        TheAddresses,
    },
    props: {
        initialPickupLocations: {
            type: Array,
            required: true,
        },
        initialAddressPickerType: {
            type: String,
            default: function () {
                return 'copy';
            },
        },
        initialCart: {
            type: Object,
            required: true,
        },
        initialCustomer: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
            default: function () {
                return {}
            },
        },
        addressOld: {
            type: String,
            default: function () {
                return '';
            },
        },
        countries: {
            type: Object,
            required: true,
            default: function () {
                return {};
            },
        },
        subTotal: {
            type: String,
            default: function () {
                return ''
            },
        },
        total: {
            type: String,
            default: function () {
                return ''
            },
        },
        shippingCost: {
            type: String,
            default: function () {
                return ''
            },
        },
        vat: {
            type: Number,
            default: function () {
                return 0
            },
        },
        orderPricesEndpoint: {
            type: String,
            default: function () {
                return ''
            },
        },
    },
    data() {
        return {
            shippingMethods: [
                {
                    id: 'atvetel-kiszallitas',
                    slug: 'delivery',
                    iconClass: 'fa-truck',
                    value: 'atvetel_kiszallitas',
                    text: window.translations.pages.orders.delivery,
                    active: this.isReceptionType('delivery'),
                },
                {
                    id: 'atvetel-szemelyes-atvetel',
                    slug: 'personal',
                    iconClass: 'fa-map-marker-alt',
                    value: 'atvetel_szemelyes_atvetel',
                    text: window.translations.pages.orders.store,
                    active: this.isReceptionType('personal'),
                },
            ],

            addressPickerTypes: [
                {
                    id: 'szallitasi-cim-megegyezik',
                    slug: 'copy',
                    iconClass: 'fa-copy',
                    value: 'szallitasi_cim_megegyezik',
                    text: window.translations.pages.shipping.address_picker_type_copy,
                    active: this.isActiveAddressPickerType('copy'),
                },
                {
                    id: 'szallitasi-cim-egyedi',
                    slug: 'custom',
                    iconClass: 'fa-map-location-dot',
                    value: 'szallitasi_cim_egyedi',
                    text: window.translations.pages.shipping.address_picker_type_custom,
                    active: this.isActiveAddressPickerType('custom'),
                },
            ],

            shippingPriceText: '',
            sumPriceText: '',
            pickupLocations: [...this.initialPickupLocations],
            cart: { ...this.initialCart },
        }
    },
    computed: {
        translations() {
            return window.translations;
        },
        activeShippingMethodSlug() {
            return this.shippingMethods.filter(method => method.active)[0].slug;
        },
        activeAddressPickerTypeSlug() {
            return this.addressPickerTypes.filter(method => method.active)[0].slug;
        },
    },
    mounted() {
        this.shippingPriceText = this.shippingCost;
        this.sumPriceText = this.total;
    },
    methods: {
        isReceptionType(type) {
            return this.initialCart.reception_type === type;
        },

        isActiveAddressPickerType(type){
            return this.initialAddressPickerType === type;
        },

        shippingMethodClicked(shippingMethodId) {
            const vm = this;

            Object.keys(vm.shippingMethods).forEach(function (key) {
                vm.shippingMethods[key].active = vm.shippingMethods[key].id === shippingMethodId;
            });

        },

        returnGoodsClicked(value) {
            this.cart.Visszaru = value;
        },

        partialShippingClicked(value) {
            this.cart.partial_shipping = value;
        },

        async pickupLocationClicked(pickupLocationId, countryId) {
            const vm = this;

            Object.keys(vm.pickupLocations).forEach(function (key) {
                vm.pickupLocations[key].active = vm.pickupLocations[key].SzemAtvevohely_ID === pickupLocationId;
            });

            await vm.updateOrderPrices(countryId)
        },

        addressPickerTypeClicked(addressPickerTypeId) {
            const vm = this;

            Object.keys(vm.addressPickerTypes).forEach(function (key) {
                vm.addressPickerTypes[key].active = vm.addressPickerTypes[key].id === addressPickerTypeId;
            });
        },

        async updateOrderPrices(countryId) {
            const vm = this;

            await $.ajax({
                type: 'POST',
                url: this.orderPricesEndpoint,
                data: {
                    Orszag_ID: countryId,
                },
                success: function (result) {
                    vm.shippingPriceText = result.shipping_price_text;
                    vm.sumPriceText = result.sum_price_text;
                },
                dataType: 'json',
            });
        },

        checkSelectedAddress() {
            if (this.activeShippingMethodSlug === 'personal') {
                $('#shipping-form').submit();
                return;
            }

            let selectedIndex = 0;
            let selectedAddress = null;

            for (var key in this.$refs.addresses.addresses) {
                if (this.$refs.addresses.addresses[key].active) {
                    selectedAddress = this.$refs.addresses.addresses[key];
                    selectedIndex = key;
                }
            }

            if (selectedAddress && selectedAddress.Telefon === null) {
                this.$refs.addresses.openEditModal(selectedIndex);
                Vue.nextTick(() => {
                    this.$refs.addresses.save();
                })
            } else {
                $('#shipping-form').submit();
            }

        },
    },
}
</script>

