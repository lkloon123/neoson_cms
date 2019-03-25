<template>
    <footer class="main-footer">
        <div class="footer-left">
            Copyright &copy; 2019
            <div class="bullet"></div>
            NeoSon
        </div>
        <div class="footer-right hidden-xs" v-if="version">
            Version {{version}}
        </div>
    </footer>
</template>

<script>
    export default {
        data: () => ({
            version: null
        }),
        created() {
            axios.options('/api/version')
                .then(response => {
                    this.version = response.data.version;
                });
        }
    }
</script>

<style scoped>
    .main-footer {
        background-color: white;
        display: block;
        height: 60px;
        margin-top: 35px;
    }
</style>
