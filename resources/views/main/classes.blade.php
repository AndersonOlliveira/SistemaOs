@extends('layouts.indexHome')

@section('title', 'Classes')

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

@if (session('msg'))
<p class="class-msg">
    {{ session('msg') }}
</p>
@endif
<div id="progress" class="progress" style="display:none;">
    <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
        <span id="progressText">Carregando...</span>
    </div>
</div>

<div class="container-fluid">
    <label for="">Cadastar Classes</label>
    <div class="row justify-content-start">
        <form action="{{route('CadClases')}}" method="post">
            @csrf
        <div class="col-2">
            <input type="text" class="form-control" name='Nclasse' />
        </div>
        <div class="col-2">
            <input hidden="{{auth()->user()->id}}" name="idUser" value="{{auth()->user()->id}}">
            <input type="submit" class="form-control-sm btn btn-success" name="enviar" onclick="StarLoad();" value="Cadastrar" />
         </div>
        </form>
       </div>
        <div class="container-fluid">
            <table id="classes" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <span id="msgAlerta"></span>
                        <th data-title='id'>id</th>
                        <th dat-title='Classe Os'>Classe Os</th>
                        <th data-title='id tipo'>id tipo</th>
                        <th data-title='Ações'>Ações</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a href="{{route('main.home')}}" class="btn btn-warning">Voltar </a>
        </div>
<!-- ENVIO DA PLANILHA -->
<div class="modal fade" id="modalEnvioPlanilha" tabindex="-1" role="dialog" aria-labelledby="modalEnvioPlanilhas" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEnvioPlanilhas">Envio de Planilhas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <p>Arquivo precisar ser enviado no formato CSV, separado por "," , com as seguintes colunas item|Descrição|UnidadeMedida|tipo|valor</p>
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <form action="{{route('ProcessArquivo')}}" class="form-control" method="post" enctype="multipart/form-data">
                @csrf
               <input type="file" name="arqquivoCsv" class="form-control" multiple>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>
        </main> <!-- FECHAMENTO MAIN -->
        <script src="{{ asset('Scripts/webApi/Classes.js')}}"></script>



        @endsection
