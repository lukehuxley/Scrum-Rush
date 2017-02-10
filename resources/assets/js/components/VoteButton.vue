<template>
    <div class="col-xs-4" :style="{ height: buttonHeight }">
        <button :disabled="disable" class="btn btn-block btn-lg" :class="{ 'btn-success': highlight, 'btn-default': ! highlight }" @click="castVote">{{ points }}</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                'highlight': this.selected,
                'disable': this.disabled,
                'buttonHeight': this.height
            }
        },
        props: {
            'points': {required: true},
            'selected': {default: false},
            'disabled': {},
            'height': {default: '33%'}
        },
        methods: {
            castVote: function() {
                this.$emit('vote-was-cast');
            }
        }
    }
</script>