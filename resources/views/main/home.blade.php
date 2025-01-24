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

<p>
    <a class="btn btn-primary" data-toggle="collapse" href="#NovaOs" role="button" aria-expanded="false" aria-controls="collapseExample">
        Nova Os
    </a>
    <a class="btn btn-info teste" data-toggle="collapse" href="#osFechadas" role="button"  aria-expanded="false" aria-controls="collapseExample">
        Os Fechadas
    </a>
</p>
<div class="collapse" id="NovaOs">
    <div class="card card-body">
        <form method="post" action="{{route('ProcessNovaOs')}}">
            @csrf
            <div class="row align-items-start">
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Equipe</label>
                    <input type="text" name="nameEquipe" value="{{old('nameEquipe')}}" class="form-control" id="inputEmail4" placeholder="Digite a Equipe">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Selecione Cluster</label>
                    <select id="clusters" name="cluster" class="form-control">
                        <option name="cluster"> Selecione Cluster</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputAddress">Informe Endereço</label>
                    <input type="text" name="endereco" class="form-control" id="inputAddress" value="{{old('endereco')}}" placeholder="Digite o endereço">
                </div>
                <div class="form-group col-md-4 ">
                    <label for="inputAddress">Informe Data</label>
                    <input type="date" name="data" value="{{old('data')}}" class="form-control" id="inputAddress">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Selecione Classe</label>
                    <select id="classes" name="classe" class="form-control">
                        <option>Selecione Classe</option>
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputCity">Solicitante Claro</label>
                        <input type="text" name="solClaro" value="{{old('solClaro')}}" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">Hora Inicio Atividade</label>
                        <input type="time" name="hoInicio" value="{{old('hoInicio')}}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">Hora Fim Atividade</label>
                        <input type="time" name="horFim" value="{{old('horFim')}}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputAddress2">Evento Gerador</label>
                        <label for="inputState">Prefixo</label>
                        <input type="type" name="Prefixo" value="{{old('Prefixo')}}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState"> Numero Prefixo</label>
                        <input type="type" name="NumPrefixo" value="{{old('NumPrefixo')}}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <button type="submit" class="btn btn-primary" name="salvar" value="enviar">Salvar </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="collapse" id="osFechadas">
  <div class="card card-body">
  <table id="listaOFechada" class="display nowrap" style="width:100%">
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
  </div>
</div>
<hr>

<p>aqui vou exibir a listagem? </p>

@if (session('msg'))
<p class="class-msg">
    {{ session('msg') }}
</p>
@endif
<!--
   <form method="post" action="{{route('ProcessArquivo')}}" enctype="multipart/form-data">
    @csrf
  <input type="file" name="arquivos" value="enviar"/>
  <input type="submit" value="enviar"/>
 -->
<table id="listaOs" class="display nowrap" style="width:100%">
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
            <th>Opções</th>
        </tr>
    </thead>
    <tbody>
        <tr>

        </tr>
    </tbody>
</table>

<!-- LISTAR DADOS MODAL EM FORMATO TABELA -->
<div class="modal fade bd-example-modal-lg" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" id="ajuste modal" style="max-width: 100%; width: auto; display: table;">
<div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Lista Produtos utilizados</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
    <a class="nav-link active" id="ListaDados-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Dados Produtos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Fotos</a>
  </li>
  </ul>
  <div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  <div class="modal-body">
                <table id="ListaDados" class="table table-striped table-bordered" ellspacing="0" style="width:100%">
                    <thead>
                        <tr>
                            <td>id</td>
                            <td>Descrição</td>
                            <td>Valor Unitário</td>
                            <td>Quantidade</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
              </div>
              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Outra pagina
                   @csrf
                   <div id="arquivo" class="container"></div>
                   <div id="arquivoD" class="container"></div>
                   <div id="arquivoDE" class="container"></div>

                 </div>
             </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <!-- <button type="button" class="btn btn-primary">U</button> -->
            </div>
        </div>
    </div>

