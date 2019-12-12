<template>
    <div>
        <div class="mb-4 text-center">
            <h4 class="h4 mb-0 float-left">
                <fa-icon :icon="['fas', 'bullhorn']" class="mr-2" />
                Campaign Manager
            </h4>

            <div class="float-right">
                <b-button @click="$router.push('campaigns/new')" variant="outline-primary" size="sm">
                    <fa-icon :icon="['fas', 'plus']" size="sm" class="mr-1" />
                    New Campaign
                </b-button>
            </div>

            <div class="clearfix"></div>
        </div>

        <hr />

        <b-row v-if="campaigns.length > 0" class="mt-5">
            <b-col cols="12">
                <div v-for="campaign in campaigns" :key="campaign.id">
                    <b-card class="mb-2">
                        <div class="float-left">
                            <h5 class="h5 mb-0">
                                <fa-icon :icon="['fas', 'podcast']" size="sm" class="mr-1" />
                                {{ campaign.name }}
                                <b-badge>{{ campaign.phone }}</b-badge>
                            </h5>

                            <small class="mt-2 text-muted">
                                Created: {{ campaign.created_at }}
                            </small>
                        </div>

                        <div class="float-right">
                            <div v-if="campaign.published_at" class="mt-2 text-right text-muted">
                                <h6 class="mb-0">
                                    <strong>{{ campaign.messages_count }}</strong> messages
                                </h6>

                                <small class="mt-2">
                                    Published: {{ campaign.created_at }}
                                </small>
                            </div>

                            <b-button v-if="!campaign.published_at" @click="publishCampaign(campaign)" variant="outline-success" size="sm">
                                <span v-cloak v-show="campaign.loading">
                                    <b-spinner label="Spinning" small />
                                </span>
                                <span v-cloak v-show="!campaign.loading">
                                    <fa-icon :icon="['fas', 'clock']" size="sm" class="mr-1" />
                                    Publish
                                </span>
                            </b-button>
                        </div>

                        <div class="clearfix"></div>
                    </b-card>
                </div>
            </b-col>
        </b-row>

        <b-row v-else class="mt-5">
            <b-col cols="10" offset="1">
                <b-alert variant="warning" class="p-2 text-center" show>
                    <p class="mt-3 mb-3">
                        There are no campaigns created yet.
                    </p>
                </b-alert>
            </b-col>
        </b-row>
    </div>
</template>

<script>
export default {
    data: () => ({
        campaigns: [],
        loading: false
    }),

    mounted() {
        this.listCampaigns();
    },

    methods: {
        listCampaigns(campaign) {
            this.loading = true;

            axios.get('campaigns')
                .then((response) => {
                    const data = response.data;
                    this.campaigns = data;
                    this.loading = false;
                })
                .catch((error) => {
                    console.error(error);
                    this.loading = false;
                });
        },

        publishCampaign(campaign) {
            Vue.set(campaign, 'loading', true);

            axios.post('campaigns/' + campaign.id + '/publish')
                .then((response) => {
                    const data = response.data;
                    Vue.set(campaign, 'published_at', data.campaign.published_at);
                    Vue.set(campaign, 'loading', false);
                })
                .catch((error) => {
                    console.error(error);
                    Vue.set(campaign, 'loading', false);
                });
        }
    }
}
</script>

<style lang="scss">
</style>
