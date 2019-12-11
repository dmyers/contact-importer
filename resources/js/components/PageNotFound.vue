<template>
    <div>
        <div class="mb-4">
            <h4 class="h4 text-center">
                Page Not Found
            </h4>
        </div>

        <hr />

        <b-row class="mt-5">
            <b-col cols="10" offset="1">
                <b-alert variant="warning" class="p-2 text-center" show>
                    <p class="mt-3 mb-3">
                        The page you requested was not found.
                    </p>
                </b-alert>
            </b-col>
        </b-row>
    </div>
</template>

<script>
export default {
    data: () => ({}),

    mounted() {},

    methods: {}
}
</script>

<style lang="scss">
</style>
