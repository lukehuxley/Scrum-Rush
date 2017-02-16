@include('includes.modal', [
    'id' => 'invite-voters',
    'header' => 'Invite Voters',
    'body' => '<p>Invite people to come and vote on this scrum by providing them the following link:</p>
        <blockquote><a href="'.$scrum_rush_url.$scrum_uuid.'">Scrum Rush: '.$scrum_name.'</a></blockquote>
        <p>New voters can join at any time.</p>',
     'buttons' => [
        [
            'type' => 'close_button'
        ]
     ]
])