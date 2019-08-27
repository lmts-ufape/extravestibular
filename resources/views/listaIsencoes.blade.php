@extends('layouts.app')
@section('titulo','Homologar Isenção')
@section('navbar')
    Homologar Isenção
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pedidos de isenções abertas') }}</div>
                <div class="card-body">
                  <table class="table table-ordered table-hover">
                    @foreach ($isencoes as $isencao)
                    <tr>
                      <td> <!-- ID -->
                       <a >
                         {{$isencao->id}}
                       </a>
                      </td>

                      <td> <!-- Tipo -->
                       <a >
                         {{$isencao->tipo}}
                       </a>
                      </td>

                      <td> <!-- Isenção -->
                        <form method="POST" action={{ route('isencaoEscolhida') }} enctype="multipart/form-data"> <!-- Isenção -->
                          @csrf
                          <div class="col-md-8 offset-md-4">
                            <input type="hidden" name="isencaoId" value="{{$isencao->id}}">
                            <button type="submit" class="btn btn-primary btn-primary-lmts">
                                {{ __('Selecionar esta Isenção') }}
                            </button>

                          </div>
                        </form>
                      </td>
                    </tr>

                    @endforeach

                  {{ $isencoes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
