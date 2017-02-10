<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Scrum Rush</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
        <link rel="stylesheet" href="{{ mix('css/font-awesome.css') }}"/>
        <link rel="stylesheet" href="/css/shame.css"/>
    </head>
    <body>
        <div class="flex-row" id="app">
            <div class="flex-col">
                <div class="flex">
                    @yield('header')
                </div>
                <div class="flex-grow">
                    <div class="container">
                        @if(isset($errors))
                            @foreach($errors->all() as $error)
                                @include('alert', [
                                    'type' => 'warning',
                                    'body' => $error
                                ])
                            @endforeach
                        @endif
                        @if(session('status'))
                            @include('alert', [
                                'type' => 'info',
                                'body' => session('status')
                            ])
                        @endif
                    </div>
                    @yield('body')
                </div>
                <div class="flex">
                    @yield('footer')
                </div>
            </div>
        </div>
        <script language="JavaScript" src="{{ mix('/js/app.js') }}"></script>
        <script language="JavaScript" src="/js/shame.js"></script>
    </body>
</html>

