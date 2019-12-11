<template>
    <div>
        <div class="mb-4">
            <h4 class="h4 text-center">
                <fa-icon :icon="['fas', 'bullhorn']" class="mr-2" />
                New Campaign
            </h4>
        </div>

        <hr />

        <b-row class="mt-5">
            <b-col cols="10" offset="1">
                <b-form @submit="onSubmit">
                    <b-form-group label="Campaign Name" label-for="campaign-name">
                        <b-form-input v-model="form.name" id="campaign-name" required autofocus />
                    </b-form-group>

                    <b-form-group label="Campaign Message" label-for="campaign-message" class="pt-3 pb-3">
                        <b-form-textarea v-model="form.message" rows="3" max-rows="6" id="campaign-message" required />
                    </b-form-group>

                    <b-row class="mt-4">
                        <b-col cols="6" offset="3">
                            <b-button type="submit" :disabled="loading" variant="primary" size="lg" block>
                                <span v-cloak v-show="loading">
                                    <b-spinner label="Spinning" />
                                </span>
                                <span v-cloak v-show="!loading">
                                    Create Campaign
                                    <fa-icon :icon="['fas', 'chevron-right']" size="xs" class="ml-2" />
                                </span>
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </b-col>
        </b-row>
    </div>
</template>

<script>
export default {
    data: () => ({
        loading: false,
        form: {
            name: "",
            message: ""
        }
    }),

    mounted() {},

    methods: {
        onSubmit() {
            this.createCampaign();
        },

        createCampaign() {
            this.loading = true;

            axios.post('campaigns', this.form)
                .then((response) => {
                    const data = response.data;
                    this.loading = false;
                    this.$router.push('/campaigns');
                })
                .catch((error) => {
                    console.error(error);
                    this.loading = false;
                });
        }
    }
}
</script>

<style lang="scss">
</style>
