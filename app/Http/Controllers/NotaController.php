<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Nota;

class NotaController extends Controller
{
    //
    public function index(){
        return view('private.nota');
    }

    public function upload(Request $req){
        $imagem = $req->file('file');

        $nome = time() . random_int(1, 1000000) . '.xml';

        $imagem->move(public_path('images/notas'), $nome);

        $xml = NotaController::testeNota(public_path('images/notas/') . $nome);

        $nota                   = new Nota();
        $nota->user             = Auth::User()->id;
        $nota->totalQuantidade  = $xml->totalQuantidade;
        $nota->quantidade       = $xml->quantidade;
        $nota->entrada          = $xml->entrada;
        $nota->saida            = $xml->saida;
        $nota->data             = $xml->data;
        $nota->produtos         = $xml->produtos;
        $nota->imagem_path      = $nome;

        $nota->save();
        
    }

    public function getNota(Request $req){
        $nota = Nota::find($req->id);

        return response()->json($nota);
    }

    protected static function testeNota(string $file){
        //$file = "C:/xampp/htdocs/newfisco/public/images/notas/1637426245.xml";
        $xml = simplexml_load_file($file);
        
        $totalQuantidade = 0;
        $produtos = $quantidade = "";

        foreach($xml->NFe->infNFe->det as $t){
            foreach($t->prod as $prod){
                $totalQuantidade = $totalQuantidade + $prod->qCom;
                if($produtos == ""){
                    $produtos .= strval($prod->xProd);
                    $quantidade .= strval($prod->qCom);
                } else {
                    $produtos .= "¬" . strval($prod->xProd);
                    $quantidade .= "¬" . strval($prod->qCom);
                }
            }
        }

        $nota                   = new \stdClass();
        $nota->totalQuantidade  = $totalQuantidade;
        $nota->quantidade       = $quantidade;
        $nota->produtos         = $produtos;
        $nota->entrada          = $xml->NFe->infNFe->ide->tpNF == 0 ? $xml->NFe->infNFe->total->ICMSTot->vNF : 0;
        $nota->saida            = $xml->NFe->infNFe->ide->tpNF == 1 ? $xml->NFe->infNFe->total->ICMSTot->vNF : 0;
        $nota->data             = date('Y-m-d', strtotime($xml->NFe->infNFe->ide->dhEmi));
        return $nota;
        //print_r($nota);
        
    }

    public function remove($id){
        $nota = Nota::find($id);
        $nota->delete();

        unlink(public_path('images\notas\\') . $nota->imagem_path);
        
        return redirect('/admin/notas');
    }

    public function notas(Request $req){
        $mes = $req->mes ? $req->mes : null;
        if($req->mes){
            $notas = Nota::whereBetween('data', [date('Y-'.$req->mes.'-01'), date('Y-'.$req->mes.'-t')])->get();
        } else {
            $notas = Nota::all();
        }
        
        return view('private.notas', ['notas' => $notas, 'mes' => $mes]);
    }

    public function nota(request $request){
        $nota['quantidade'] = $nota['produto'] = $nota['entrada'] = $nota['saida'] = 0;

        if($request->mes == 13){
            $nota['quantidade'] = DB::select('select count(*) as total from notas where user = ' . Auth::User()->id . ' and data between "' . date('Y-01-01') . '" and "' . date('Y-12-t') . '"');
            $nota['produto']    = DB::select('select sum(quantidade) as total from notas where user = ' . Auth::User()->id . ' and data between "' . date('Y-01-01') . '" and "' . date('Y-12-t') . '"');
            $nota['entrada']    = DB::select('select sum(entrada) as total from notas where user = ' . Auth::User()->id . ' and data between "' . date('Y-01-01') . '" and "' . date('Y-12-t') . '"');
            $nota['saida']      = DB::select('select sum(saida) as total from notas where user = ' . Auth::User()->id . ' and data between "' . date('Y-01-01') . '" and "' . date('Y-12-t') . '"');
        } else {
            $nota['quantidade'] = DB::select('select count(*) as total from notas where user = ' . Auth::User()->id . ' and data between "' . date('Y-' . $request->mes . '-01') . '" and "' . date('Y-' . $request->mes . "-t") . '"');
            $nota['produto']    = DB::select('select sum(quantidade) as total from notas where user = ' . Auth::User()->id . ' and data between "' . date('Y-' . $request->mes . '-01') . '" and "' . date('Y-' . $request->mes . "-t") . '"');
            $nota['entrada']    = DB::select('select sum(entrada) as total from notas where user = ' . Auth::User()->id . ' and data between "' . date('Y-' . $request->mes . '-01') . '" and "' . date('Y-' . $request->mes . "-t") . '"');
            $nota['saida']      = DB::select('select sum(saida) as total from notas where user = ' . Auth::User()->id . ' and data between "' . date('Y-' . $request->mes . '-01') . '" and "' . date('Y-' . $request->mes . "-t") . '"');
        }
        return response()->json($nota);
    }
}
