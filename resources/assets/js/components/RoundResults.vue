<template>
    <h1 class="text-center massive">{{ voteResult }}</h1>
</template>

<script>
    export default {
        props: {
            voterData: {
                required: true,
                type: Array
            },
            availablePoints: {
                type: Array,
                default: [0,1,2,3,5,8,13,21,34]
            }
        },
        computed: {
            voteResult() {

                var voterCount = 0;
                var voteSum = 0;

                for (var voter = 0; voter < this.voterData.length; voter++) {
                    if (this.voterData[voter].points_vote != null) {
                        voteSum += this.voterData[voter].points_vote;
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
    .massive {
        font-size: 500%;
        display: block;
        width: 100%;
    }
</style>