@if(isset($errors))
    @foreach($errors->all() as $error)
        <div id="asd" class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ $error }}
        </div>
    @endforeach
@endif
@if(session('status'))
    <div id="asd" class="alert alert-dismissible alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('status') }}
    </div>
@endif