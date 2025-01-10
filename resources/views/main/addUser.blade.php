@extends('layouts.indexHome')

@section('title', 'AddUser')

@section('content')

   @push('scripts')
        <script src="{{ asset('Scripts/cadastroUser.js') }}"></script>
    @endpush


<div class="container-fluid">

      <div class="col">

        <div class="card-abrir-chamado">
          <div class="card">
            <div class="card-header">
              Adicionar Usuario
              </div>
               <div class="card-body">
              <div class="row">
                <div class="col">

<form method="post" action="{{route('register')}}">
    @csrf
 <div class="form-row">

               @if(session('msg'))
               <div class="alert alert-warning" role="alert">
                   {{session('msg')}}
                    @endif
  </div>
    <div class="form-group col-md-6">
      <label for="inputNome">Nome Completo</label>
      <input name="nome" type="nome_usuario" class="form-control" id="inputNome" value="{{old('nome')}}" placeholder="Digite o nome">
    </div>
    <div class="form-group col-md-6">
      <label for="inputLogin">Login</label>
      <input name="login" type="login" class="form-control" id="inputlogin" value="{{old('login')}}" placeholder="Digite o nome para login exemplo: N23222">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Senha</label>
      <input name="senha" type="password" class="form-control" id="inputPassword4" value="{{old('senha')}}"  placeholder="Password">
    </div>
    <div class="form-group col-md-6">
    <label class="form-group col-md-6" for="inputLogin">Selecione Perfil</label>
    <select class="form-group col-md-6" name="selecionar" class="custom-select">
    <option  name="selecionar" selected>Selecione...</option>
    <option  name="selecionar"  value="0">User</option>
    <option  name="selecionar"  value="1">Adminstrador</option>
    <option  name="selecionar"  value="2">Desenvolvedor</option>
    <option  name="selecionar"  value="3">Projetos</option>
    <option  name="selecionar"  value="4">Operador</option>
  </select>
    </div>
  </div>
  <div class="form-group">
  <label for="inputEmail4">Email</label>
      <input name="email" type="email" class="form-control" id="inputEmail4" value="{{old('email')}}" placeholder="Email">
 </div>
 <br>
   <div id="progress" class="progress" style="display:none;">
    <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
        <span id="progressText">Carregando...</span>
    </div>
</div>
</div>
  </div>
  </div>
        <div class="card">
              <div class="card-header">
           <a class="btn btn btn-warning" href="{{route('main.home')}}">Voltar</a>
                <input name="cadastrar" type="submit" class="btn btn-dark" Value="Cadastrar" onclick="StarLoad();"></input>
          </div>
        </div>
    </form>

                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

@endsection
