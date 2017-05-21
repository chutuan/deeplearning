<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Adminlte-laravel - {{ trans('adminlte_lang::message.landingdescription') }} ">
    <meta name="author" content="Sergi Tur Badenas - acacha.org">

    <meta property="og:title" content="Adminlte-laravel" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Adminlte-laravel - {{ trans('adminlte_lang::message.landingdescription') }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@acachawiki" />
    <meta name="twitter:creator" content="@acacha1" />

    <title>{{ trans('adminlte_lang::message.landingdescriptionpratt') }}</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/all-landing.css') }}" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

</head>

<body data-spy="scroll" data-target="#navigation" data-offset="50">

<div id="app">
    <!-- Fixed navbar -->
    <div id="navigation" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><b>AUTISM</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                    @else
                        <li><a href="/admin">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></li>
                        <li>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="submit" value="Logout" style="border: none;background: none;padding-top: 14px;">
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>


    <section id="home" name="home">
        <img class="hidden-xs hidden-sm hidden-md" src="{{ asset('/img/banner.jpg') }}" style="width: 100%;">
    </section>
    <footer>
        <div id="c">
            <div class="container">
                <p>
                    <em>Copyright &copy; 2017 <a href="">Chu Đức Tuấn</a></em>
                </p>

            </div>
        </div>
    </footer>

</div>

<script src="{{ mix('/js/app-landing.js') }}"></script>
<script>
    $('.carousel').carousel({
        interval: 3500
    })
</script>
</body>
</html>
