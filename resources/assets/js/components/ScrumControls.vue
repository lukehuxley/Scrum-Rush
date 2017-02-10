<template>
    <div>
        <button @click="startScrum" v-show="notStarted" type="submit" class="btn btn-lg btn-success btn-block">Start Scrum</button>
        <button @click="startRound" v-show=" ! roundIsOpen && ! notStarted" type="submit" class="btn btn-lg btn-success btn-block">New Round</button>
        <button @click="endRound" v-show="roundIsOpen" type="submit" class="btn btn-lg btn-danger btn-block">End Round</button>
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

                $.post('/api/scrum-master/start-scrum', {}, function (data) {
                    this.handleResponse(data);
                }.bind(this), 'json');

            },
            endRound() {

                $.post('/api/scrum-master/end-round', {}, function (data) {
                    this.handleResponse(data);
                }.bind(this), 'json');

            },
            startRound() {

                $.post('/api/scrum-master/start-new-round', {}, function (data) {
                    this.handleResponse(data);
                }.bind(this), 'json');

            },
            handleResponse(response) {
                if (response == false)
                    document.location.reload();
                this.notStarted = ( ! response.scrum_started);
                this.roundIsOpen = response.round_open;
            }
        },
        data() {
            return {
                notStarted: this.started,
                roundIsOpen: this.roundOpen
            }
        }
    }
</script>