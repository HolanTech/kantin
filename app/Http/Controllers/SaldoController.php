<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SaldoController extends Controller
{

    public function checkRFID(Request $request)
    {
        $rfidData = $request->input('rfidData');
        $user = Saldo::where('rfid', $rfidData)->first();

        if ($user) {
            return Response::json(['registered' => true, 'saldo' => $user->saldo]);
        } else {
            return Response::json(['registered' => false]);
        }
    }
}
