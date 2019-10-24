<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    
    <!-- Scripts -->
  
    <script src="{{ asset("js/jquery/jquery-3.4.1.min.js") }}"></script> 
     
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset("css/font-awesome/css/all.min.css") }}" rel="stylesheet">
   
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">




    <script>

            function genelGirisBtn(){
                location.href =  "{{ route('login') }}";
            }
            function genelKayitBtn(){
                location.href = "{{ route('register') }}";
            }
        </script>    


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

     
                    @if (isset(Auth::user()->name))
                        <div class="navbar-brand">
                            <button class="btn btn-sm btn-dark rounded text-white font-weight-bold dugmeler karsilastirmaBtn" style="width:100%;">
                                <i class="fas fa-balance-scale-right"></i>
                                <span class="pl-1">GÜNCEL VERİLER</span>
                            </button>
                        </div>
                        <div class="navbar-brand">
                            <button class="btn btn-sm btn-dark rounded text-white dugmeler font-weight-bold genelortalamaBtn" style="width:100%;">
                                <i class="fas fa-percentage"></i>
                                <span class="pl-1">GENEL</span>
                            </button>
                        </div>
                        <div class="navbar-brand">
                            <button class="btn btn-sm btn-dark rounded bg-color-white text-white font-weight-bold dugmeler" onclick="location.reload()" style="width:100%;">
                                <i class="fas fa-redo"></i>
                                <span class="pl-1">YENİLE</span>
                            </button>
                        </div>
                        @else
                        <div class="navbar-brand">
                                <button class="btn btn-sm btn-dark rounded text-white font-weight-bold dugmeler" onclick="location.reload()" style="width:100%;">
                                        <i class="fas fa-home"></i> ANASAYFA
                                </button>
                            </div>                        
                    @endif



                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest




                            <li class="nav-item">
                                    <div class="navbar-brand">
                                        <button class="btn btn-sm btn-primary rounded text-white dugmeler" onclick="genelGirisBtn()" style="width:100%;">
                                                <i class="fas fa-balance-scale-right"></i> {{ __('Giriş') }}
                                        </button>
                                    </div>


                                {{-- <a class="nav-link" href="{{ route('login') }}">{{ __('Giriş') }}</a> --}}
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                        <div class="navbar-brand">
                                            <button class="btn btn-sm btn-success rounded text-white dugmeler" onclick="genelKayitBtn()" style="width:100%;">
                                                    <i class="fas fa-balance-scale-right"></i> {{ __('Kaydol') }}
                                            </button>
                                        </div>



                                    {{-- <a class="nav-link" href="{{ route('register') }}">{{ __('Kaydol') }}</a> --}}
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Çıkış') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
