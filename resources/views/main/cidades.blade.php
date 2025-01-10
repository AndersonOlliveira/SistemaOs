@extends('layouts.indexHome')

@section('title', 'Home')

@section('content')
<script src="{{ asset('js/jquery.js')}}"></script>


<script src="{{ asset('js/bootstrap/js/orginalCol.js')}}"></script>
<script src="{{ asset('js/jquery/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('Scripts/cadastroUser.js')}}"></script>
<script src="{{ asset('Scripts/teste.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>



<div class="container-fluid">
     <form method="POST" action="">
            @csrf
           <select class="form-select form-control-sm" id="uf" name="uf" onchange="CarregaCidades();" aria-label="Default select example">
              <option selected>Selecione o estado</option>
          </select>
         <select class="form-select form-control-sm" id="selectCidade" name="cidades" aria-label="Default select example">
        <option selected>Selecione a Cidade</option>
        <!-- Options will be populated dynamically -->
          </select>
       <label>Digite o pop:</label>
     <input type="text" class="form-control-sm" name="pop" />
     <!-- <input type="text" class="form-control-sm" name="cabo" /> -->
      <label for="quantidadeInputs">Quantidade de Cabos</label>
       <input type="number" id="quantidadeInputs" name="quantidadeInputs"  class="form-control-sm" min="0" value="0" oninput="criarInputsDinamicos(this.value)">
       <div id="inputsDinamicosContainer"></div>
       <input type="hidden" name="statusRota" value="1" />
       <input type="submit" class="form-control-sm btn btn-success" name="enviar" value="Cadastar" />
    </div>
      </form>
   <hr>
     <div class="container-fluid">
     <table id="paginas" class="table table-striped table-bordered nowrap" style="width:100%">
      <thead>
                <tr>
                  <span id="msgAlerta"></span>
                  <th data-title='Id'>id</th>
                  <th dat-title='Cidade'>Cidade</th>
                  <th data-title='Data'>Data</th>
                  <th data-title='Pop'> Pop</th>
                  <th data-title='Cabo'>Cabo</th>
                  <th data-title='Ações'>Ações</th>
                </tr>
              </thead>
              <tbody>

       <tr>
      <td class='teste' data-title='id'></td>
      <td data-title='Cidade'></td>
      <td data-title='Data'></td>
      <td data-title='Pop'></td>
      <td data-title='Cabo'></td>
      <td><input type='submit' name='deletar' class='btn btn-danger' onclick='deletarRota()' value='Deletar'/>
      <button type='button' name='deletar' class='btn btn-info' value='Adicionar' data-toggle='modal' data-target=''>Adicionar</button></td>
       </tr>


      <div class='modal fade' id='' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title' id='exampleModalLabel'>Adicionar</h5>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>

             <form method='POST' action='processos/adicionar.php'>
             <label for='quantidadeInputs'>Quantidade de Cabos Adicionar</label>
              <input type='number' id='quantidadeInputs' name='quantidadeInputs' class='form-control-sm' min='0' value='0' oninput='criarInputsDinamicos(this.value)'>
              <div id='inputsDinamicosContainer'></div>
             </div>
               <div class='container-fluid'>

               <input type='submit' class='form-control btn btn-success' name='enviar' value='Adiconar' />
               <input type='hidden' name='id' value='' />
               <input type='hidden' name='cidade' value='' />
             </div>
             </form>

            <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
            </div>
          </div>
        </div>
   </div>
 </tbody>
</table>
    <a href="../page/index.php" class="btn btn-warning" value="Voltar">Voltar </a>
  </div>
</main> <!-- FECHAMENTO MAIN -->

@endsection
