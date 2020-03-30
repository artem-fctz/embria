<template>
    <div>
        <div v-if="photos.length" v-for="photo in photos">
            <photo-cmp :entity-data="photo"></photo-cmp>
        </div>
        <div v-if="!photos.length">
            <h3>Фотографий еще нет :(</h3>
        </div>
    </div>
</template>

<script>
    export default {
        name: "photosList",

        mounted() {
            axios
                .get('/api/photos')
                .then(response => {
                    this.photos = response.data.photos;
                });
        },

        data: function () {
            return {
                photos: {}
            }
        }
    }
</script>

<style scoped>

</style>
