@extends('layouts.home')

@section('title', 'Login')

@section('content')

<div class="container">
      <div class="row">
        <div class="card-login">
          <div class="card">
            <div class="card-header">
             <img src="/icons/visium.png">
            </div>
            <div class="card-body">
              <form id="formulario" action="" method="POST"> <!--para onde eu vou enviar o post de preenchimento do formulario -->
                @csrf

                <div class="form-group">
                  <input name="login" type="text" class="form-control"  autocomplete="on" required="" placeholder="Login">
                </div>
                <div class="form-group">
                  <input name="password" type="password"  autocomplete="current-password" class="form-control" placeholder="Senha"></div>
               <div class="text-danger">

                 </div>
               <div class="text-danger">
                 </div>
                <input name="sendLogin" class="btn btn-lg btn-info btn-block botao" type="submit" value="Entrar"></input>
                <div class="container">
                    <div class="row">
                <div class="row">
                <div class="col-sm">
                    @if(session('msg'))
                       <p> {{session('msg')}} </p>
                    @endif
                  <a style="position: fixed;"  href="alterarSenha.php">Esqueceu a senha?</a>
                </div>
                </div>
              </div>
          </div>

              </form>
            </div>
          </div>
        </div>
    </div>

@endsection





