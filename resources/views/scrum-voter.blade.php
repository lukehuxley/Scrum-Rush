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
                'name' => 'Leave Scrum',
                'icon' => 'sign-out',
                'modal' => 'leave-scrum'
            ]
        ]
    ])
    @include('includes.invite-voters-modal')
    @include('includes.modal', [
        'id' => 'leave-scrum',
        'header' => 'Leave Scrum',
        'body' => '<p>Are you sure you want to leave this scrum?</p>',
         'buttons' => [
            [
                'type' => 'a',
                'class' => 'btn-danger',
                'href' => $scrum_rush_url.$scrum_uuid.'/leave-scrum',
                'text' => 'Leave'
            ],
            [
                'type' => 'close_button'
            ]
         ]
    ])
    @include('includes.scrum')
@endsection