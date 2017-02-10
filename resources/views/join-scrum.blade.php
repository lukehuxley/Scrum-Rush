@extends('app')
@section('header')
    @include('navbar', [
        'title' => 'Scrum Rush'
    ])
@endsection
@section('body')
    <div class="container" id="app">
        <h2>Joining {{ $scrum_name }}</h2>
        <p>You are one step away from joining the {{ $scrum_name }} scrum.</p>
        <form class="form-horizontal" method="post">
            <div class="panel panel-primary">
                <div class="panel-heading">Join Scrum</div>
                <div class="panel-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="scrum-master">Your name</label>
                        <div class="col-sm-10">
                            <input type="text" name="voter_name" value="{{ old('voter_name') }}" class="form-control" id="voter-name" value="{{ $voter_name }}"/>
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