<template>
    <div class="valign">
        <h1 class="text-center massive">{{ voteResult }}</h1>
    </div>
</template>

<script>
    export default {
        props: {
            voterData: {
                required: true,
                type: Array
            },
            roundOpen: {
                required: true,
                type: Boolean
            },
            availablePoints: {
                type: Array,
                default: [0,1,2,3,5,8,13,21,34]
            }
        },
        data() {
            return {
                showRoundResults: this.roundOpen,
                scale: this.availablePoints,
                voters: this.voterData
            }
        },
        computed: {
            voteResult() {

                var voterCount = 0;
                var voteSum = 0;

                for (var voter = 0; voter < this.voters.length; voter++) {
                    if (this.voters[voter].points_vote != null) {
                        voteSum += this.voters[voter].points_vote;
                        voterCount++;
                    }
                }

                if (voterCount == 0) return 'No votes';

                var averageVote = Math.ceil(voteSum / voterCount);

                var closest = this.availablePoints.reduce(function (prev, curr) {
                    return (Math.abs(curr - averageVote) <= Math.abs(prev - averageVote) ? curr : prev);
                });

                return closest;
            }
        }
    }
</script>

<style>
    .valign {
        position: relative;
        top: 50%;
        margin-top: -20px;
        transform: translateY(-50%);
    }
    .massive {
        font-size: 500%;
    }
</style>