<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Nota;
use App\Models\User;

use Illuminate\Http\Request;

class SintegraController extends Controller
{
    //
    public function index(Request $req){
        $user       = User::find(Auth::user()->id);
        $notas      = Nota::whereBetween('data', [date('Y-'.$req->mes.'-01'), date('Y-'.$req->mes.'-t')])->get();

        $inscricao =  str_pad(strval($user->inscricao) , 14 , ' ' , STR_PAD_RIGHT);

        $razao =  str_pad(strval($user->razao) , 35 , ' ' , STR_PAD_RIGHT);

        $cidade =  str_pad(strval($user->cidade) , 30 , ' ' , STR_PAD_RIGHT);

        $fax = "          ";

        $txt = "10".$user->cnpj.$inscricao.$razao.$cidade.$user->estado.$fax.
        date('01'.$req->mes.'Y').date('t'.$req->mes.'Y')."\n";

        SintegraController::createFile($txt);

        return view('private.sintegra', ['txt' => $txt]);
    }

    public static function createFile($txt){
        $myfile = fopen(public_patH('sintegra/') . "sintegra.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $txt);
        fclose($myfile);
    }
}
