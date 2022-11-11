<template>
<a
    :href="getElementUrl"
    class="text-sm text-inherit"
    v-html="getFormattedText"
/>
</template>

<script>
export default {
    name: 'FilteredElement',
    props: {
        element: {
            type: Object,
            required: true,
        },
        locale: {
            type: String,
            required: true,
        },
        elementType: {
            type: String,
            required: true,
        },
        keyword: {
            type: String,
            required: false,
            default: '',
        },
    },
    computed: {
        getElementUrl(){
            return '/' + this.locale + (this.elementType == 'category' ? '/search/category/' :
                this.elementType == 'knowledge' ? '/search/knowledge/' : '/search/download/')
                + this.element.id;
        },
        getFormattedText(){
            var formattedText = this.elementType == 'category' ? this.element.path :
                this.elementType == 'knowledge' ? this.element.title: this.element.name;
            var keyword = this.keyword.trim().replace(new RegExp('(\\?\\.|\\?\\*)', 'gm'),'');
            if(keyword.length > 0){
                keyword.split(' ').filter((v,i,a) => v.length > 0 && a.indexOf(v) === i)
                    .sort((a,b) => b.length - a.length)
                    .every(part => formattedText = formattedText.replace(new RegExp(part, 'gmi'), (match) => `?.${match}?*`));

                formattedText = formattedText.replace(new RegExp('\\?\\*\\?\\.','gm'), '');
                formattedText = formattedText.replace(new RegExp('\\?\\.', 'gm'), '<span class=highlight-text>');
                formattedText = formattedText.replace(new RegExp('\\?\\*', 'gm'), '</span>');
            }
            return formattedText;
        },
    },
}
</script>
