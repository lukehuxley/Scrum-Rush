<nav id="mainnav" class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            @if (isset($menu))
                <button type="button" class="btn btn-primary btn-sm navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                    <i class="fa fa-bars"></i> Menu
                </button>
            @endif
            <a class="navbar-brand" href="/">{{ $title }}</a>
        </div>
        @if (isset($menu))
        <div class="navbar-collapse collapse" id="navbar-collapse-1" aria-expanded="false" style="height: 1px;">
            <ul class="nav navbar-nav navbar-right">
                @foreach ($menu as $menu_item)
                <li>
                    <a href="@if (array_key_exists('href', $menu_item)){{ $menu_item['href'] }}@else#@endif" @if(array_key_exists('modal', $menu_item))data-toggle="modal" data-target="#{{ $menu_item['modal'] }}"@endif><i class="fa fa-fw fa-{{ $menu_item['icon'] }}"></i> {{ $menu_item['name'] }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</nav>