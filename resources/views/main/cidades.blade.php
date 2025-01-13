@extends('layouts.indexHome')

@section('title', 'Home')

@section('content')
<div id="progress" class="progress" style="display:none;">
    <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
        <span id="progressText">Carregando...</span>
    </div>
</div>
<div class="container-fluid">
    <label for="">Cadastar Cluster</label>
     <form method="POST" action="{{route('ProcessCluster')}}">
            @csrf
            @if(session('msg'))
               <div class="alert alert-warning" role="alert">
                   {{session('msg')}}
                    @endif
               </div>
            <div class="row justify-content-start">
            <div class="col-2">
           <select class="form-select form-control-sm" id="uf" name="uf" onchange="CarregaCidades();" aria-label="Default select example">
              <option selected>Selecione Estado</option>
          </select>
       </div>
       <div class="col-2">
         <select class="form-select form-control-sm" id="selectCidade" name="cidades" aria-label="Default select example">
        <option selected>Selecione a Cidade</option>
   </select>
 </div>
 <div class="col-2">
    <input hidden="{{auth()->user()->id}}" name="idUser" value="{{auth()->user()->id}}">
 <input type="submit" class="form-control-sm btn btn-success" name="enviar" onclick="StarLoad();" value="Cadastrar" />
 </div>
</div>

     </form>
   <hr>
     <div class="container-fluid">
     <table id="clusterListis" class="table table-striped table-bordered nowrap" style="width:100%">
      <thead>
                <tr>
                  <span id="msgAlerta"></span>
                  <th data-title='Id'>id</th>
                  <th dat-title='Cidade'>Cluster</th>
                  <th data-title='Data'>Data</th>
                  <th data-title='Ações'>Ações</th>
                </tr>
              </thead>
              <tbody>
         </tbody>
</table>
    <a href="{{route('main.home')}}" class="btn btn-warning" >Voltar </a>
  </div>
</main> <!-- FECHAMENTO MAIN -->
<script src="{{ asset('Scripts/webApi/cadastroUser.js')}}"></script>


@endsection
