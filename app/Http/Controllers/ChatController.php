<?php

namespace App\Http\Controllers;

use App\Service\ChatGPTService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ChatController extends Controller
{

    public function results($response)
    {
        return view("result", ['response' => $response]);
    }
    public function createArticle(Request $request)
    {
        try{
            $validated = $request->validate([
                'message' => 'required',
                'tone' => 'required', Rule::in(['narrative', 'authoritative', 'sad', 'emotional', 'professional','happy','inspiring']),
                'density' => 'required|numeric|between:2,5'
            ]);

            $data = [
                'content' => $validated['message'],
                'tone' => $validated['tone'],
                'density' => $validated['density']
            ];

            $response = ChatGPTService::QueryConnect($data);


            // dd(['response' => $response]);

            return $response;

            // return redirect()->route("article.result", $response);
        } catch(\Exception $err){
            Log::alert("Error: ".$err->getMessage());
            dd($err->getMessage());
        }
    }
}
