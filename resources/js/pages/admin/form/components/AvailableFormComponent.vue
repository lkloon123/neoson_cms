<template>
    <card>
        <template v-slot:header>
            <h4>Form Component</h4>
        </template>

        <list-content-loading v-if="isLoading"></list-content-loading>

        <Container group-name="form" behaviour="copy" :get-child-payload="getChildPayload" v-else>
            <Draggable v-for="form in availableFormList" class="row text-center mb-3" :key="form.id">
                <div class="col-12 item-drag">
                    <div class="alert alert-light mb-0">{{form.componentLabel}}</div>
                </div>
            </Draggable>
        </Container>
    </card>
</template>

<script>
    import Card from '@components/Card';
    import {Container, Draggable} from 'vue-smooth-dnd';
    import Mixin from '../mixin';
    import ListContentLoading from '@components/content_loading/ListContentLoading';

    export default {
        mixins: [Mixin],
        data: () => ({
            availableFormList: [
                {id: '1', type: 'text', label: 'Text', componentLabel: 'Text', isRequired: false},
                {id: '2', type: 'text_area', label: 'Text Area', componentLabel: 'Text Area', isRequired: false},
                {id: '3', type: 'submit_button', label: 'Submit', componentLabel: 'Submit'}
            ]
        }),
        methods: {
            getChildPayload(index) {
                return this.availableFormList[index];
            }
        },
        components: {
            Card, Container, Draggable, ListContentLoading
        }
    }
</script>

<style scoped>
    .item-drag {
        cursor: move;
    }
</style>
