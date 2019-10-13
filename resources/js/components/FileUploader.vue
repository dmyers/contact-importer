<template>
    <div class="text-center mt-4">
        <fa-icon :icon="['far', 'file-excel']" size="5x" class="mb-4 text-muted" />

        <h3 class="h3 mb-3">Import Spreadsheet</h3>

        <input @change="onFileChange" type="file" name="file" ref="file" accept=".csv" />

        <b-row class="mt-4">
            <b-col cols="4" offset="4">
                <b-button @click="onUploadClick" :disabled="loading" variant="primary" size="lg" block>
                    <span v-cloak v-show="loading">
                        <b-spinner label="Spinning"></b-spinner>
                    </span>
                    <span v-cloak v-show="!loading">
                        Select File
                        <fa-icon :icon="['fas', 'chevron-right']" size="xs" class="ml-2" />
                    </span>
                </b-button>
            </b-col>
        </b-row>
    </div>
</template>

<script>
// import FileUpload from 'vue-upload-component';

export default {
    // components: {
    //     FileUpload,
    // },

    data: () => ({
        loading: false
    }),

    mounted() {},

    methods: {
        onUploadClick() {
            this.$refs.file.click();
        },

        onFileChange($event) {
            const file = $event.target.files[0];
            this.uploadFile(file);
        },

        uploadFile(file) {
            this.loading = true;

            const formData = new FormData();
            formData.append('file', file);

            axios.post('contacts/upload', formData)
                .then((response) => {
                    const data = response.data;
                    this.$emit('uploaded', data);
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
input[type="file"] {
    display: none;
}
</style>
