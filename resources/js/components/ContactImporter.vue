<template>
    <div>
        <h4 class="h4 mb-4 text-center">
            <fa-icon :icon="['fas', 'users']" class="mr-2" />
            Contact Importer
        </h4>

        <hr />

        <b-row class="mt-5">
            <b-col cols="12" offset="0">
                <file-uploader v-cloak v-show="steps.fileUpload" @uploaded="mapFields" />

                <field-mapper v-cloak v-show="steps.fieldMap" @imported="confirmImport" :fileImport="fileImport" />

                <div v-cloak v-show="steps.importDone">
                    <b-row>
                        <b-col cols="10" offset="1">
                            <b-alert variant="success" class="p-4 text-center" show>
                                <h4 class="h4">
                                    <fa-icon :icon="['fas', 'check']" class="mr-2" />
                                    Contacts Imported
                                </h4>
                                <p class="mt-3 mb-1">
                                    The contacts were imported with the mapping you selected.
                                </p>
                            </b-alert>
                        </b-col>
                    </b-row>
                </div>
            </b-col>
        </b-row>
    </div>
</template>

<script>
export default {
    components: {
        'file-uploader': require('./FileUploader').default,
        'field-mapper': require('./FieldMapper').default
    },

    data: () => ({
        steps: {
            fileUpload: true,
            fieldMap: false,
            importDone: false
        },
        fileImport: {
            fileId: '',
            fileName: '',
            itemCount: 0,
            fields: []
        }
    }),

    mounted() {},

    methods: {
        mapFields(data) {
            this.fileImport = data;
            this.steps.fileUpload = false;
            this.steps.fieldMap = true;
        },

        confirmImport() {
            this.steps.fileUpload = false;
            this.steps.fieldMap = false;
            this.steps.importDone = true;
        }
    }
}
</script>

<style lang="scss">
.alert.alert-success {
    background-color: #e7f5ea;
}
</style>
