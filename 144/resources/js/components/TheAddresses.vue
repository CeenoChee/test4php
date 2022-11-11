<template>
<div class="p-2 text-center">
    <h2
        v-if="title && !isShippingPage"
        class="text-center text-riel-dark text-3lg my-12 font-thin"
    >
        {{ title }}
    </h2>
    <div
        :class="{'grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-2 2xl:grid-cols-3 gap-4': isAddressesPage || isPremisesPage || !addresses || Object.keys(addresses).length >= 3}"
    >
        <div
            v-for="(address, index) in addresses"
            :key="'address-box_' + index"
            class="address-box border border-neutral-200 p-4 rounded-md hover:cursor-pointer shadow-md bg-white text-left"
            :class="{'border-sky-500' : address.active, 'waiting-for-sync' : isWaitingForSync(index),
                     'w-full lg:w-1/3 lg:inline-block mx-2': addresses && Object.keys(addresses).length < 3 && (isShippingPage || isBillingPage)}"
            @click="addressClicked(index)"
            @dblclick="openEditModal(index)"
        >
            <div
                v-if="isWaitingForSync(index)"
                class="badge-warning"
            >
                Szinkronizálásra vár...
            </div>
            <div class="flex">
                <div class="basis-1/4">
                    <i
                        class="address-box-icon fal text-riel-light"
                        :title="getIconTitle(address)"
                        :class="{
                            'fa-building' : address.AlapCim === '1',
                            'fa-warehouse' : !address.hasOwnProperty('AlapCim') || (address.AlapCim === '0' && address.UgyfelTelephely_ID),
                            'fa-truck' : (address.AlapCim === '0' && address.UgyfelCim_ID && !address.UgyfelTelephely_ID)
                        }"
                    />
                </div>
                <input
                    name="address"
                    type="radio"
                    class="hidden"
                    :checked="addresses[index].active"
                    :value="address.UgyfelTelephely_ID"
                >
                <input
                    name="UgyfelCim_ID"
                    type="radio"
                    class="hidden"
                    :checked="addresses[index].active"
                    :value="address.UgyfelCim_ID"
                >
                <div class="address-infos basis-2/4 grow">
                    <div
                        class="address-info-item"
                        v-text="addresses[index].Nev"
                    />
                    <div
                        class="address-info-item font-semibold"
                        v-text="addresses[index].UtcaHSzam"
                    />
                    <div
                        class="address-info-item"
                        v-text="addresses[index].IrSzam + ' ' +addresses[index].Helyseg"
                    />
                </div>

                <div class="address-box-edit grid">
                    <div
                        v-if="isPremisesPage && address.id && addresses[index].UgyfelTelephely_ID"
                        class="flex justify-end mb-6"
                    >
                        <label class="switch switch-sm">
                            <input
                                v-model="addresses[index].Hasznalhato"
                                type="checkbox"
                                :name="'addresses['+index+'][Hasznalhato]'"
                                :disabled="!addresses[index] && !addresses[index].UgyfelTelephely_ID"
                                @click="setActivity(address)"
                            >
                            <span class="switch-slider" />
                        </label>
                    </div>

                    <button
                        v-if="!isPremise(address) && (address.hasOwnProperty('UgyfelCim_ID') && address.Szerkesztheto === '1')"
                        class="flex justify-end"
                        @click.stop.prevent="deleteAddress(address, index)"
                    >
                        <i class="fal fa-times" />
                    </button>

                    <div class="flex justify-end items-end">
                        <i
                            v-if="(isPremisesPage && address.UgyfelTelephely_ID) || !isBillingPage"
                            class="fal fa-edit text-riel-light"
                            @click="openEditModal(index)"
                        />
                    </div>
                </div>

                <input
                    v-if="addresses[index].hasOwnProperty('UgyfelCim_ID')"
                    v-model="addresses[index].UgyfelCim_ID"
                    type="hidden"
                    :name="'addresses_id'"
                >
            </div>
        </div>

        <div
            v-if="!newAddressAlreadyExists && !isBillingPage && creatable === true"
            class="address-box clear-both border border-dashed border-neutral-200 p-4 rounded-md text-center hover:cursor-pointer"
            @click="openNewModal"
        >
            <div class="next-address-button">
                <i class="fal fa-plus text-gray-300 text-[4rem]" />
            </div>
        </div>
    </div>
    <input-error
        v-if="errors.hasOwnProperty('address')"
        :message="errors.address[0]"
    />

    <div
        :id="'address-form-modal-' + page"
        class="modal text-sm md:!w-[500px]"
    >
        <h2
            class="border-b border-neutral-200 pb-2 mb-4 text-gray-600 text-lg font-thin"
            v-html="modalTitle"
        />

        <form>
            <div class="form-group">
                <label
                    :for="`ceg_nev`"
                    class="text-gray-800"
                >{{ translations.form.company_name }}</label>
                <input
                    :id="`nev`"
                    v-model="modalForm.company_name"
                    type="text"
                    required
                    disabled="disabled"
                    class="form-control text-gray-500 bg-neutral-200 hover:cursor-not-allowed"
                    :name="'ceg_nev'"
                >

                <label
                    :for="`nev`"
                    class="required text-gray-800"
                >{{ translations.form.address_name }}</label>
                <input
                    :id="`nev`"
                    v-model="modalForm.name"
                    type="text"
                    class="form-control"
                    required
                    :readonly="!isFormEditable"
                    :class="{ 'text-gray-500 bg-neutral-200 hover:cursor-not-allowed' : !isFormEditable}"
                    :name="'address_name'"
                    :placeholder="translations.form.placeholder.address_name"
                >
                <input-error
                    v-if="errors.hasOwnProperty('address_name')"
                    :message="errors['address_name'][0]"
                />
            </div>
            <div class="form-group">
                <label
                    :for="`country-code`"
                    class="required text-gray-800"
                >{{ translations.form.country }}</label>
                <select
                    :id="`country-code`"
                    v-model="modalForm.country"
                    class="form-control"
                    :disabled="!isFormEditable"
                    :class="{ 'text-gray-500 hover:cursor-not-allowed' : !isFormEditable}"
                    required
                    @change="$emit('updateOrderPrices', modalForm.country)"
                >
                    <option
                        v-for="(country, id) in countries"
                        :key="'country_' + id"
                        :value="id"
                    >
                        {{ country }}
                    </option>
                </select>

                <input
                    v-model="modalForm.country"
                    type="hidden"
                    :name="'address_country'"
                >

                <input-error
                    v-if="errors.hasOwnProperty('address_country')"
                    :message="errors['address_country'][0]"
                />
            </div>
            <div class="flex gap-4">
                <div class="basis-1/3">
                    <label
                        :for="`iranyitoszam`"
                        class="required text-gray-800"
                    >{{ translations.form.zip_code }}</label>
                    <input
                        :id="`iranyitoszam`"
                        v-model="modalForm.zip"
                        type="text"
                        class="form-control"
                        required
                        :name="'address_zip_code'"
                        :readonly="!isFormEditable"
                        :class="{ 'text-gray-500 bg-neutral-200 hover:cursor-not-allowed' : !isFormEditable}"
                        :placeholder="translations.pages.shipping.placeholder.zip"
                        @keyup="zipCodeChanged()"
                    >
                    <input-error
                        v-if="errors.hasOwnProperty('address_zip_code')"
                        :message="errors['address_zip_code'][0]"
                    />
                </div>

                <div class="basis-2/3">
                    <label
                        :for="`helyseg`"
                        class="required text-gray-800"
                    >{{ translations.form.city }}</label>
                    <input
                        :id="`helyseg`"
                        v-model="modalForm.city"
                        type="text"
                        class="form-control"
                        required
                        :name="'address_city'"
                        :readonly="!isFormEditable"
                        :class="{ 'text-gray-500 bg-neutral-200 hover:cursor-not-allowed' : !isFormEditable}"
                        :placeholder="translations.pages.shipping.placeholder.city"
                        @keyup="cityChanged()"
                    >
                    <input-error
                        v-if="errors.hasOwnProperty('address_city')"
                        :message="errors['address_city'][0]"
                    />
                </div>
            </div>

            <div class="form-group">
                <label
                    :for="`utca_hazszam`"
                    class="required text-gray-800"
                >{{ translations.form.address }}</label>
                <input
                    :id="`utca_hazszam`"
                    v-model="modalForm.street"
                    type="text"
                    class="form-control"
                    required
                    :name="'address_street'"
                    :readonly="!isFormEditable"
                    :class="{ 'text-gray-500 bg-neutral-200 hover:cursor-not-allowed' : !isFormEditable}"
                    :placeholder="translations.pages.shipping.placeholder.street"
                >
                <input-error
                    v-if="errors.hasOwnProperty('address_street')"
                    :message="errors['address_street'][0]"
                />
            </div>

            <div v-if="!isBillingPage">
                <div class="flex gap-4">
                    <div class="basis-1/2">
                        <label
                            :for="`telefon`"
                            class="required text-gray-800"
                        >{{ translations.form.phone }}</label>
                        <input
                            :id="`telefon`"
                            v-model="modalForm.phone"
                            type="text"
                            class="form-control"
                            required
                            :name="'address_phone'"
                            :placeholder="translations.pages.shipping.placeholder.phone"
                        >
                        <input-error
                            v-if="errors.hasOwnProperty('address_phone')"
                            :message="errors['address_phone'][0]"
                        />
                    </div>

                    <div class="basis-1/2">
                        <label
                            :for="`email`"
                            class="text-gray-800"
                        >{{ translations.form.email }}</label>
                        <input
                            :id="`email`"
                            v-model="modalForm.email"
                            type="email"
                            class="form-control"
                            :name="'address_email'"
                        >
                        <input-error
                            v-if="errors.hasOwnProperty('address_email')"
                            :message="errors['address_email'][0]"
                        />
                    </div>
                </div>

                <div class="form-group">
                    <label
                        :for="`megjegyzes`"
                        class="text-gray-800"
                    >{{ translations.pages.shipping.comment_to_courier }}</label>
                    <textarea
                        :id="`megjegyzes`"
                        v-model="modalForm.comment"
                        class="form-control"
                        rows="4"
                        :name="'address_comment'"
                        :placeholder="translations.pages.shipping.placeholder.comment_to_courier"
                    />
                    <input-error
                        v-if="errors.hasOwnProperty('address_comment')"
                        :message="errors['address_comment'][0]"
                    />
                </div>
            </div>
            <div
                v-if="modalForm.agent !== ''"
                class="mb-4 text-gray-400 text-xs"
            >
                {{ translations.pages.account.agent }}: {{ modalForm.agent }}
            </div>

            <input
                v-model="modalForm.enabled"
                type="hidden"
                name="enabled"
            >

            <a
                href="#close-modal"
                rel="modal:close"
                class="btn-outline cancel-btn float-left"
            >
                Mégse
            </a>

            <button
                type="button"
                class="btn save-btn float-right"
                @click="save()"
            >
                Mentés
            </button>
        </form>
    </div>
