<template>
    <div style="height: 700px;">
        <file-manager></file-manager>
    </div>
</template>

<script>
    export default {
        created() {
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'File Manager');
        }
    }
</script>

<style>
    .fm .btn-secondary:disabled {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }

    .fm .btn-secondary {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        box-shadow: initial;
    }

    .fm .btn-secondary:not(:disabled):hover {
        background-color: #5a6268 !important;
        border-color: #545b62 !important;
    }

    .fm .btn-secondary:not(:disabled):not(.disabled).active {
        background-color: #545b62 !important;
        border-color: #4e555b !important;
    }

    .fm .btn:disabled {
        cursor: not-allowed;
    }

    .fm .btn-danger:disabled:hover {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }

    .fm .btn-info:disabled:hover {
        background-color: #17a2b8 !important;
        border-color: #17a2b8 !important;
    }

    .fm .btn-default {
        box-shadow: 0 2px 6px #e6ecf1 !important;
        background-color: #e3eaef !important;
        border-color: #e3eaef !important;
        color: #191d21 !important;
    }

    .fm .btn-default:hover {
        background-color: #c3d2dc !important;
    }
</style>
