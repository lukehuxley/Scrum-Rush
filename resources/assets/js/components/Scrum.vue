<template>
    <div class="flex-row">
        <div class="flex-col">
            <div v-show=" ! roundOpen && scrumStarted" class="panel panel-primary flex-col">
                <div class="panel-heading">Round Results</div>
                <div class="panel-body flex-grow">
                    <round-results :voter-data="scrumData.voters" :availablePoints="scrumData.scale" :round-open="roundOpen"></round-results>
                </div>
            </div>
            <div v-show="roundOpen && scrumStarted" class="panel panel-primary flex-col">
                <div class="panel-heading">Your Vote</div>
                <div class="panel-body flex-grow">
                    <scrum-vote :round-open="roundOpen" :availablePoints="scrumData.scale" :vote="scrumData.vote"></scrum-vote>
                </div>
            </div>
            <div v-show=" ! scrumStarted" class="panel panel-primary flex-col">
                <div class="panel-heading">Invite Voters</div>
                <div class="panel-body flex-grow">
                    <h4><i class="fa fa-spin fa-spinner"></i> Waiting for the scrum to start</h4>
                    <p>While waiting for the scrum to start you can invite people to come and vote on this scrum by providing them the following link:</p>
                    <blockquote>
                        <a :href="scrumUrl">{{ scrumUrl }}</a>
                    </blockquote>
                    <p>New voters can join at any time during the scrum.</p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Voters</div>
                <div class="panel-body">
                    <scrum-voters :round-open="roundOpen" :voter-data="scrumData.voters" :show-status="scrumStarted"></scrum-voters>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'scrumData': {
                required: true,
                type: Object
            },
            'scrumUrl': {
                required: true,
                type: String
            }
        },
        data() {
            return {
                scrumStarted: this.scrumData.scrum_started,
                roundOpen: this.scrumData.round_open
            }
        },
        created() {
            this.updateData();
        },
        methods: {
            updateData() {
                $.getJSON('/api/scrum/status', function (data) {

                    if (data == false)
                        document.location.reload();

                    this.roundOpen = data.round_open;
                    this.scrumStarted = data.scrum_started;

                    // Round results
                    this.$children[0].showRoundResults = (data.round_open == false);
                    this.$children[0].voters = data.voters;

                    // Buttons
                    if (data.round_open) {
                        this.$children[1].enableButtons();
                    } else {
                        this.$children[1].disableButtons();
                        this.$children[1].highlightButton(null);
                    }

                    // Voters
                    this.$children[2].voters = data.voters;
                    this.$children[2].updateVoters();
                    this.$children[2].showVoterStatus = (data.scrum_started);

                    setTimeout(function() {
                        this.updateData();
                    }.bind(this), 500);

                }.bind(this));
            }
        }
    }
</script>