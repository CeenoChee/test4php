<template>
<div>
    <h3 class="title bg-sky-100 font-thin p-2 text-xs text-center uppercase text-gray-600">
        {{ title }}
    </h3>
    <ul class="top p-4 list-[circle]">
        <li
            v-for="element in elements"
            :key="element.id"
            class="marker:text-riel-light marker:text-lg ml-8"
        >
            <filtered-element
                :element="element"
                :locale="locale"
                :elementType="elementType"
                :keyword="keyword"
            />
        </li>
    </ul>

    <div
        v-if="showAllText != ''"
        class="uppercase text-riel-light text-xs ml-8 mb-4"
    >
        <a :href="showAllUrl">{{ showAllText }}</a>
    </div>
</div>
</template>

<script>
import FilteredElement from './FilteredElement'
export default {
    name: 'FilteredElementsList',
    components: {
        FilteredElement,
    },
    props: {
        title: {
            type: String,
            required: false,
            default: '',
        },
        elements: {
            type: Array,
            required: true,
        },
        showAllText: {
            type: String,
            required: false,
            default: '',
        },
        showAllUrl: {
            type: String,
            required: false,
            default: '',
        },
        elementType: {
            type: String,
            required: true,
        },
        locale: {
            type: String,
            required: true,
        },
        keyword: {
            type: String,
            required: false,
            default: '',
        },
    },
}
</script>
