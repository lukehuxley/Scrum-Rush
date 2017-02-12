@extends('app')
@section('content')
    @include('navbar', [
        'title' => $scrum_name.' - '.$scrum_master,
        'menu' => [
            [
                'name' => 'Invite Voters',
                'icon' => 'user-plus',
                'modal' => 'invite-voters'
            ],
            [
                'name' => 'End Scrum',
                'icon' => 'window-close',
                'modal' => 'end-scrum'
            ]
        ]
    ])
    <div class="modal fade" id="invite-voters" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Invite Voters</h4>
                </div>
                <div class="modal-body">
                    <p>Invite people to come and vote on this scrum by providing them the following link:</p>
                    <blockquote><a href="{{ $scrum_url }}">Scrum Rush: {{ $scrum_name }}</a></blockquote>
                    <p>New voters can join at any time.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="end-scrum" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">End Scrum</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to end this scrum?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a href="/scrum-master/end-scrum" class="btn btn-danger">End</a>
                </div>
            </div>
        </div>
    </div>
    <div id="app" class="fill-height">
        <scrum scrum-master :scrum-data="{{ $scrum_data }}" scrum-url="{{ $scrum_url }}" scrum-name="{{ $scrum_name }}"></scrum>
    </div>
@endsection