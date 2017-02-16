@extends('app')
@section('content')
    @include('includes.navbar', [
        'title' => 'Scrum Rush - '.$scrum_name,
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
    @include('includes.invite-voters-modal')
    @include('includes.modal', [
        'id' => 'end-scrum',
        'header' => 'End Scrum',
        'body' => '<p>Are you sure you want to end this scrum?</p>',
         'buttons' => [
            [
                'type' => 'a',
                'class' => 'btn-danger',
                'href' => $scrum_rush_url.$scrum_uuid.'/end-scrum',
                'text' => 'End'
            ],
            [
                'type' => 'close_button'
            ]
         ]
    ])
    @include('includes.scrum', ['scrum_master' => true])
@endsection