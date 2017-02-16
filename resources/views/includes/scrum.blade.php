<div id="app" class="fill-height">
    <div class="container">
        @include('includes.alert')
    </div>
    <scrum @if(isset($scrum_master)) scrum-master @endif:scrum-data="{{ $scrum_data }}" scrum-rush-url="{{ $scrum_rush_url }}" scrum-uuid="{{ $scrum_uuid }}" scrum-name="{{ $scrum_name }}"></scrum>
</div>