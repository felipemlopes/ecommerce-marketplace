<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page-title', 'Welcome') - Koolbeans</title>

    <link href="{{ elixir('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-48295691-1', 'auto');
      ga('send', 'pageview');
    </script>
    
</head> 
<body>
<div id="dtBox"></div>
<header id="top-container" @if(app('request')->is('/')) style="height: 550px"@endif>
    @include('menu')
    @yield('splash')
</header>

<div class="container" id="messages-top">
    @if(Session::has('messages'))
        <div class="row">
            <div class="col-xs-12">
                @foreach(Session::get('messages') as $type => $message)
                    <p class="alert alert-{{$type}}">
                        {{$message}}
                    </p>
                @endforeach
            </div>
        </div>
    @endif

    @if(isset($messages))
        <div class="row">
            <div class="col-xs-12">
                @foreach($messages as $type => $message)
                    <p class="alert alert-{{$type}}">
                        {{$message}}
                    </p>
                @endforeach
            </div>
        </div>
    @endif
</div>

<div id="content">
    @yield('content')
</div>

<footer>
    @include('shared._footer')
</footer>

<div class="modal hide" id="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm
            </div>
            <div class="modal-body" id="modal-text"></div>
            <div class="modal-footer">
                <form method="post" id="modal-form">
                    <button type="button" class="btn btn-default" id="modal-close">Cancel</button>
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}"/>
                    <input type="hidden" name="_method" id="modal-method" value="">
                    <input type="submit" class="btn btn-danger" value="Confirm">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="//maps.googleapis.com/maps/api/js?v=3&libraries=places"></script>
    <script>
        var headerQuery = document.getElementById('query');
        var footerQuery = document.getElementById('footerquery');
        var homeQuery = document.getElementById('homequery');
        
        var options = {
            componentRestrictions: {country: 'uk'},
            options: {
                types: ['(cities)']
            },
        };

        new google.maps.places.Autocomplete(headerQuery, options);
        new google.maps.places.Autocomplete(homeQuery, options);
        new google.maps.places.Autocomplete(footerQuery, options);
    </script>
<script src="{{ elixir('js/vendor.js') }}"></script>

@yield('vendor_scripts')

<script src="{{ elixir('js/app.js') }}"></script>

@yield('scripts')

</body>
</html>
