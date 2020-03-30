<template>
    <div class="article">
        <div class="article-title">
            <h2>{{ articleData.title }}</h2>
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
                        <p>Автор: <b>{{ articleData.author.name }}</b></p>
                    </div>
                </div>
                <div class="col-6">
                    Лайков: {{ this.articleData.likes_count }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "article-cmp",

        props: [
            'article-data',
        ],
        mounted() {
            this.userLoggedIn = window.userLoggedIn;
            this.userID = window.userID;

            this.content = this.articleData.content;
            if (this.articleData.content.length >= 250) {
                this.content = this.articleData.content.slice(0,248) + '...';
            }

            if (this.userID) {
                axios
                    .post('/api/likes/detect', {
                        userID: this.userID,
                        entityType: 'article',
                        entityId: this.articleData.id,
                    })
                    .then((response) => {
                        this.isActivated = response.data.detected;
                    });
            }

            this.getLikes();
        },

        data: function () {
            return {
                userLoggedIn: false,
                isActivated: false,
                content: '',
            }
        },

        methods: {
            toggleLike: function () {
                this.isActivated = !this.isActivated;

                axios
                    .post('/api/likes', {
                        userID: this.userID,
                        entityType: 'article',
                        entityId: this.articleData.id,
                    })
                    .then(() => {
                        this.getLikes();
                    });
            },

            getLikes: function () {
                axios
                    .get('/api/likes', {
                        params: {
                            entityType: 'article',
                            entityId: this.articleData.id,
                        }
                    })
                    .then(response => {
                        this.articleData.likes_count = response.data.count;
                    });
            },
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
