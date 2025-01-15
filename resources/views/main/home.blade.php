@extends('layouts.indexHome')

@section('title', 'Home')

@section('content')

<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#NovaOs" role="button" aria-expanded="false" aria-controls="collapseExample">
   Nova Os
  </a>
</p>
<div class="collapse" id="NovaOs">
  <div class="card card-body">
  <form method="post" action="{{route('ProcessNovaOs')}}">
  @csrf
  <div class="row align-items-start">
    <div class="form-group col-md-4">
      <label for="inputEmail4">Equipe</label>
      <input type="text" name="nameEquipe" class="form-control" id="inputEmail4" placeholder="Digite a Equipe">
    </div>
    <div class="form-group col-md-4">
      <label for="inputPassword4">Selecione Cluster</label>
     <select id="clusters" name="cluster" class="form-control" >
        <option name="cluster"> Selecione Cluster</option>
     </select>
    </div>
 <div class="form-group col-md-4">
    <label for="inputAddress">Informe Endereço</label>
    <input type="text" name="endereco" class="form-control" id="inputAddress" placeholder="Digite o endereço">
  </div>
  <div class="form-group col-md-4 ">
    <label for="inputAddress">Informe Data</label>
    <input type="date" name="data" class="form-control" id="inputAddress" >
  </div>
  <div class="form-group col-md-4">
      <label for="inputPassword4">Selecione Classe</label>
     <select id="classes" name="classe" class="form-control" >
        <option>Selecione Classe</option>
     </select>
    </div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputCity">Solicitante Claro</label>
      <input type="text" name="solClaro" class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">Hora Inicio Atividade</label>
      <input type="time" name="hoInicio" class="form-control">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">Hora Fim Atividade</label>
      <input type="time" name="horFim" class="form-control">
    </div>
    <div class="form-group col-md-4">
    <label for="inputAddress2">Evento Gerador</label>
      <label for="inputState">Prefixo</label>
      <input type="type" name="Prefixo" class="form-control">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState"> Numero Prefixo</label>
      <input type="type" name="NumPrefixo" class="form-control">
    </div>
  </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-4">
     <button type="submit" class="btn btn-primary" name="salvar" value="enviar" >Salvar </button>
  </div>
  </div>
</form>
  </div>
</div>
 <hr>

 <p>aqui vou exibir a listagem? </p>
<!--
   <form method="post" action="{{route('ProcessArquivo')}}" enctype="multipart/form-data">
    @csrf
  <input type="file" name="arquivos" value="enviar"/>
  <input type="submit" value="enviar"/>
 -->
  <table id="listaOs" class="display" style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>Equipe</th>
                <th>NomeCluster</th>
                <th>Prefixo</th>
                <th>data</th>
                <th>endereco</th>
                <th>Hora Inicio</th>
                <th>Hora Fim</th>
                <th>Solicitante Claro</th>
                <th>Tipo Os</th>
            </tr>
        </thead>
        <tbody>
            <tr>

            </tr>
        </tbody>
        </table>

 <script src="{{ asset('Scripts/webApi/NovaOs.js')}}"></script>
 <script src="{{ asset('js/ajax.js')}}"></script>



@endsection
