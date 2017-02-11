<template>
    <div class="flex flex-col fill-height">

        <div class="flex flex-grow">

            <div v-show=" ! scrumStarted" class="panel panel-primary flex flex-grow flex-col fill-width">
                <div class="panel-heading flex flex-shrink">Invite Voters</div>
                <div class="panel-body flex flex-grow">
                    <div style="display: block;">
                        <h4><i class="fa fa-spin fa-spinner"></i> Waiting for the scrum to start</h4>
                        <p>While waiting for the scrum to start you can invite people to come and vote on this scrum by providing them the following link:</p>
                        <blockquote>
                            <a :href="scrumUrl">Scrum Rush: {{ scrumName }}</a>
                        </blockquote>
                        <p>New voters can join at any time during the scrum.</p>
                        <h4>Voters</h4>
                        <p>Voters who have joined the scrum</p>
                        <scrum-voters :round-open="roundOpen" :voter-data="scrumData.voters"></scrum-voters>
                    </div>
                </div>
            </div>

            <div v-show="roundOpen && scrumStarted" class="panel panel-primary flex flex-grow flex-col fill-width">
                <div class="panel-heading flex flex-shrink">Your Vote</div>
                <div class="panel-body flex flex-grow">
                    <div class="flex flex-grow flex-col">
                        <scrum-vote :round-open="roundOpen" :availablePoints="scrumData.scale" :vote="scrumData.vote"></scrum-vote>
                    </div>
                </div>
            </div>

            <div v-show=" ! roundOpen && scrumStarted" class="panel panel-primary flex flex-grow flex-col fill-width">
                <div class="panel-heading flex flex-shrink">Round Results</div>
                <div class="panel-body flex flex-grow">
                    <div class="flex flex-grow flex-centre">
                        <round-results :voter-data="scrumData.voters" :availablePoints="scrumData.scale" :round-open="roundOpen"></round-results>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex flex-shrink">

            <div v-show="scrumStarted" class="panel panel-default fill-width">
                <div class="panel-heading">Voters</div>
                <div class="panel-body">
                    <scrum-voters :round-open="roundOpen" :voter-data="scrumData.voters" show-status></scrum-voters>
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
            },
            'scrumName': {
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

                    console.log(this.$children);

                    // Voters at start
                    this.$children[0].voters = data.voters;
                    this.$children[0].updateVoters();

                    // Buttons
                    if (data.round_open) {
                        this.$children[1].enableButtons();
                    } else {
                        this.$children[1].disableButtons();
                        this.$children[1].highlightButton(null);
                    }

                    // Round results
                    this.$children[2].showRoundResults = (data.round_open == false);
                    this.$children[2].voters = data.voters;

                    // Voters during scrum
                    this.$children[3].voters = data.voters;
                    this.$children[3].updateVoters();

                    setTimeout(function() {
                        this.updateData();
                    }.bind(this), 500);

                }.bind(this));
            }
        }
    }
</script>