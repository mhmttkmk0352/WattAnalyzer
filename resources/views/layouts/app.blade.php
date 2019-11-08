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
                            <select class="form-control wgaSelect">
                                <option value="watt">Güç</option>
                                <option value="voltaj">Gerilim</option>
                                <option value="amper">Akim</option>     
                            </select>                            
                        </div>
                        <div class="navbar-brand">
                            <a href="{{ url("home") }}">
                                <button class="btn btn-default navbar-btn" style="width:100%;">
                                    <i class="fas fa-redo"></i>
                                    <span class="pl-1">YENİLE</span>
                                </button>
                            </a>
                        </div>
                        <div class="navbar-brand">
                            <button class="btn btn-default navbar-btn eszamanliBtn" style="width:100%;">
                                <i class="fab fa-squarespace"></i>
                                <span class="pl-1">Eşzamanlı Değerler</span>
                            </button>
                        </div>
                        <div class="navbar-brand">
                            <button class="btn btn-default navbar-btn karsilastirmaBtn" style="width:100%;">
                                <i class="fas fa-database"></i>
                                <span class="pl-1">Son Değerler</span>
                            </button>
                        </div>
                        <div class="navbar-brand">
                            <button class="btn btn-default navbar-btn genelortalamaBtn" style="width:100%;">
                                <i class="fas fa-balance-scale-left"></i>
                                <span class="pl-1">Genel Ortalama</span>
                            </button>
                        </div>
                        
   
                        

                    @else

                        <div class="navbar-brand">
                            <button class="btn btn-default navbar-btn" onclick="location.reload()" style="width:100%;">
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
                                        <button class="btn btn-default navbar-btn" onclick="genelGirisBtn()" style="width:100%;">
                                                <i class="fas fa-sign-in-alt"></i> {{ __('Giriş') }}
                                        </button>
                                    </div>


                                {{-- <a class="nav-link" href="{{ route('login') }}">{{ __('Giriş') }}</a> --}}
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                        <div class="navbar-brand">
                                            <button class="btn btn-default navbar-btn" onclick="genelKayitBtn()" style="width:100%;">
                                                    <i class="fas fa-save"></i>    {{ __('Kaydol') }}
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
