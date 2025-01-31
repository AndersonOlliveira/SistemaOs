@extends('layouts.indexHome')

@section('title', 'Home')

@section('content')

@if($errors->any())

<!-- {{dd($errors)}} -->
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div id="progress" class="progress" style="display:none;">
    <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
        <span id="progressText">Carregando...</span>
    </div>
</div>
      <div class="container-fluid">
            <table id="classes" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <span id="msgAlerta"></span>
                        <th data-title='id'>id</th>
                        <th dat-title='Nome'>Nome</th>
                        <th data-title='E-mail'>E-mail</th>
                        <th data-title='Login'>Login</th>
                        <th data-title='Tipo User'>Tipo User</th>
                        <!-- <th data-title='Ações'>Ações</th> -->
                        <th data-title='Ações'>Ações</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a href="{{route('main.home')}}" class="btn btn-warning">Voltar </a>
        </div>
<!-- ENVIO DA PLANILHA -->
<div class="modal fade" id="modalTrocaSenha" tabindex="-1" role="dialog" aria-labelledby="modalTrocaSenha" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTrocaSenha">Envio de Planilhas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
             <form action="{{route('AlterPass')}}" class="form-control" method="post">
                @csrf
           <div class="form-group">
            <label for="recipient-name" class="col-form-label">Senha Nova</label>
            <input type="password" class="form-control" id="recipient-name" name="senha">
          </div>
          </div>
          <div class="form-group">

                   <input type="hidden" name="campoClasse" id="campoClasse">
                    <input type="hidden" name="idClasse" id="idClasse">
                    <input type="hidden" name="idUnioClasse" id="idUnioClasse">
                    <input type="hidden" name="idUser" id="idos" value="{{auth()->user()->id}}">

                </div>
                <input type="submit" class="btn btn-primary" value="Enviar">
        </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
        </main> <!-- FECHAMENTO MAIN -->
        <script src="{{ asset('Scripts/webApi/listaUser.js')}}"></script>








@endsection
