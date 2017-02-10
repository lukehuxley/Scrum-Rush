<template>
    <div id="voters">
        <scrum-voter v-for="voter in voters" :round-open="roundOpen" :name="voter.name" :show-status="showVoterStatus" :points="voter.points_vote" :voted="voter.voted" :uuid="voter.uuid"></scrum-voter>
    </div>
</template>

<script>
    export default {
        props: {
            'voterData': {
                required: true,
                type: Array
            },
            'roundOpen': {
                default: false,
                type: Boolean
            },
            'showStatus': {
                default: false,
                type: Boolean
            }
        },
        data() {
            return {
                voters: this.voterData,
                showVoterStatus: this.showStatus
            }
        },
        methods: {
            updateVoters() {
                this.voters.forEach(function(voterData) {
                    this.$children.forEach(voterElem => {
                        if (voterElem.uuid == voterData.uuid) {
                            if (voterData.hasOwnProperty('points_vote')) {
                                voterElem.pointsVoted = voterData.points_vote;
                            }
                            voterElem.hasVoted = voterData.voted;
                        }
                    });
                }.bind(this));
            }
        }
    }
</script>