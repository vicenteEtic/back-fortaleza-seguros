<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Models\Log\EntitieLog;
use Illuminate\Http\Request;

class EntititeLogController extends Controller
{
 
    public function index()
    {


        //pegar o processo

        $response =  EntitieLog::orderBy('id', 'desc')->get();

        $data = [];
        foreach ($response as $item) {
            $data[] = [
                "id" => $item->id,
                "level" => $item->level,
                "REMOTE_ADDR" => $item->REMOTE_ADDR,
                "PATH_INFO" => $item->PATH_INFO,
                "HTTP_USER_AGENT" => $item->HTTP_USER_AGENT,
                "message" => $item->message,
                "created_at" => $item->created_at,
                'user' => [
                    "first_name" => $item->user->first_name,
                    "email" => $item->user->email,
                    "phone" => $item->user->phone,
                    "last_name" => $item->user->last_name,
                ],


            ];
        }
            $response = json_encode($data, JSON_UNESCAPED_SLASHES);
            return response($response, 200)->header('Content-Type', 'application/json');
        $response = json_encode($response, JSON_UNESCAPED_SLASHES);
        return response($response, 200)->header('Content-Type', 'application/json');
        try {
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao listar historico"
            ], 400);
        }
    }
    public function show($id)
    {
        try {

            //pegar o processo
            $response =  EntitieLog::with('user')->where('fk_entities', $id)->orderBy('id', 'desc')->get();
            $data = [];
            foreach ($response as $item) {
                $data[] = [
                    "id" => $item->id,
                    "level" => $item->level,
                    "REMOTE_ADDR" => $item->REMOTE_ADDR,
                    "PATH_INFO" => $item->PATH_INFO,
                    "HTTP_USER_AGENT" => $item->HTTP_USER_AGENT,
                    "message" => $item->message,
                    "created_at" => $item->created_at,
                    'user' => [
                        "first_name" => $item->user->first_name,
                        "email" => $item->user->email,
                        "phone" => $item->user->phone,
                        "last_name" => $item->user->last_name,
                    ],


                ];
            }
            $response = json_encode($data, JSON_UNESCAPED_SLASHES);
            return response($response, 200)->header('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao listar historico"
            ], 400);
        }
    }

}
