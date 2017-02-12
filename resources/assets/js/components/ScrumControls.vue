<template>
    <div class="scrum-controls">
        <button @click="startScrum" v-show=" ! started" type="submit" class="btn btn-lg btn-success btn-block">Start Scrum</button>
        <button @click="startRound" v-show=" ! roundOpen && started" type="submit" class="btn btn-lg btn-success btn-block">New Round</button>
        <button @click="endRound" v-show="roundOpen && started" type="submit" class="btn btn-lg btn-danger btn-block">End Round</button>
    </div>
</template>

<script>
    export default {
        props: {
            started: {
                type: Boolean
            },
            roundOpen: {
                type: Boolean
            },
        },
        methods: {
            startScrum() {

                $.post('/api/scrum-master/start-scrum', {}, function (response) {
                    this.$emit('scrum-status-update', response.scrum_status);
                }.bind(this), 'json');

            },
            endRound() {

                $.post('/api/scrum-master/end-round', {}, function (response) {
                    this.$emit('scrum-status-update', response.scrum_status);
                }.bind(this), 'json');

            },
            startRound() {

                $.post('/api/scrum-master/start-new-round', {}, function (response) {
                    this.$emit('scrum-status-update', response.scrum_status);
                }.bind(this), 'json');

            }
        }
    }
</script>

<style>
    .scrum-controls {
        padding-bottom: 15px;
        margin-top: -5px;
    }
</style>