</div>
<!-- Modal OM OS CLARO -->
<div class="modal fade bd-example-modal-lg" id="modalOMOS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Inserir OM OS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAdicionar" method="post" action="{{route('adicionaOM')}}" enctype="multipart/form-data">
                    @csrf
                    <!-- Campos do Formulário -->

                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Informe OM CLARO</label>
                                <input type="text" name="omClaro" id="omClaro" class="form-control" placeholder="Digite Om Claro">
                            </div>
                            <div class="col-md-3">
                                <label>Informe OS CLARO</label>
                                <input type="text" name="osClaro" id="osClaro" class="form-control" placeholder="Digite Os Claro">
                            </div>

                            <div class="col-md-6">
                                <label>Observação</label>
                                <textarea type="textarea" name="observacoes" id="observacoes" class="form-control"> </textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="idUnico" id="idUnicoOm">
                    <input type="hidden" name="idCluster" id="idCluster">
                    <input type="hidden" name="idUser" id="idos" value="{{auth()->user()->id}}">

                    <!-- <input type="text" name="campoNome" id="campoNome" class="form-control" placeholder="Nome da OS">

                        <input type="hidden" name="id" id="idos" class="form-control" placeholder="Nome da OS">
                        <input type="text" name="campoEquipe" id="campoEquipe" class="form-control" placeholder="Equipe">
                        <input type="file" name="campoFoto" id="campoFoto" class="form-control" /> -->


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <input type="submit" class="btn btn-primary" value="salvar" />
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal complemento -->
<div class="modal fade bd-example-modal-lg" id="modalAdicionar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Completar Os</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAdicionar" method="post" action="{{route('adicionaDos')}}" enctype="multipart/form-data">
                    @csrf
                    <!-- Campos do Formulário -->

                    <div class="container">
                        <div class="row">
                            <!-- <div class="col-md-3">
                                <label>Informe OM CLARO</label>
                                <input type="text" name="omClaro" id="omClaro" class="form-control" placeholder="Digite Om Claro">
                            </div>
                            <div class="col-md-3">
                                <label>Informe OS CLARO</label>
                                <input type="text" name="osClaro" id="osClaro" class="form-control" placeholder="Digite Os Claro">
                            </div> -->
                            <div class="col-md-6">
                                <label>Foto Antes</label>
                                <input type="file" name="fotoAntes[]" id="fotoAntes" class="form-control" multiple="" />
                            </div>

                            <div class="col-md-6">
                                <label>Foto Durante</label>
                                <input type="file" name="fotoDurante[]" id="fotoDurante" class="form-control" multiple="" />
                            </div>

                            <div class="col-md-6">
                                <label>Foto Depois</label>
                                <input type="file" name="fotoDepois[]" id="fotoDepois" class="form-control" multiple="" />
                            </div>
                            <!-- <div class="col-md-6">
                                <label>Foto Depois</label>
                                <textarea type="textarea" name="observacoes" id="observacoes" class="form-control"> </textarea>
                            </div> -->
                        </div>
                    </div>
                    <input type="hidden" name="idUnioEditar" id="idUnioEditar">
                    <input type="hidden" name="idCluster" id="idos">
                    <input type="hidden" name="idUser" id="idos" value="{{auth()->user()->id}}">

                    <!-- <input type="text" name="campoNome" id="campoNome" class="form-control" placeholder="Nome da OS">

                        <input type="hidden" name="id" id="idos" class="form-control" placeholder="Nome da OS">
                        <input type="text" name="campoEquipe" id="campoEquipe" class="form-control" placeholder="Equipe">
                        <input type="file" name="campoFoto" id="campoFoto" class="form-control" /> -->


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <input type="submit" class="btn btn-primary" value="salvar" />
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal servicos -->
<div class="modal fade bd-example-modal-lg" id="modalServicos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Serviços</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formServicos" method="post" action="{{route('adicionaServico')}}" enctype="multipart/form-data">
                    @csrf
                    <!-- Campos do Formulário -->
                    <div class="container">
                        <div class="d-flex">
                            <div class="col-md-5">
                                <div class="container-fluid">
                                    <div class="p-2">
                                        <section id="conteudo">
                                            <select class="form-select form-control-sm" id="produto" aria-label="Default select example">
                                                <option>Selecione Serviços</option>
                                                <input type="hidden" id="idDescricao">
                                                <div class="row">
                                                    <a href="#" id="Adicionar">Adicionar</a>
                                                    <input type="hidden" name="idCluster" id="idClusterServicos">
                                                    <input type="hidden" name="idUser" id="idos" value="{{auth()->user()->id}}">
                                                    <input type="hidden" name="idUnico" id="idUnicos">
                                                </div>
                                            </select>
                                    </div>
                                    </section>

                                </div>
                                <!-- <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="nomeFruta">Produto:</label>
                                        <input type="text" class="form-control" id="nomeProduto1" />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="descricao">Quantidade:</label>
                                        <input type="text" class="form-control" id="quantidade1" />
                                    </div>
                                </div> -->

                                <!-- #1241744223  protocolo samsung  3 dias -->

                            </div>
                        </div>
                        <!-- <input type="text" name="campoNome" id="campoNome" class="form-control" placeholder="Nome da OS">

                        <input type="hidden" name="id" id="idos" class="form-control" placeholder="Nome da OS">
                        <input type="text" name="campoEquipe" id="campoEquipe" class="form-control" placeholder="Equipe">
                        <input type="file" name="campoFoto" id="campoFoto" class="form-control" /> -->


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <input type="submit" class="btn btn-primary" value="salvar" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal servicos -->

    <script src="{{ asset('Scripts/webApi/NovaOs.js')}}"></script>
    <script src="{{ asset('js/ajax.js')}}"></script>



    @endsection
