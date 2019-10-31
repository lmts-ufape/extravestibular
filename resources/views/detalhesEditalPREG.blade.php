@extends('layouts.app')
@section('titulo','Detalhes do Edital')
@section('navbar')
    <!-- Home / Detalhes do edital -->
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
      <a class="nav-link" >
        {{ __('Detalhes do Edital')}}
      </a>

    </li>

@endsection
@section('content')

<style type="text/css">
.btn-primary {
  margin-top: 8%;
}

.h2 {
  font-size: 110%;
}


</style>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form method="POST" action="{{ route('cadastroErrata') }}" enctype="multipart/form-data" id="formErrata">
    @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nova Errata</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div>
           <input type="hidden" name="editalId" value="{{$edital->id}}" />

           <div class="form-group row justify-content-left" style="margin-left: 1%">  <!-- Nome -->
             <label for="nome" class="field a-field a-field_a2 page__field">
               <input id="nome" type="text" name="nome" class="field__input a-field__input" placeholder="Nome" style="width: 200%">
               <span class="a-field__label-wrap">
                 <span class="a-field__label">Nome*</span>
               </span>
             </label>
           </div>

           <div  class="form-group row justify-content-left" >  <!-- PDF -->
             <label for="arquivo" class="col-md-4 col-form-label text-md-right">{{ __('Arquivo*') }}</label>
             <div class="col-md-6" style="margin-top: 20px;">
               <div class="custom-file">
                 <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="arquivo">
               </div>
               @error('arquivo')
               <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                 <strong>{{ $message }}</strong>
               </span>
               @enderror
             </div>
           </div>

           <div  class="form-group" >
             <label for="editarEdital">{{ __('Marque se existir mudança nas datas:') }}</label>
             <input name="editarEdital" type="checkbox" value="sim">
           </div>

         </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 50px;">Close</button>
        <button type="submit" class="btn btn-primary btn-primary-lmts">
          {{ __('Finalizar') }}
        </button>
      </div>
    </div>
  </div>
  </form>
