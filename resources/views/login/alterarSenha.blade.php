@extends('layouts.home')

@section('title', 'Login')

@section('content')

<div class="container">
      <div class="row">
        <div class="card-abrir-chamado">
          <div class="card">
            <div class="card-header">
              Recuperar Senha
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                   <form method="post" action="{{route('processarAlterar')}}">
                    @csrf
                     <div class="form-group">
                        <div class="cols-4">
                           <input type="text" value="{{old('login')}}" name="login" class="form-control" placeholder="Digite Seu login.." >
                     </div>
                     <br>
                           <input type="text" value="{{old('email')}}" name="email" class="form-control" placeholder="Digite seu E-mail.." >
                             <br>
                    <button type="submit" value="recuperar" name="recuperar" class="btn btn-primary">Recuperar</button>
                </div>  <!--form-group -->
                  <div class="card">
                     <div class="card-header">
                <div class="row mt-2">
                      <div class="col-md-2">
                        <a  class="btn btn-warning btn btn-block" href="{{route('loginIndex')}}">Voltar</a>
                      </div>

                        </div>
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div><!--card-body-->
          </div><!--card-->
        </div> <!--card-abrir-chamado -->
    </div> <!-- div container -->
@endsection
