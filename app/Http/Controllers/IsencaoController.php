<?php

namespace App\Http\Controllers;

use App\Isencao;
use Illuminate\Http\Request;
use App\User;
use App\DadosUsuario;
use Auth;
use App\Edital;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class IsencaoController extends Controller
{
  public function cadastroIsencao(Request $request){
    $this->authorize('cadastrarIsencao', Isencao::class);

    if($request->checkboxRenda == 'rendaFamiliar'){
      $validatedData = $request->validate([
                                            'nomeDadoEconomico' => ['required', 'string', 'max:255'],
                                            'cpfDadoEconomico' => ['required', 'cpf'],
                                            'parentescoDadoEconomico' => ['required', 'string', 'max:255'],
                                            'rendaDadoEconomico' => ['required', 'string', 'max:255'],
                                            'fontePagadoraDadoEconomico' => ['required', 'string', 'max:255'],
                                            'nomeNucleoFamiliar' => ['nullable', 'string', 'max:255'],
                                            'cpfNucleoFamiliar' => ['nullable', 'cpf'],
                                            'parentescoNucleoFamiliar' => ['nullable', 'string', 'max:255'],
                                            'rendaNucleoFamiliar' => ['nullable', 'string', 'max:255'],
                                            'fontePagadoraNucleoFamiliar'=> ['nullable', 'string', 'max:255'],
                                            'nomeNucleoFamiliar1' => ['nullable', 'string', 'max:255'],
                                            'cpfNucleoFamiliar1' => ['nullable', 'cpf'],
                                            'parentescoNucleoFamiliar1'=> ['nullable', 'string', 'max:255'],
                                            'rendaNucleoFamiliar1' => ['nullable', 'string', 'max:255'],
                                            'fontePagadoraNucleoFamiliar1 '=> ['nullable', 'string', 'max:255'],
                                            'nis' => ['required', 'mimes:pdf', 'max:20000'],
                                          ]);
    }

    if($request->checkboxEnsino == 'ensinoMedio'){
      $validatedData = $request->validate([
                                            'historicoEscolar' 			=> ['required', 'mimes:pdf','max:20000'],
                                          ]);

    }

    $mytime = Carbon::now('America/Recife');
    $mytime = $mytime->toDateString();
    $edital = Edital::find($request->editalId);
    $existeIsencao = Isencao::where('editalId', $request->editalId)
                                  ->where('usuarioId', Auth::user()->id)
                                  ->first();
    if(!is_null($existeIsencao)){
      return redirect()->route('home')->with('jsAlert', 'Você já possui uma isenção cadastrada no edital.');
    }
    if(!(($edital->inicioIsencao <= $mytime) && ($edital->fimIsencao >= $mytime))){
      return redirect()->route('home')->with('jsAlert', 'Este edital não está no periodo correto.');
    }


    $isencao = [];
    if(!is_null($request->historicoEscolar)){

      $file = $request->historicoEscolar;
      $path = 'insencoes/' . Auth::user()->id . '/' . $request->editalId;
      Storage::putFileAs($path, $file, 'historicoEscolar.pdf');
      $isencao = Isencao::create([
        'usuarioId'                        => Auth::user()->id,
        'editalId'                         => $request->editalId,
        'tipo'                             => $request->tipo,
        'historicoEscolar'                 => $path . '/historicoEscolar.pdf',
        'nomeDadoEconomico'                => $request->nomeDadoEconomico,
        'cpfDadoEconomico'                 => $request->cpfDadoEconomico,
        'parentescoDadoEconomico'          => $request->parentescoDadoEconomico,
        'rendaDadoEconomico'               => $request->rendaDadoEconomico,
        'fontePagadoraDadoEconomico'       => $request->fontePagadoraDadoEconomico,
        'nomeNucleoFamiliar'               => $request->nomeNucleoFamiliar,
        'cpfNucleoFamiliar'                => $request->cpfNucleoFamiliar,
        'parentescoNucleoFamiliar'         => $request->parentescoNucleoFamiliar,
        'rendaNucleoFamiliar'              => $request->rendaNucleoFamiliar,
        'fontePagadoraNucleoFamiliar'      => $request->fontePagadoraNucleoFamiliar,
        'nomeNucleoFamiliar1'              => $request->nomeNucleoFamiliar1,
        'cpfNucleoFamiliar1'               => $request->cpfNucleoFamiliar1,
        'parentescoNucleoFamiliar1'        => $request->parentescoNucleoFamiliar1,
        'rendaNucleoFamiliar1'             => $request->rendaNucleoFamiliar1,
        'fontePagadoraNucleoFamiliar1'     => $request->fontePagadoraNucleoFamiliar1,
        'parecer'                          => 'nao',

      ]);
      if(!is_null($request->nis)){
        $file = $request->nis;
        $path = 'isencoes/' . Auth::user()->id . '/' . $request->editalId;
        Storage::putFileAs($path, $file, 'nis.pdf');
        $isencao->nis = $path . '/nis.pdf';
        $isencao->save();
      }
      return redirect()->route('home')->with('jsAlert', 'Isenção requerida com sucesso!');
    }

    $isencao = Isencao::create([
      'usuarioId'                        => Auth::user()->id,
      'editalId'                         => $request->editalId,
      'tipo'                             => $request->tipo,
      'nomeDadoEconomico'                => $request->nomeDadoEconomico,
      'cpfDadoEconomico'                 => $request->cpfDadoEconomico,
      'parentescoDadoEconomico'          => $request->parentescoDadoEconomico,
      'rendaDadoEconomico'               => $request->rendaDadoEconomico,
      'fontePagadoraDadoEconomico'       => $request->fontePagadoraDadoEconomico,
      'nomeNucleoFamiliar'               => $request->nomeNucleoFamiliar,
      'cpfNucleoFamiliar'                => $request->cpfNucleoFamiliar,
      'parentescoNucleoFamiliar'         => $request->parentescoNucleoFamiliar,
      'rendaNucleoFamiliar'              => $request->rendaNucleoFamiliar,
      'fontePagadoraNucleoFamiliar'      => $request->fontePagadoraNucleoFamiliar,
      'nomeNucleoFamiliar1'              => $request->nomeNucleoFamiliar1,
      'cpfNucleoFamiliar1'               => $request->cpfNucleoFamiliar1,
      'parentescoNucleoFamiliar1'        => $request->parentescoNucleoFamiliar1,
      'rendaNucleoFamiliar1'             => $request->rendaNucleoFamiliar1,
      'fontePagadoraNucleoFamiliar1'     => $request->fontePagadoraNucleoFamiliar1,
      'parecer'                          => 'nao',

    ]);
    if(!is_null($request->nis)){
      $file = $request->nis;
      $path = 'isencoes/' . Auth::user()->id . '/' . $request->editalId;
      Storage::putFileAs($path, $file, 'nis.pdf');
      $isencao->nis = $path . '/nis.pdf';
      $isencao->save();
    }
    return redirect()->route('home')->with('jsAlert', 'Isenção requerida com sucesso!');
  }

  public function isencaoEscolhida(Request $request){
    $isencao = Isencao::find($request->isencaoId);
    $mytime = Carbon::now('America/Recife');
    $mytime = $mytime->toDateString();
    return view('homologarIsencao', ['isencao' => $isencao, 'editalId' => $request->editalId, 'mytime' => $mytime]);
  }

  public function homologarIsencao(Request $request){
    $this->authorize('homologarIsencao', Isencao::class);

    if($request->resultado == 'indeferida'){
        $validatedData = $request->validate([ 'motivoRejeicao' => ['required', 'string']]);
    }
    $isencao = Isencao::find($request->isencaoId);
    $isencao->parecer = $request->resultado;
    $isencao->motivoRejeicao = $request->motivoRejeicao;
    $isencao->save();
    return redirect()->route('home')->with('jsAlert', 'Resposta a isenção cadastrada com sucesso!');

  }

}
