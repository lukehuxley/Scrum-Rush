<template>

    <div class="flex flex-col fill-height">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 flex flex-grow">

            <div v-show=" ! scrumStatus.scrum_started">
                <div class="panel panel-primary">
                    <div class="panel-heading">Invite Voters</div>
                    <div class="panel-body">
                        <div style="display: block;">
                            <h4><i class="fa fa-spin fa-spinner"></i> Waiting for the scrum to start</h4>
                            <p>While waiting for the scrum to start you can invite people to come and vote on this scrum by providing them the following link:</p>
                            <blockquote>
                                <a :href="scrumUrl">Scrum Rush: {{ scrumName }}</a>
                            </blockquote>
                            <p>New voters can join at any time during the scrum.</p>
                            <h4>Voters</h4>
                            <p>Voters who have joined the scrum</p>
                            <scrum-voters :round-open="scrumStatus.round_open" :voter-data="scrumStatus.voters"></scrum-voters>
                        </div>
                    </div>
                </div>
            </div>

            <div v-show="scrumStatus.scrum_started" class="flex flex-col fill-width">

                <div class="flex flex-grow">

                    <div v-show="scrumStatus.round_open" class="panel panel-primary flex flex-col fill-width">
                        <div class="panel-heading flex flex-shrink">Your Vote</div>
                        <div class="panel-body flex flex-grow">
                            <div class="flex flex-grow flex-col">
                                <vote-buttons @scrum-status-update="overrideStatusRefreshUpdate" :availablePoints="scrumData.scale" :vote="scrumStatus.vote"></vote-buttons>
                            </div>
                        </div>
                    </div>

                    <div v-show=" ! scrumStatus.round_open" class="panel panel-primary flex flex-col fill-width">
                        <div class="panel-heading flex flex-shrink">Round Results</div>
                        <div class="panel-body flex flex-grow">
                            <div class="flex flex-grow flex-centre">
                                <round-results :voter-data="scrumStatus.voters" :availablePoints="scrumStatus.scale"></round-results>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="flex flex-shrink">

                    <div class="panel panel-default fill-width">
                        <div class="panel-heading">Voters</div>
                        <div class="panel-body">
                            <scrum-voters :round-open="scrumStatus.round_open" :voter-data="scrumStatus.voters" show-status></scrum-voters>
                        </div>
                    </div>

                </div>

            </div>

        </div>
        <div v-show="scrumMaster" class="col-xs-12 col-sm-5 col-sm-offset-6 col-md-4 col-md-offset-6 col-lg-3 col-lg-offset-6 flex flex-shrink">
            <div class="fill-width fill-height">
                <scrum-controls @scrum-status-update="overrideStatusRefreshUpdate" :started="scrumStatus.scrum_started" :round-open="scrumStatus.round_open"></scrum-controls>
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
            },
            'scrumMaster': {
                type: Boolean
            },
        },
        data() {
            return {
                skipStatusRefreshUpdate: false,
                scrumStatus: this.scrumData
            }
        },
        created() {
            this.statusRefresh();
        },
        methods: {
            overrideStatusRefreshUpdate(status) {
                this.scrumStatus = status;
                this.skipStatusRefreshUpdate = true;
            },
            statusRefresh() {
                this.ajax = $.getJSON('/api/scrum/status', function (data) {

                    if (data == false)
                        document.location.reload();

                    if (this.skipStatusRefreshUpdate) {
                        this.skipStatusRefreshUpdate = false;
                    } else {
                        this.scrumStatus = data;
                    }

                    this.timeout = setTimeout(function() {
                        this.statusRefresh();
                    }.bind(this), 500);

                }.bind(this));
            }
        }
    }
</script>