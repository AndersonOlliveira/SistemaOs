@extends('layouts.indexHome')

@section('title', 'Home')


@if(session('msg'))
               <div class="alert alert-warning" role="alert">
                   {{session('msg')}}
                    @endif
