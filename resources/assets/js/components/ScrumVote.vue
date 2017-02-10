<template>
    <div id="vote-buttons">
        <vote-button disabled :height="rowHeight" @vote-was-cast="castVote(points)" v-for="points in buttons" :points="points"></vote-button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                'buttons': this.availablePoints,
                'buttonsSelected': null,
                'buttonsDisabled': true,
                'rowHeight': '33%'
            };
        },
        props: {
            'availablePoints': {
                type: Array,
                default: [0,1,2,3,5,8,13,21,34]
            },
            'vote': {
                default: null,
                type: Number
            },
            'roundOpen': {
                default: false,
                type: Boolean
            }
        },
        created() {
            if (this.pointScores) this.buttons = JSON.parse(this.pointScores);
            var buttons = this.buttons.length;
            var rows = Math.ceil(buttons/3.0);
            this.rowHeight = (100 / rows) + '%';
        },
        mounted() {
            if (this.roundOpen) this.enableButtons();
            if (this.vote != null) this.highlightButton(this.vote);
        },
        methods: {
            castVote: function(points) {

                this.$children.forEach(button => {
                    if (!button.highlight && button.points == points) {
                        button.highlight = true;
                    }
                });

                this.highlightButton(points);

                $.post('/api/scrum/vote-points', {points: points} , function (registeredVote) {
                    this.highlightButton(registeredVote);
                }.bind(this), 'json');
            },
            highlightButton: function(highlightButton) {
                this.$children.forEach(button => {
                    button.highlight = (button.points == highlightButton);
                });
            },
            disableButtons: function() {
                if (! this.buttonsDisabled) {
                    this.$children.forEach(button => {
                        button.disable = true;
                    });
                    this.buttonsDisabled = true;
                }
            },
            enableButtons: function() {
                if (this.buttonsDisabled) {
                    this.$children.forEach(button => {
                        button.disable = false;
                    });
                    this.buttonsDisabled = false;
                }
            }
        }
    }
</script>
