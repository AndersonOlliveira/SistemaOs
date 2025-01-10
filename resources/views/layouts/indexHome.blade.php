<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="js/datatables/datatables.net-dt/css/jquery.dataTables.css">
    <script src="js/bootstrap/js/orginalCol.js"></script>
    <script src="js/Scripts.js"></script>
    <title>Visium Os</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-dark bg-dark">
            <div class="d-flex">
                <a class="navbar-brand" href="{{route('main.home')}}">
                    <img id='imagem' src="icons/ordem.png" class="d-inline-block align-top" alt="">
                    Visium OS
                </a>
            </div>
            <div class="d-flex ">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active"><img src="icons/calendário-20.png">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</a>
                    </li>
                </ul>
                @if(Auth()->check())
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><img src="icons/icons8-usuário-de-gênero-neutro-20.png">{{auth()->user()->login}}
                             </a>
                    </li>
                </ul>
                @endif
                <ul class="navbar-nav px-3">
                    <li class="nav-item text-nowrap">
                        <a class="nav-link" href="{{route('loggout')}}">Sair</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
 <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <h5 class="mb-0">
                                <button class="btn" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Administração<img src="icons/seta.png"> </img>
                                </button>
                            </h5>
                            <hr class="" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        </li>
                    </ul>

                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <ul>
                            <li><img src="icons/administrador.png" width="15" height="15"><a href="{{route('addUser')}}" style="cursor: pointer;">Adicionar Usuários</a></li>
                            <hr>
                            <li><img src="icons/administrador.png" width="15" height="15"><a href="addUsuario/listaUsuarios.php" style="cursor: pointer;">Listar Usuários</a></li>
                            <hr>
                            <li><img src="icons/administrador.png" width="15" height="15"><a href="{{route('teste')}}" style="cursor: pointer;">teste</a></li>
                        </ul>
                    </div> <!-- para terceiro botão -->
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                @yield('content')
                <!--aqui vem o meu conteudo somente aproveito o que vem do meu cabecalho -->
            </main>
        </div> <!-- collapse primeiro botão-->
    </div>
</body>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery/jquery/dist/jquery.min.js"></script>
<script src="js/popper/@popperjs/core/dist/umd/popper-base.min.js"> </script>
<script src="js/datatables/datatables.net/js/jquery.dataTables.min.js"> </script>
<script src="js/datatables/buttons/dataTables.buttons.min.js"> </script>
<script src="js/datatables/buttons/jszip.min.js"> </script>
<script src="js/datatables/buttons/pdfmake.min.js"> </script>
<script src="js/datatables/buttons/vfs_fonts.js"> </script>
<script src="js/datatables/buttons/buttons.html5.min.js"> </script>
<script src="js/bootstrap/js/bootstrap.bundle.js"> </script>
<script src="js/code/jquery-3.2.1.slim.min.js"></script>
<script src="js/bootstrap/js/bootstrap.min.js"></script>


</body>

</html>