</div>


  <div class="centro-cartao"  style=" height: 110vh; padding-bottom: 5%" >
    <div class="card-deck d-flex justify-content-center">
      <div class="conteudo-central d-flex justify-content-center"  style="width: 100rem; width: 80%; ">  <!-- info edital -->
        <div class="card cartao text-top " style="border-radius: 20px; height: 100%" >    <!-- Info -->

         <div class="card-header d-flex justify-content-center" style="margin-top: 0px; border-top-left-radius: 20px; border-top-right-radius: 20px">
           <h2 class="h2" style="font-weight: bold; color: white">
            <?php
             $nomeEdital = explode(".pdf", $edital->nome);
             echo ($nomeEdital[0]);
            ?>
          </h2>
         </div>
         <div class="card-body justify-content-center" style="height: 100%">
               <div class="card-body justify-content-center">
                 <a style="padding: 15px">
                  A Pró-Reitora de Ensino de Graduação torna público para conhecimento dos interessados que, no
                  PERÍODO DE 29/05 a 05/06 DE 2019, estarão abertas às inscrições para o Processo Seletivo Extra que
                  visa o preenchimento de vagas para Ingresso via Processo Seletivo Extra nos Cursos de Graduação no 2o
                  semestre de 2019, de acordo com as normas regimentais da UFRPE (Resolução 410/2007; 354/2008;
                  34/2008181/91)
                 </a>

                 @if($erratas->isNotEmpty())
                   <div class="justify-content-center" style="padding-top: 2%">
                     <a style="font-size: 25px; font-weight: bold"> Erratas: </a>

                     <table class="table table-ordered table-hover">

                       @foreach($erratas as $errata)
                         <tr>
                          <td>
                            <a class="row" style="margin-left: 1%;font-weight: bold; font-size: 15px">{{$errata->nome}}</a>
                          </td>
                          <td> <!-- Download -->
                            <a href="{{ route('download', ['file' => $errata->arquivo])}}" target="_new">Baixar Errata</a>
                          </td>
                         </tr>
                       @endforeach
                     </table>
                   </div>
                 @endif
                 <!-- Button trigger modal -->
                 <div  class="form-group row justify-content-center" style="padding-top: 1%;" >
                   <button type="button" class="btn btn-primary btn-primary-lmts" data-toggle="modal" data-target="#exampleModal">
                     Nova Errata
                   </button>
                 </div>
             </div>
         </div>
        </div>
      </div>

      <div class="conteudo-central d-flex justify-content-center" style="width: 97%; padding-top: 1%;">  <!-- opções -->
        <div class="card cartao text-center " style="border-radius: 20px;height: 22.5rem;">    <!-- Isenção -->


          <div class="card-header d-flex justify-content-center" style="background-color: white; margin-top: -50px; border-top-left-radius: 20px; border-top-right-radius: 20px">
            <h2 class="h2" style="font-weight: bold">Isenção</h2>

          </div>
          <div class="card-header d-flex justify-content-center">
            <h5>
              Aberto de: <br>
                <a style="font-weight: bold">
                  {{date_format(date_create($edital->inicioIsencao), 'd/m/y')}}
                </a>
                 até
                <a style="font-weight: bold">
                  {{date_format(date_create($edital->fimIsencao), 'd/m/y')}}
                </a>
            </h5>
          </div>
          <div class="container justify-content-center" style="height: 100%; background-color: #F7F7F7; margin-top: 2%">
            <h4>
              <?php
                $porcentagem = $isencoesHomologadas * 100;
                if(($isencoesHomologadas + $isencoesNaoHomologadas)>0){
                  $porcentagem = $porcentagem / ($isencoesHomologadas + $isencoesNaoHomologadas);
                }
                else{
                  $porcentagem = 0;
                }
               ?>
               @if(($isencoesHomologadas + $isencoesNaoHomologadas) > 0 )
                <a style="font-weight: bold">Etapa {{number_format($porcentagem, 0)}}% finalizada.</a>
               @endif
            </h4>
            <h5>

                Total de Inscrições: <a style="font-weight: bold">{{($isencoesHomologadas + $isencoesNaoHomologadas)}}.</a>

            </h5>
              <h5>
                Inscrições homologadas: <a style="font-weight: bold">{{$isencoesHomologadas}}.</a>
              </h5>
              <h5>
                Inscrições em espera: <a style="font-weight: bold">{{$isencoesNaoHomologadas}}.</a>
              </h5>
          </div>

          <div class="container justify-content-center" style="padding: 13px;background-color: #F7F7F7; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px" >  <!-- form Isenção -->
            <form method="GET" action="{{route('editalEscolhido')}}">

              <input type="hidden" name="editalId" value="{{$edital->id}}">
              <input type="hidden" name="tipo" value="homologarIsencao">

              @if($edital->inicioIsencao<= $mytime)
                @if($edital->fimIsencao >= $mytime)
                  <button type="submit" class="btn btn-primary btn-primary-lmts "  >
                    {{ __('Homologar Isenção') }}
                  </button>
                @else
                  <button type="submit" disabled class="btn btn-primary btn-primary-lmts ">
                    {{ __('Homologar Isenção') }}
                  </button>
                @endif
              @else
                <button type="submit" disabled class="btn btn-primary btn-primary-lmts "  >
                  {{ __('Homologar Isenção') }}
                </button>
              @endif
            </form>
          </div>

        </div>

        <div class="card cartao text-center " style="border-radius: 20px;height: 22.5rem;"> <!-- Recurso Isenção -->

          <div class="card-header d-flex justify-content-center" style="background-color: white; margin-top: -50px; border-top-left-radius: 20px; border-top-right-radius: 20px">
            <h2 class="h2" style="font-weight: bold">Recurso Isenção</h2>

          </div>

          <div class="card-header d-flex justify-content-center">
              <h5>
               Aberto de: <br>
                 <a style="font-weight: bold">
                   {{date_format(date_create($edital->inicioRecursoIsencao), 'd/m/y')}}
                 </a>
                  até
                 <a style="font-weight: bold">
                   {{date_format(date_create($edital->fimRecursoIsencao), 'd/m/y')}}
                 </a>
              </h5>
          </div>
          <div class="container justify-content-center" style="height: 100%; background-color: #F7F7F7; margin-top: 2%">
            <h4>
              <?php
                $porcentagem = $recursosTaxaHomologados * 100;
                if(($recursosTaxaHomologados + $recursosTaxaNaoHomologados)>0){
                  $porcentagem = $porcentagem / ($recursosTaxaHomologados + $recursosTaxaNaoHomologados);
                }
                else{
                  $porcentagem = 0;
                }
               ?>
               @if(($recursosTaxaHomologados + $recursosTaxaNaoHomologados) > 0 )
                <a style="font-weight: bold">Etapa {{number_format($porcentagem, 0)}}% finalizada.</a>
               @endif
            </h4>
            <h5>

                Total de Inscrições: <a style="font-weight: bold">{{($recursosTaxaHomologados + $recursosTaxaNaoHomologados)}}.</a>

            </h5>
              <h5>
                Inscrições homologadas: <a style="font-weight: bold">{{$recursosTaxaHomologados}}.</a>
              </h5>
              <h5>
                Inscrições em espera: <a style="font-weight: bold">{{$recursosTaxaNaoHomologados}}.</a>
              </h5>
          </div>


          <div class="container justify-content-center" style="padding: 13px;background-color: #F7F7F7; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px" >
            <form method="GET" action="{{route('editalEscolhido')}}">

              <input type="hidden" name="editalId" value="{{$edital->id}}">
              <input type="hidden" name="tipo" value="homologarRecursos">

              @if($edital->inicioRecursoIsencao <= $mytime)
              @if($edital->fimRecursoIsencao >= $mytime)
              <button type="submit" class="btn btn-primary btn-primary-lmts" >
                {{ __('Homologar Recursos Isenção') }}
              </button>
              @else
              <button type="submit" disabled class="btn btn-primary btn-primary-lmts">
                {{ __('Homologar Recursos Isenção') }}
              </button>
              @endif
              @else
              <button type="submit" disabled class="btn btn-primary btn-primary-lmts">
                {{ __('Homologar Recursos Isenção') }}
              </button>
              @endif

            </form>
          </div>
        </div>

        <div class="card cartao text-center " style="border-radius: 20px;height: 22.5rem;">   <!-- Inscrição -->

             <div class="card-header d-flex justify-content-center" style="background-color: white; margin-top: -50px; border-top-left-radius: 20px; border-top-right-radius: 20px">
                 <h2 class="h2" style="font-weight: bold">Inscrição</h2>

             </div>
             <div class="card-header d-flex justify-content-center">
                 <h5>
                  Aberto de: <br>
                    <a style="font-weight: bold">
                      {{date_format(date_create($edital->inicioInscricoes), 'd/m/y')}}
                    </a>
                     até
                    <a style="font-weight: bold">
                      {{date_format(date_create($edital->fimInscricoes), 'd/m/y')}}
                    </a>
                 </h5>
             </div>
             <div class="container justify-content-center" style="height: 100%; background-color: #F7F7F7; margin-top: 2%">
               <h4>
                 <?php
                   $porcentagem = $inscricoesHomologadas * 100;
                   if(($inscricoesHomologadas + $inscricoesNaoHomologadas)>0){
                     $porcentagem = $porcentagem / ($inscricoesHomologadas + $inscricoesNaoHomologadas);
                   }
                   else{
                     $porcentagem = 0;
                   }
                  ?>
                  @if(($inscricoesHomologadas + $inscricoesNaoHomologadas) > 0 )
                   <a style="font-weight: bold">Etapa {{number_format($porcentagem, 0)}}% finalizada.</a>
                  @endif
               </h4>
               <h5>

                   Total de Inscrições: <a style="font-weight: bold">{{($inscricoesHomologadas + $inscricoesNaoHomologadas)}}.</a>

               </h5>
                 <h5>
                   Inscrições homologadas: <a style="font-weight: bold">{{$inscricoesHomologadas}}.</a>
                 </h5>
                 <h5>
                   Inscrições em espera: <a style="font-weight: bold">{{$inscricoesNaoHomologadas}}.</a>
                 </h5>
             </div>
            <div class="container justify-content-center" style="padding: 13px;background-color: #F7F7F7; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px" >
               <form method="GET" action="{{route('editalEscolhido')}}">

                   <input type="hidden" name="editalId" value="{{$edital->id}}">
                   <input type="hidden" name="tipo" value="homologarInscricoes">

                   @if($edital->inicioInscricoes <= $mytime)
                     @if($edital->fimInscricoes >= $mytime)
                       <button type="submit" class="btn btn-primary btn-primary-lmts ">
                           {{ __('Homologar Inscrições') }}
                       </button>
                     @else
                     <button type="submit" disabled class="btn btn-primary btn-primary-lmts">
                         {{ __('Homologar Inscrições') }}
                     </button>
                     @endif
                   @else
                   <button type="submit" disabled class="btn btn-primary btn-primary-lmts">
                       {{ __('Homologar Inscrições') }}
                   </button>
                   @endif
               </form>
             </div>
        </div>

        <div class="card cartao text-center " style="border-radius: 20px;height: 22.5rem;">   <!-- Recuso Inscrição -->
             <div class="card-header d-flex justify-content-center" style="background-color: white; margin-top: -50px; border-top-left-radius: 20px; border-top-right-radius: 20px">
                 <h2 class="h2" style="font-weight: bold">Recurso Inscrição</h2>

             </div>

             <div class="card-header d-flex justify-content-center">
                 <h5>
                  Aberto de: <br>
                    <a style="font-weight: bold;">
                      {{date_format(date_create($edital->inicioRecurso), 'd/m/y')}}
                    </a>
                     até
                    <a style="font-weight: bold">
                      {{date_format(date_create($edital->fimRecurso), 'd/m/y')}}
                    </a>
                 </h5>
             </div>
             <div class="container justify-content-center" style="height: 100%; background-color: #F7F7F7; margin-top: 2%">
               <h4>
                 <?php
                   $porcentagem = $recursosClassificacaoHomologados * 100;
                   if(($recursosClassificacaoHomologados + $recursosClassificacaoNaoHomologados)>0){
                     $porcentagem = $porcentagem / ($recursosClassificacaoHomologados + $recursosClassificacaoNaoHomologados);
                   }
                   else{
                     $porcentagem = 0;
                   }
                  ?>
                  @if(($recursosClassificacaoHomologados + $recursosClassificacaoNaoHomologados) > 0 )
                   <a style="font-weight: bold">Etapa {{number_format($porcentagem, 0)}}% finalizada.</a>
                  @endif
               </h4>
               <h5>

                   Total de Inscrições: <a style="font-weight: bold">{{($recursosClassificacaoHomologados + $recursosClassificacaoNaoHomologados)}}.</a>

               </h5>
                 <h5>
                   Inscrições homologadas: <a style="font-weight: bold">{{$recursosClassificacaoHomologados}}.</a>
                 </h5>
                 <h5>
                   Inscrições em espera: <a style="font-weight: bold">{{$recursosClassificacaoNaoHomologados}}.</a>
                 </h5>
             </div>
             <div class="container justify-content-center" style="padding: 13px;background-color: #F7F7F7; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px" >
               <form method="GET" action="{{route('editalEscolhido')}}">

                   <input type="hidden" name="editalId" value="{{$edital->id}}">
                   <input type="hidden" name="tipo" value="homologarRecursos">

                   @if($edital->inicioRecurso <= $mytime)
                     @if($edital->fimRecurso >= $mytime)
                       <button type="submit" class="btn btn-primary btn-primary-lmts" >
                           {{ __('Homologar Recursos Inscrição') }}
                       </button>
                     @else
                     <button type="submit" disabled class="btn btn-primary btn-primary-lmts">
                         {{ __('Homologar Recursos Inscrição') }}
                     </button>
                     @endif
                   @else
                   <button type="submit" disabled class="btn btn-primary btn-primary-lmts">
                       {{ __('Homologar Recursos Inscrição') }}
                   </button>
                   @endif

               </form>
             </div>
           </div>

        <div class="card cartao text-center " style="border-radius: 20px;height: 22.5rem;">   <!-- Recuso Resultado -->
            <div class="card-header d-flex justify-content-center" style="background-color: white; margin-top: -50px; border-top-left-radius: 20px; border-top-right-radius: 20px">
                <h2 class="h2" style="font-weight: bold">Recurso Resultado</h2>

            </div>

            <div class="card-header d-flex justify-content-center">
                <h5>
                 Aberto de: <br>
                   <a style="font-weight: bold;">
                     {{date_format(date_create($edital->inicioRecursoResultado), 'd/m/y')}}
                   </a>
                    até
                   <a style="font-weight: bold">
                     {{date_format(date_create($edital->fimRecursoResultado), 'd/m/y')}}
                   </a>
                </h5>
            </div>
            <div class="container justify-content-center" style="height: 100%; background-color: #F7F7F7; margin-top: 2%">
              <h4>
                <?php
                
                  $porcentagem = $recursosResultadoHomologados * 100;
                  if(($recursosResultadoHomologados + $recursosResultadoNaoHomologados)>0){
                    $porcentagem = $porcentagem / ($recursosResultadoHomologados + $recursosResultadoNaoHomologados);
                  }
                  else{
                    $porcentagem = 0;
                  }
                 ?>
                 @if(($recursosResultadoHomologados + $recursosResultadoNaoHomologados) > 0 )
                  <a style="font-weight: bold">Etapa {{number_format($porcentagem, 0)}}% finalizada.</a>
                 @endif
              </h4>
              <h5>

                  Total de Inscrições: <a style="font-weight: bold">{{($recursosResultadoHomologados + $recursosResultadoNaoHomologados)}}.</a>

              </h5>
                <h5>
                  Inscrições homologadas: <a style="font-weight: bold">{{$recursosResultadoHomologados}}.</a>
                </h5>
                <h5>
                  Inscrições em espera: <a style="font-weight: bold">{{$recursosResultadoNaoHomologados}}.</a>
                </h5>
            </div>
            <div class="container justify-content-center" style="padding: 13px;background-color: #F7F7F7; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px" >
              <form method="GET" action="{{route('editalEscolhido')}}">

                  <input type="hidden" name="editalId" value="{{$edital->id}}">
                  <input type="hidden" name="tipo" value="homologarRecursos">

                  @if($edital->inicioRecursoResultado <= $mytime)
                    @if($edital->fimRecursoResultado >= $mytime)
                      <button type="submit" class="btn btn-primary btn-primary-lmts" >
                          {{ __('Homologar Recursos Resultado') }}
                      </button>
                    @else
                    <button type="submit" disabled class="btn btn-primary btn-primary-lmts">
                        {{ __('Homologar Recursos Resultado') }}
                    </button>
                    @endif
                  @else
                  <button type="submit" disabled class="btn btn-primary btn-primary-lmts">
                      {{ __('Homologar Recursos Resultado') }}
                  </button>
                  @endif

              </form>
            </div>
          </div>

        <div class="card cartao text-center " style="border-radius: 20px;height: 22.5rem;">    <!-- Classificação -->
         <div class="card-header d-flex justify-content-center" style="background-color: white; margin-top: -50px; border-top-left-radius: 20px; border-top-right-radius: 20px">
           <h2 class="h2" style="font-weight: bold">Classificação</h2>

         </div>
         <div class="card-header d-flex justify-content-center">
             <h5>
              Aberto de: <br>
                <a style="font-weight: bold;">
                  {{date_format(date_create($edital->fimInscricoes), 'd/m/y')}}
                </a>
                 até
                <a style="font-weight: bold">
                  {{date_format(date_create($edital->resultado), 'd/m/y')}}
                </a>
             </h5>
         </div>
         <div class="container justify-content-center" style="height: 100%; background-color: #F7F7F7; margin-top: 2%">
           <h4>
             <?php
               $porcentagem = $inscricoesClassificadas * 100;
               if(($inscricoesClassificadas + $inscricoesNaoClassificadas)>0){
                 $porcentagem = $porcentagem / ($inscricoesClassificadas + $inscricoesNaoClassificadas);
               }
               else{
                 $porcentagem = 0;
               }
              ?>
              @if(($inscricoesClassificadas + $inscricoesNaoClassificadas) > 0 )
               <a style="font-weight: bold">Etapa {{number_format($porcentagem, 0)}}% finalizada.</a>
               <a href="{{ route('detalhesPorcentagem') }}"
                  onclick="event.preventDefault();
                                document.getElementById('detalhesPorcentagem-form').submit();">
                  ?
               </a>
               <form id="detalhesPorcentagem-form" target="_blank" action="{{ route('detalhesPorcentagem') }}" method="get" style="display: none;">

                 <input type="hidden" name="editalId" value="{{$edital->id}}">
               </form>
              @endif
           </h4>
           <h5>

               Total de Inscrições: <a style="font-weight: bold">{{($inscricoesClassificadas + $inscricoesNaoClassificadas)}}.</a>

           </h5>
             <h5>
               Inscrições homologadas: <a style="font-weight: bold">{{$inscricoesClassificadas}}.</a>
             </h5>
             <h5>
               Inscrições em espera: <a style="font-weight: bold">{{$inscricoesNaoClassificadas}}.</a>
             </h5>
         </div>

         <div class="container justify-content-center" style="padding: 13px;background-color: #F7F7F7; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px"   <!-- form Classificação -->
           <form method="POST" action="{{route('gerarClassificacao')}}" target="_blank" enctype="multipart/form-data">
             @csrf
             <input type="hidden" name="editalId" value="{{$edital->id}}">
             <input type="hidden" name="tipo" value="homologarIsencao">

             @if(($edital->resultado <= $mytime) && ($porcentagem == 100))
               <button type="submit" class="btn btn-primary btn-primary-lmts" >
                 {{ __('Gerar Resultado') }}
               </button>
             @else
               <button type="submit" disabled class="btn btn-primary btn-primary-lmts"  >
                 {{ __('Gerar Resultado') }}
               </button>
             @endif
           </form>
         </div>
        </div>

      </div>

    </div>
  </div>


@if(session()->has('jsAlert'))
    <script>
        alert('{{ session()->get('jsAlert') }}');
    </script>
@endif

<script type="text/javascript" >
  function novaErrata() {
    document.getElementById("novaErrata").style.display = "block";
  }
</script>

@endsection
