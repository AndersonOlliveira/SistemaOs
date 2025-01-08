@extends('layouts.indexHome')

@section('title', 'AddUser')

@section('content')


<div class="container-fluid">
      <div class="col">

        <div class="card-abrir-chamado">
          <div class="card">
            <div class="card-header">
              Adicionar Usuario
              </div>
              <div class="card text-right">
               <div class="row">
                <div class="col">
              <a href="listaUsuarios.php" class="btn btn-alert alert-dark" style="display: block;">Lista Usuarios</a>  </div>
              </div>
              </div>

            <div class="card-body">
              <div class="row">
                <div class="col">

<form method="post" action="{{route('register')}}">
    @csrf
 <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputNome">Nome Completo</label>
      <input name="nome" type="nome_usuario" class="form-control" id="inputNome" value="{{old('nome')}}" placeholder="Digite o nome">
    </div>
    <div class="form-group col-md-6">
      <label for="inputLogin">Login</label>
      <input name="login" type="login" class="form-control" id="inputlogin" value="{{old('nome')}}" placeholder="Digite o nome para login exemplo: N23222">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Senha</label>
      <input name="senha" type="password" class="form-control" id="inputPassword4" value="{{old('nome')}}" placeholder="Password">
    </div>
    <div class="form-group col-md-6">
      <label for="inputLogin">Selecione Perfil</label>
    <select name="selecionar" class="custom-select">
    <option name="selecionar" selected>Selecione...</option>
    <option name="selecionar"  value="0">User</option>
    <option name="selecionar"  value="1">Adminstrador</option>
    <option name="selecionar"  value="2">Desenvolvedor</option>
    <option name="selecionar" value="3">Projetos</option>
    <option name="selecionar" value="4">Operador</option>
  </select>
    </div>
  </div>
  <div class="form-group">
  <label for="inputEmail4">Email</label>
      <input name="email" type="email" class="form-control" id="inputEmail4" value="{{old('nome')}}" placeholder="Email">
 </div>
  </div>
  </div>
        <div class="card">
              <div class="card-header">
           <a class="btn btn btn-warning" href="{{route('main.home')}}">Voltar</a>
                <input name="cadastrar" type="submit" class="btn btn-dark" Value="Cadastrar"></input>
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
