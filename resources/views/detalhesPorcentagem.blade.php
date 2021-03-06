@extends('layouts.app')
@section('titulo','Detalhes porcentagem')
@section('navbar')
    <!-- Home / Detalhes do edital / Detalhes porcentagem -->
    <li class="nav-item active">
      <a class="nav-link" style="color: black" href="{{ route('home') }}"
         onclick="event.preventDefault();
                       document.getElementById('VerEditais').submit();">
         {{ __('Home') }}
      </a>
      <form id="VerEditais" action="{{ route('home') }}" method="GET" style="display: none;">

      </form>
    </li>
    <li class="nav-item active">
      <a class="nav-link">/</a>
    </li>

    <li class="nav-item active">
      <a class="nav-link" href="detalhes" style="color: black" onclick="event.preventDefault(); document.getElementById('detalhesEdital').submit();" >
        {{ __('Detalhes do Edital')}}
      </a>
      @if(Auth::check())
        <form id="detalhesEdital" action="{{route('detalhesEdital')}}" method="GET" style="display: none;">
      @else
        <form id="detalhesEdital" action="{{route('detalhesEditalServidor')}}" method="GET" style="display: none;">
      @endif
          <input type="hidden" name="editalId" value="{{$editalId}}">
          <input type="hidden" name="mytime" value="{{$mytime}}">

        </form>
    </li>
    <li class="nav-item active">
      <a class="nav-link">/</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link">Detalhes Porcentagem</a>
    </li>
@endsection
@section('content')

<style type="text/css">

</style>

<div class="container">
  <!-- div contem as tabelas -->
  <div id="tabelas" class="col-sm-12" style="width: 100%;margin: auto; background-color: #white">
    <div class="row">
      <div class="titulo-tabela-lmts">
        <h2>Detalhes</h2>
      </div>
      <table class="table table-ordered table-hover" style="">
        <tr style="background-color: #F7F7F7">
          <th> Curso </th>
          <th> Departamento </th>
          <th> Progresso </th>
          <th> Completas </th>
          <th> Pendentes </th>
          <th> Notificar </th>
        </tr>
        @for($i = 0; $i < sizeof($vagasInscricoesPorCurso); $i++)
         <tr>
           <td>{{$vagasInscricoesPorCurso[$i]['curso']}}</td>
           <td>{{$vagasInscricoesPorCurso[$i]['departamento']}}</td>
           <td>
             <?php
               $porcentagem = $vagasInscricoesPorCurso[$i]['classificadas'] * 100;
               if(($vagasInscricoesPorCurso[$i]['classificadas'] + $vagasInscricoesPorCurso[$i]['naoClassificadas'])>0){
                 $porcentagem = $porcentagem / ($vagasInscricoesPorCurso[$i]['classificadas'] + $vagasInscricoesPorCurso[$i]['naoClassificadas']);
               }
               else{
                 $porcentagem = 0;
               }
              ?>
              {{number_format($porcentagem, 0)}}%
           </td>
           <td>{{$vagasInscricoesPorCurso[$i]['classificadas']}}</td>
           <td>{{$vagasInscricoesPorCurso[$i]['naoClassificadas']}}</td>
           <td> <a href="" onclick="event.preventDefault(); document.getElementById('form{{$i}}').submit();" >Notificar Coordenador</a> </td>
           <form id="form{{$i}}" action="{{route('notificarCoordenador')}}" method="POST" target="_blank">
             @csrf
             <input type="hidden" name="cursoId" value="{{$vagasInscricoesPorCurso[$i]['id']}}">
             <input type="hidden" name="editalId" value="{{$editalId}}">
           </form>
         </tr>
        @endfor

      </table>
    </div>
  </div>
</div>

@endsection
