<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>

  <header class="bg-dark text-white">

    <div class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-end">
        <div class="row align-self-end col-2">
        <div class="card-header"><i class="bi bi-bell"></i></span> {{ __('Tareas Pendientes') }}( {{ $noti }} )</div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
                <div class="card-header"><span class="bi bi-person"></span> {{  ucfirst(Auth::user()->name) }}</div>   
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-in-left"></i>
                    {{ __('Salir') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </div>
        </div>

  </header>


  <div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-5 d-none d-sm-inline">Menu</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">


                @if ( (Auth::user()->rol == "Administrador"))
                    <li class="nav-item">
                        <a  href="{{ route('register') }}" class="nav-link align-middle px-0">
                        <span class="bi bi-person"></span></i> <span class="ms-1 d-none d-sm-inline">Registrar Usuarios</span>
                        </a>
                    </li>
                @endif

                @if ( (Auth::user()->rol == "Administrador"))
                <li class="nav-item">
                        <a  href="{{ route('usuarios_lista') }}" class="nav-link align-middle px-0">
                        <span class="bi bi-people"></span></i> <span class="ms-1 d-none d-sm-inline">Usuarios</span>
                        </a>
                    </li>
                @endif
                    
                    <li class="nav-item">
                        <a  href="{{ route('crud_tareas') }}" class="nav-link align-middle px-0">
                        <span class="bi bi-list-task"></span><span class="ms-1 d-none d-sm-inline">Tareas</span>
                        </a>
                    </li>                    
                </ul>
            </div>
        </div>
        
        <div class="container-fluid col-10">
            <div class="row flex-nowrap">
                <div class="col py-3">
                    @yield('content')
                </div>
            </div>
        </div>



    </div>


</div>

<script type="text/javascript">

    function update(id) {
        var www = "{{ url('/edit_tarea?id=') }}" + id;
        $.ajax({
            type: "get",
            url: www,
            async: false,
            success: function(data) {
                $('#descripcion').val(data[0].descripcion);
                $('#id').val(data[0].id);
            }
        });
    }
</script>



 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.1/jquery.jgrowl.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.1/jquery.jgrowl.min.js"></script>
  </body>
</html>
