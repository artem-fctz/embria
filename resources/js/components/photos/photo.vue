<template>
    <div class="photo">
        <div class="photo-title">
            <h2>{{ photoData.title }}</h2>
            <div v-if="!userLoggedIn" class="menu" id="non-active-menu" data-toggle="tooltip" data-placement="top" title="Залогиньтесь, что-бы лайкать.">

            </div>
            <div
                v-if="userLoggedIn"
                class="d-inline-block"
                :class="{'active': isActivated}"
                @click="toggleLike"
            >
                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
            </div>
        </div>
        <div class="photo-content">
            <img :src="photoUrl" :alt="photoData.title">
            <div class="photo-footer">
                <div class="row">
                    <div class="col-6">
                        <div class="author">
                            <p>Автор: <b>{{ photoData.author.name }}</b></p>
                        </div>
                    </div>
                    <div class="col-6">
                        Лайков: {{ this.photoData.likes_count }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "photo-cmp",

        props: [
            'photo-data',
        ],
        mounted() {
            this.userLoggedIn = window.userLoggedIn;
            this.userID = window.userID;

            this.photoUrl = `/storage/${this.photoData.media[0].id}/${this.photoData.media[0].file_name}`;

            if (this.userID) {
                axios
                    .post('/api/likes/detect', {
                        userID: this.userID,
                        entityType: 'photo',
                        entityId: this.photoData.id,
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
                photoUrl: '',
            }
        },

        methods: {
            toggleLike: function () {
                this.isActivated = !this.isActivated;

                axios
                    .post('/api/likes', {
                        userID: this.userID,
                        entityType: 'photo',
                        entityId: this.photoData.id,
                    })
                    .then(() => {
                        this.getLikes();
                    });
            },

            getLikes: function () {
                axios
                    .get('/api/likes', {
                        params: {
                            entityType: 'photo',
                            entityId: this.photoData.id,
                        }
                    })
                    .then(response => {
                        this.photoData.likes_count = response.data.count;
                    });
            },
        },
    }
</script>

<style scoped>
    .photo {
        background-color: #ffffff;
        padding: 5px 7px;
        margin: 10px;
        border-radius: 6px;
        box-shadow: 1px 4px 10px rgba(0,0,0,0.2);
        transition: all 0.2s;
    }

    .photo:hover {
        box-shadow: 1px 2px 2px rgba(0,0,0,0.16);
        transition: all 0.2s;
    }

    .photo-title {
        color: #bbb;
        border-bottom: 1px solid #aaa;
    }

    .photo-title .d-inline-block {
        width: 23px;
        text-align: center;
        display: inline-block;
        border-radius: 10px;
        cursor: pointer;
    }

    .photo-title .d-inline-block.active {
        background-color: lightcyan;
    }

    .photo-title h2 {
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

    .photo-content img {
        max-width: 100%;
        max-height: 100%;
    }
</style>
