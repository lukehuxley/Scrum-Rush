<div class="panel {{ $panel_class }}">
    <div class="panel-heading">{!! $title !!}</div>
    <div class="list-group">
        @foreach ($scrums as $scrum)
            <a class="list-group-item" href="/{{ $scrum->uuid }}">{{ $scrum->name }}<span class="badge badge-default badge-pill">{{ count($scrum->voters()->get()) }}</span><span class="badge badge-default badge-pill">{{ $scrum->updated_at }}</span></a>
        @endforeach
    </div>
</div>

