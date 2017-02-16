@extends('app')
@section('content')
    @include('includes.navbar', [
        'title' => 'Scrum Rush'
    ])
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3" id="app">
        @include('includes.alert')
        <h2>Joining {{ $scrum_name }} scrum</h2>
        <p>You are one step away from joining the {{ $scrum_name }} scrum.</p>
        <form class="form-horizontal" method="post" action="{{ $scrum_rush_url.$scrum_uuid }}/join-scrum">
            <div class="panel panel-primary">
                <div class="panel-heading">Join Scrum</div>
                <div class="panel-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="scrum-master">Your name</label>
                        <div class="col-sm-10">
                            <input type="text" name="voter_name" value="{{ old('voter_name', $voter_name) }}" class="form-control" id="voter-name" value="{{ $voter_name }}"/>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary btn-block">Join</button>
                </div>
            </div>
        </form>
    </div>
@endsection