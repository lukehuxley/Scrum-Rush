<div id="asd" class="alert alert-dismissible alert-{{ $type }} @if (isset($hidden) && $hidden) hidden @endif">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ $body }}
</div>