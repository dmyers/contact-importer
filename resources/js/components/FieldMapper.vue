<template>
    <div>
        <h4 class="h4 text-muted text-center mb-4">
            Map Contact Fields
        </h4>

        <b-row>
            <b-col cols="8" offset="2">
                <b-alert variant="warning" class="text-center mb-1 alert-contacts-found" show>
                    Found {{ fileImport.itemCount }} contacts from "{{ fileImport.fileName }}".
                </b-alert>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="50%">Spreadsheet Field</th>
                            <th width="50%">Import Field</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="field in fileImport.fields" :key="field.slug">
                            <td style="font-size: 110%;">
                                <label :for="field.slug + '_field'" class="float-left mt-1 mb-0">
                                    {{ field.name }}
                                </label>
                                <fa-icon :icon="['fas', 'long-arrow-alt-right']" size="2x" class="float-right mt-0 text-muted" />
                                <div class="clearfix"></div>
                            </td>
                            <td>
                                <select v-model="field.map" :id="field.slug + '_field'" class="form-control">
                                    <option v-for="(coreFieldLabel, coreFieldName) in coreFields" :key="coreFieldName" :value="coreFieldName">
                                        {{ coreFieldLabel }}
                                    </option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <b-row class="mt-4">
                    <b-col cols="8" offset="2">
                        <b-button @click="onContinueClick" :disabled="loading" variant="primary" size="lg" block>
                            <span v-cloak v-show="loading">
                                <b-spinner label="Spinning"></b-spinner>
                            </span>
                            <span v-cloak v-show="!loading">
                                Import {{ fileImport.itemCount }} Contacts
                                <fa-icon :icon="['fas', 'chevron-right']" size="xs" class="ml-2" />
                            </span>
                        </b-button>
                    </b-col>
                </b-row>
            </b-col>
        </b-row>
    </div>
</template>

<script>
export default {
    props: {
        fileImport: {
            required: true
        }
    },

    data: () => ({
        loading: false
    }),

    computed: {
        coreFields() {
            const coreFields = window.App.core_fields;
            coreFields.custom = "Custom";
            return coreFields;
        }
    },

    created() {},

    mounted() {},

    methods: {
        onContinueClick() {
            this.runImport();
        },

        runImport() {
            this.loading = true;

            axios.post('contacts/import', this.fileImport)
                .then((response) => {
                    const data = response.data;
                    this.$emit('imported');
                    this.loading = false;
                })
                .catch((error) => {
                    console.error(error);
                    this.loading = false;
                });
        }
    }
}
</script>

<style lang="scss" scoped>
.alert-contacts-found {
    background-color: #fff8e2;
}
.table thead tr {
    background-color: #f3f5f7;
}
.table tbody tr {
    background-color: #f9fafb;
}
.table tbody .text-muted {
    color: #c2c4c5 !important;;
}
</style>
