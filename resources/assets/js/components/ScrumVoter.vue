<template>
    <div class="voter-chip-grp" :class="{ 'voter-status': showStatus, 'voter-success': hasVoted, 'voter-default': ! hasVoted }">
        <div class="voter-chip">{{ voterName }}</div>
        <div class="voter-chip">
            <div class="voter-chip-status" v-show="(roundOpen && ! canShowPoints && ! hasVoted)">
                <i class="fa fa-fw fa-spinner fa-spin"></i>
            </div>
            <div class="voter-chip-status" v-show="(roundOpen && ! canShowPoints && hasVoted)">
                <i class="fa fa-fw fa-check"></i>
            </div>
            <div class="voter-chip-status" v-show="(canShowPoints)">
                {{ pointsVoted }}
            </div>
            <div class="voter-chip-status" v-show="( ! roundOpen && ! canShowPoints)">
                <i class="fa fa-fw fa-times"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'name': {
                type: String,
                required: true
            },
            'uuid': {
                type: String,
                required: true
            },
            'points': {
                type: Number,
                default: null
            },
            'voted': {
                type: Boolean,
                default: false
            },
            'showStatus': {
                default: false,
                type: Boolean
            },
            'roundOpen': {
                default: false,
                type: Boolean
            }
        },
        data() {
            return {
                'voterName': this.name,
                'hasVoted': this.voted,
                'pointsVoted': this.points
            }
        },
        computed: {
            canShowPoints() {
                return (this.pointsVoted != null);
            }
        }
    };
</script>