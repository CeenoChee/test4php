<template>
<div class="">
    <div
        class="hover:cursor-pointer"
        @click="() => showImg(0)"
    >
        <img
            :src="typeof images[0] === 'string' ? images[0] : images[0].src"
            class="w-48"
        >
    </div>

    <div class="flex justify-center mb-4">
        <div
            v-for="(img, index) in thumbnails.slice(1)"
            :key="index"
            class="hover:cursor-pointer border-neutral-200 border p-1 w-16 mx-1"
            @click="() => showImg(index + 1)"
        >
            <img :src="typeof img === 'string' ? img : img.src">
        </div>
    </div>

    <vue-easy-lightbox
        :visible="visible"
        :imgs="images"
        :index="index"
        moveDisabled
        @hide="handleHide"
    />
</div>
</template>

<script>
import VueEasyLightbox from 'vue-easy-lightbox'

export default {
    name: 'TheLightbox',
    components: {
        VueEasyLightbox,
    },

    props: {
        images: {
            type: Array,
            required: true,
            default: function () {
                return []
            },
        },

        thumbnails: {
            type: Array,
            required: true,
            default: function () {
                return []
            },
        },

    },

    data() {
        return {
            visible: false,
            index: 0, // default: 0
        }
    },

    methods: {
        showImg(index) {
            this.index = index
            this.visible = true
        },
        handleHide() {
            this.visible = false
        },
    },
}
</script>

