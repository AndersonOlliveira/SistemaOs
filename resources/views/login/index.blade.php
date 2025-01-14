@extends('layouts.home')

@section('title', 'Login')

@section('content')

<div class="container">
      <div class="row">
        <div class="card-login">
          <div class="card">
            <div class="card-header">
             <img class="index" src="/icons/visium.png">
            </div>
            <div class="card-body">
              <form id="formulario" action="{{route('processarLogin')}}" method="POST"> <!--para onde eu vou enviar o post de preenchimento do formulario -->
                @csrf
                <div class="form-group">
                  @if(session('msg'))
                    <span class="alert alert-warning">{{session('msg')}}</span>
                    @endif
                </div>
                <div class="form-group">
                  <input name="login" type="text" class="form-control" value="{{old('login')}}" autocomplete="on" required="" placeholder="Login">
                </div>
                <br>
                <div class="form-group">
                  <input name="password" type="password" value="{{old('password')}}"  autocomplete="current-password" class="form-control" placeholder="Senha"></div>

                  <div class="text-danger">

                 </div>
                 <br>
                <input name="sendLogin" class="btn btn-lg btn-info btn-block botao" type="submit" value="Entrar"></input>
               <div class="col-sm">
                 <a style="position: fixed;"  href="{{route('alterarSenha')}}">Esqueceu a senha?</a>
                </div>

                <div class="row">

                </div>

              </div>
            </div>

              </form>
            </div>
          </div>
        </div>
    </div>

@endsection





