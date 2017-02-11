@extends('app')
@section('content')
    @include('navbar', [
        'title' => 'Scrum Rush'
    ])
    <div class="container" id="app">
        @include('alert')
        <h2>Welcome</h2>
        <p>Voting on your story points has become much easier. You can create a scrum without need to sign up using the form below.</p>
        <div class="section">
            <form class="form-horizontal" method="post" action="create-scrum">
                <div class="panel panel-primary">
                    <div class="panel-heading">Create a Scrum</div>
                    <div class="panel-body">
                        <p>When you create a scrum you will become the scrum master.</p>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="scrum-name">Scrum name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="scrum-name"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="scrum-master">Your name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="scrum_master" value="{{ old('scrum_master') }}" class="form-control" id="scrum-master"/>
                                </div>
                            </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary btn-block">Create</button>
                    </div>
                </div>
            </form>
        </div>
</div>
@endsection