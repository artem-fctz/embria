<template>
    <div class="article">
        <div class="article-title">
            <h2>{{ entityData.title }}</h2>
            <div v-if="!userLoggedIn" class="menu" id="non-active-menu" data-toggle="tooltip" data-placement="top" title="Залогиньтесь, что-бы лайкать.">

            </div>
            <div
                v-if="userLoggedIn"
                class="d-inline-block va-top"
                :class="{'active': isActivated}"
                @click="toggleLike"
            >
                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
            </div>
        </div>
        <div class="article-content">
            <p>{{ this.content }}</p>
        </div>
        <div class="article-footer">
            <div class="row">
                <div class="col-6">
                    <div class="author">
                        <p>Автор: <b>{{ entityData.author.name }}</b></p>
                    </div>
                </div>
                <div class="col-6">
                    Лайков: {{ this.entityData.likes_count }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import likeProcessor from '../mixins/likeProcessor'

    export default {
        name: "article-cmp",

        props: [
            'entity-data',
        ],

        mixins: [
            likeProcessor
        ],

        mounted() {
            this.content = this.entityData.content;
            if (this.entityData.content.length >= 250) {
                this.content = this.entityData.content.slice(0,248) + '...';
            }
        },

        data: function () {
            return {
                entityType: 'article',
                content: '',
            }
        },

        methods: {
        },
    }
</script>

<style scoped>
    .article {
        background-color: #ffffff;
        margin: 10px;
        border-radius: 6px;
        box-shadow: 1px 4px 10px rgba(0,0,0,0.2);
        transition: all 0.2s;
    }

    .article:hover {
        box-shadow: 1px 2px 2px rgba(0,0,0,0.16);
        transition: all 0.2s;
    }

    .article-title {
        padding: 5px 10px;
        color: #bbb;
        border-bottom: 1px solid #e6f3ff;
    }

    .article-title .d-inline-block {
        width: 23px;
        text-align: center;
        display: inline-block;
        border-radius: 10px;
        cursor: pointer;
        margin: 5px;
    }

    .article-title .d-inline-block.active {
        background-color: lightcyan;
    }

    .article-title h2 {
        margin-bottom: 0;
        display: inline-block;
        width: 90%;
    }

    .menu {
        display: inline-block;
        text-align: center;
        padding: 5px;
        width: 30px;
        border-radius: 25px;
        background-color: antiquewhite;
    }
    .menu::before {
        content: '...';
    }
</style>
