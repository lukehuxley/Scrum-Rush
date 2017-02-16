@extends('app')
@section('content')
    @include('includes.navbar', [
        'title' => 'Scrum Rush'
    ])
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3" id="app">
        @include('includes.alert')
        <h2>Welcome</h2>
        <p>Voting on your story points has become much easier.</p>
        @if (count($voter_scrums) > 0)
                @include('includes.join-scrum', [
                    'title' => 'Your Scrums',
                    'scrums' => $voter_scrums,
                    'panel_class' => 'panel-warning'
                ])
        @endif
        @if (count($other_scrums) > 0)
                @include('includes.join-scrum', [
                    'title' => 'Active Scrums',
                    'scrums' => $other_scrums,
                    'panel_class' => 'panel-primary'
                ])
        @endif
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
                                <input type="text" name="scrum_name" value="{{ old('name') }}" class="form-control" id="scrum-name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="scrum-master-name">Your name</label>
                            <div class="col-sm-10">
                                <input type="text" name="scrum_master_name" value="{{ old('scrum_master') }}" class="form-control" id="scrum-master-name"/>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-sm-10 col-sm-offset-2">
                                <label>
                                    <input type="checkbox" name="private" {{ (old('private') == 'on') ? 'checked' : '' }}/> Private scrum
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-success btn-block">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection