<template>
    <div>
        <div v-if="articles.length" v-for="article in articles">
            <article-cmp :entity-data="article"></article-cmp>
        </div>
        <div v-if="!articles.length">
            <h3>Статей еще нет :(</h3>
        </div>
    </div>
</template>

<script>
    export default {
        name: "articlesList",

        mounted() {
            axios
                .get('/api/articles')
                .then(response => {
                    this.articles = response.data.articles;
                });
        },

        data: function () {
            return {
                articles: {}
            }
        }
    }
</script>

<style scoped>

</style>
