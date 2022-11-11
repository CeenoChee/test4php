<template>
<span class="text-xs text-red-600 relative bottom-[10px]">{{ message }}</span>
</template>

<script>
export default {
    name: 'InputError',
    props:{
        message:{
            type: String,
            required: true,
        },
    },
}
</script>
