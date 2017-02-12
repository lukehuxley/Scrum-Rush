<template>
    <div class="flex flex-grow flex-row flex-wrap vote-buttons">
        <vote-button :height="rowHeight" @vote-was-cast="castVote(points)" v-for="points in buttons" :points="points"></vote-button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                'buttons': this.availablePoints,
                'buttonsSelected': null,
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
            }
        },
        watch: {
            vote: function(newVote) {
                this.highlightButton(newVote);
            }
        },
        created() {
            if (this.pointScores) this.buttons = JSON.parse(this.pointScores);
            var buttons = this.buttons.length;
            var rows = Math.ceil(buttons/3.0);
            this.rowHeight = (100 / rows) + '%';
        },
        methods: {
            castVote: function(points) {

                this.highlightButton(points);

                $.post('/api/scrum/vote-points', {points: points} , function (response) {
                    this.highlightButton(response.request_response);
                    this.$emit('scrum-status-update', response.scrum_status);
                }.bind(this), 'json');

            },
            highlightButton: function(highlightButton) {
                this.$children.forEach(button => {
                    button.highlight = (button.points == highlightButton);
                });
            }
        }
    }
</script>
