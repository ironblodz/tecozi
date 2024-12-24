<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function returnSuccess ($msg = 'Successo!', $data = []) 
    {
        return response()->json([
            'success' => true,
            'message' => $msg,
            'data' => $data,
        ]);

    }

    public function returnError ($msg = 'Something went wrong!') 
    {
        return response()->json([
            'success' => false,
            'message' => 'Erro: ' . $msg,
        ]);
    }
}
