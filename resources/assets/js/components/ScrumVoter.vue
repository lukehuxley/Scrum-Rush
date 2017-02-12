<template>
    <div class="voter-chip-grp" :class="{ 'voter-status': showStatus, 'voter-success': voted, 'voter-default': ! voted }">
        <div class="voter-chip">{{ name }}</div>
        <div class="voter-chip">
            <div class="voter-chip-status" v-show="(roundOpen && ! voted)">
                <i class="fa fa-fw fa-spinner fa-spin"></i>
            </div>
            <div class="voter-chip-status" v-show="(roundOpen && voted && points == null)">
                <i class="fa fa-fw fa-check"></i>
            </div>
            <div class="voter-chip-status" v-show="points != null">
                {{ points }}
            </div>
            <div class="voter-chip-status" v-show="( ! roundOpen && ! voted)">
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
        }
    };
</script>