<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $header }}</h4>
            </div>
            <div class="modal-body">
                {!! $body !!}
            </div>
            <div class="modal-footer">
                @foreach ($buttons as $button)
                    @if ($button['type'] == 'close_button')
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    @elseif ($button['type'] == 'a')
                        <a href="{!! $button['href'] !!}" class="btn @if (array_key_exists('class', $button)) {{ $button['class'] }} @endif">{{ $button['text'] }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>