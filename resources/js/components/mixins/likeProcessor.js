export default {
    methods: {
        getLikes: function (type) {
            axios
                .get('/api/likes', {
                    params: {
                        entityType: type,
                        entityId: this.entityData.id,
                    }
                })
                .then(response => {
                    this.entityData.likes_count = response.data.count;
                });
        },

        toggleLike: function () {
            this.isActivated = !this.isActivated;

            axios
                .post('/api/likes', {
                    userID: this.userID,
                    entityType: this.entityType,
                    entityId: this.entityData.id,
                })
                .then(() => {
                    this.getLikes(this.entityType);
                });
        },
    },

    mounted() {
        this.userLoggedIn = window.userLoggedIn;
        this.userID = window.userID;

        if (this.userID) {
            axios
                .post('/api/likes/detect', {
                    userID: this.userID,
                    entityType: this.entityType,
                    entityId: this.entityData.id,
                })
                .then((response) => {
                    this.isActivated = response.data.detected;
                });
        }

        this.getLikes(this.entityType);
    },

    data: function () {
        return {
            userLoggedIn: false,
            isActivated: false,
        }
    },
}