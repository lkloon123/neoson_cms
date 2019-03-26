<template>
    <div>
        <div class="form-group">
            <label for="menu-label">Label</label>
            <input class="form-control"
                   id="menu-label"
                   name="Label"
                   type="text"
                   v-model="menuLabel"/>
        </div>

        <div class="form-group">
            <span>
                Link: <a :href="`/${itemData.slug}`" target="_blank">{{itemData.title}}</a>
            </span>
        </div>

        <button class="btn btn-danger btn-icon icon-left" @click="removeMenu">
            <i class="fas fa-trash"></i> Remove
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            itemData: {
                type: Object
            }
        },
        computed: {
            menuLabel: {
                get() {
                    return this.itemData.menuLabel;
                },
                set(value) {
                    let cloned = Object.assign({}, this.itemData);
                    cloned.menuLabel = value;
                    this.$store.commit('menu/UPDATE_MENU_ITEM', cloned);
                }
            }
        },
        methods: {
            removeMenu() {
                let cloned = Object.assign({}, this.itemData);
                this.$store.commit('menu/REMOVE_MENU_ITEM', cloned);
            }
        }
    }
</script>

<style scoped>

</style>