</div>
</template>

<script>
import Postcode from '../Postcode';
import InputError from './InputError';
import Swal from 'sweetalert2';

export default {
    name: 'TheAddresses',
    components: {
        InputError,
    },
    props: {
        initialCustomer: {
            type: Object,
            default: function () {
                return {}
            },
        },

        creatable: {
            type: Boolean,
            default: function () {
                return true
            },
        },

        filtered: {
            type: String,
            default: function () {
                return ''
            },
        },

        countries: {
            type: Object,
            required: true,
            default: function () {
                return {};
            },
        },
        page: {
            type: String,
            required: true,
        },
        title: {
            type: String,
            required: false,
            default: null,
        },
        initialErrors: {
            type: Object,
            required: false,
            default: function () {
                return {};
            },
        },
    },
    data() {
        return {
            customer: {},
            newAddressAlreadyExists: false,
            errors: this.initialErrors,
            modalForm: this.defaultModalFormData(),
        }
    },
    computed: {
        translations() {
            return window.translations;
        },
        locale() {
            return window.locale;
        },

        addresses() {

            let vm = this;
            let addresses;

            if (vm.isPremisesPage || vm.isBillingPage) {
                addresses = this.customer.premises;
            } else {
                addresses = this.customer.shippingAddresses;
            }

            if (vm.filtered !== '' && addresses) {

                let filteredAddress = {};
                addresses.forEach(function (address, index) {

                    addresses[index].active = false;

                    if (address.UgyfelCim_ID === vm.filtered) {
                        filteredAddress[index] = address;
                        filteredAddress[index].active = true;
                    }
                });

                return filteredAddress;

            }

            return addresses;

        },

        isPremisesPage() {
            return this.page === 'premises';
        },
        isAddressesPage() {
            return this.page === 'addresses';
        },
        isBillingPage() {
            return this.page === 'billing';
        },
        isShippingPage() {
            return this.page === 'shipping';
        },
        isFormEditable() {
            return this.modalForm.editable == '1'
        },
        modalTitle() {
            if (this.modalForm.method === 'create') {

                if (this.isAddressesPage) {
                    return this.translations.pages.shipping.new_shipping_address;
                } else if (this.isPremisesPage) {
                    return this.translations.pages.shipping.new_billing_address;
                }
            }

            switch (this.modalForm.type) {
                case 'hq':
                    return this.translations.pages.shipping.edit.hq + '<small id="address-modal-information">' + this.translations.pages.shipping.edit.hq_desc + '</small>';
                case 'premise':
                    return this.translations.pages.shipping.edit.billing_address;
                case 'shipping_address':
                    return this.translations.pages.shipping.edit.shipping_address;
            }

            return '';
        },
    },
    mounted() {
        this.customer = { ...this.initialCustomer };

        if (this.isPremisesPage) {
            this.setUnsynchronizedAddressChecker();
        }
    },
    created() {
        $('.address-box').eq(1).trigger('click');
    },
    methods: {
        isPremise(address) {
            return address.UgyfelTelephely_ID != null;
        },

        isWaitingForSync(index){
            return (this.isPremisesPage && this.addresses[index].id && !this.addresses[index].UgyfelTelephely_ID && this.addresses[index].AlapCim !== 1) ||
                this.addresses[index].is_under_sync === '1'
        },

        defaultModalFormData() {
            return {
                index: 0,
                method: '',
                company_name: '',
                name: '',
                type: '',
                country: '',
                street: '',
                zip: '',
                city: '',
                agent: '',
                email: '',
                phone: '',
                comment: '',
                editable: 0,
                enabled: 0,
            };
        },

        setActivePropertiesToFalse(array) {
            Object.keys(array).forEach(function (key) {
                array[key].active = false;
            });
        },

        addressClicked(index) {
            const vm = this;

            if (vm.isPremisesPage || vm.isAddressesPage || vm.isWaitingForSync(index)) {
                return;
            }

            for (var key in vm.addresses) {
                vm.addresses[key].active = parseInt(key) == index;
            }

            let activeAddressCountryId = (vm.filtered === '' && Array.isArray(vm.addresses)) ? vm.addresses.filter(address => address.active)[0].country.Orszag_ID : vm.addresses[Object.keys(vm.addresses)[0]].country.Orszag_ID;

            vm.$emit('updateOrderPrices', activeAddressCountryId)

            vm.$forceUpdate();
        },

        openNewModal() {

            this.errors = {};

            this.modalForm.index = this.addresses.length + 1;
            this.modalForm.method = 'create';
            this.modalForm.company_name = this.customer.Nev;
            this.modalForm.name = '';
            this.modalForm.country = '0';
            this.modalForm.street = '';
            this.modalForm.zip = '';
            this.modalForm.city = '';
            this.modalForm.agent = '';
            this.modalForm.email = '';
            this.modalForm.phone = '';
            this.modalForm.comment = '';
            this.modalForm.editable = 1;
            this.modalForm.enabled = 1;

            $('#address-form-modal-' + this.page).modal({
                fadeDuration: 100,
                clickClose: false,
            });
        },

        zipCodeChanged() {
            const city = (new Postcode()).getCityByCode(this.modalForm.zip);

            if (city) {
                this.modalForm.city = city;
            }
        },

        cityChanged() {
            const zipCode = (new Postcode()).getCodeByCity(this.modalForm.city);

            if (zipCode) {
                this.modalForm.zip = zipCode;
            }
        },

        deleteAddress(address, index) {
            Swal.fire({
                title: window.translations.global.are_you_want_to_delete,
                icon: 'warning',
                confirmButtonText: window.translations.global.yes,
                cancelButtonText: window.translations.global.no,
                showCancelButton: true,

            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        data: { page: this.page },
                        url: `/addresses/${address.UgyfelCim_ID}`,
                        success: function () {
                        },
                        dataType: 'json',
                    });

                    if (Array.isArray(this.addresses)) {
                        this.addresses.splice(index, 1);
                    } else {
                        delete this.addresses[index];
                    }

                    this.$forceUpdate();
                }
            })
        },

        getIconTitle(address) {
            if (address.AlapCim === '1') {
                return window.translations.pages.shipping.hq;
            } else if (address.AlapCim === '0' && address.UgyfelTelephely_ID) {
                return window.translations.pages.shipping.company_premise;
            } else if ((address.AlapCim === '0' && address.UgyfelCim_ID && !address.UgyfelTelephely_ID)) {
                return window.translations.pages.shipping.other;
            }
        },

        openEditModal(index) {

            if (this.isBillingPage || this.isWaitingForSync(index)) {
                return;
            }

            let type = '';

            if (this.addresses[index].AlapCim === '1') {
                type = 'hq';
            } else if (this.addresses[index].UgyfelTelephely_ID !== null) {
                type = 'premise';
            } else {
                type = 'shipping_address';
            }

            this.modalForm.method = 'edit';
            this.modalForm.type = type;
            this.modalForm.index = parseInt(index);
            this.modalForm.company_name = this.customer.Nev;
            this.modalForm.name = this.addresses[index].Nev;
            this.modalForm.country = this.addresses[index].Orszag_ID;
            this.modalForm.zip = this.addresses[index].IrSzam;
            this.modalForm.city = this.addresses[index].Helyseg;
            this.modalForm.street = this.addresses[index].UtcaHSzam;
            this.modalForm.editable = this.isAddressEditable(index);
            this.modalForm.enabled = this.addresses[index].Hasznalhato;
            this.modalForm.phone = this.addresses[index].Telefon;
            this.modalForm.email = this.addresses[index].Email;
            this.modalForm.comment = this.addresses[index].Megjegyzes;

            let agent = this.addresses[index].agent;
            this.modalForm.agent = agent ? agent.Nev : '';

            this.errors = {};

            $('#address-form-modal-' + this.page).modal({
                fadeDuration: 100,
                clickClose: false,
            });
        },

        isAddressEditable(index) {
            if (this.isPremisesPage && this.isPremise(this.addresses[index])) {
                return 1;
            } else if (this.addresses[index].UgyfelTelephely_ID) {
                return 0;
            }

            return this.addresses[index].Szerkesztheto;
        },

        save() {
            let data = {};

            $.each($('#address-form-modal-' + this.page + ' form').serializeArray(), function () {
                data[this.name] = this.value;
            });

            if (this.modalForm.method === 'edit') {
                return this.update(data);
            }

            return this.createNew(data);
        },

        getUpdateUrl() {
            if (this.isPremisesPage || this.isBillingPage) {
                return '/fiok/telephelyek/' + this.addresses[this.modalForm.index].id;
            }

            return '/addresses/' + this.addresses[this.modalForm.index].UgyfelCim_ID;
        },

        update(data) {
            let vm = this;

            $.ajax({
                type: 'PATCH',
                url: this.getUpdateUrl(),
                data: data,
                dataType: 'json',
                success: function (result) {
                    $('.close-modal').trigger('click');

                    vm.addresses[vm.modalForm.index] = result;
                    vm.$forceUpdate();
                },
                error: function (result) {
                    vm.errors = result.responseJSON.errors;
                },

            });
        },

        createNew(data) {
            let vm = this;

            let url = '/addresses';

            if (vm.isPremisesPage) {
                url = '/fiok/telephelyek';
            }

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                dataType: 'json',
                success: function (result) {
                    $.modal.close();

                    vm.setActivePropertiesToFalse(vm.addresses);
                    vm.newAddressAlreadyExists = true;

                    if (Array.isArray(vm.addresses)) {
                        vm.addresses.push(result);
                    } else {
                        let lastIndex = parseInt(Object.keys(vm.addresses)[Object.keys(vm.addresses).length - 1]) + 1;
                        vm.addresses[lastIndex] = result;
                    }

                },
                error: function (result) {
                    vm.errors = result.responseJSON.errors;
                },
            });
        },

        setUnsynchronizedAddressChecker() {
            const vm = this;

            window.setInterval(() => {
                const unsynchronizedAddresses = vm.addresses.filter(address => address.id && address.UgyfelTelephely_ID === null);
                const hasUnsynchronizedAddress = unsynchronizedAddresses.length > 0;

                if (hasUnsynchronizedAddress) {
                    vm.checkAndSetSyncStatus(unsynchronizedAddresses);
                }
            }, 5000);
        },

        checkAndSetSyncStatus(addresses) {
            const vm = this;
            const addressIds = addresses.map(address => address.id);

            window.axios.post('/fiok/telephelyek/check-sync-status', {
                address_ids: addressIds,
            }).then(function (response) {
                Object.keys(response.data).forEach(id => vm.addresses[vm.addresses.findIndex(address => address.id == id)].UgyfelTelephely_ID = response.data[id]);
            }).catch(function (error) {
                console.error(error);
            });
        },

        setActivity(address) {
            window.axios.patch(`/fiok/telephelyek/${address.id}/set-activity`, {
                enabled: !address.Hasznalhato,
            }).then(function () {
            }).catch(function (error) {
                console.error(error);
            });
        },
    },
}
</script>

<style scoped>
.address-box .address-box-icon {
    font-size: 2rem;
}

.badge-warning {
    color: #212529;
    background-color: #ffc107;
    padding-right: .6em;
    padding-left: .6em;
    border-radius: 10rem;
    text-align: center;
    font-weight: bold;
    margin-bottom: 10px;
}

.waiting-for-sync {
    opacity: 0.5;
}
</style>
