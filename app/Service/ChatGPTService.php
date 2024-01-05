<?php

namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatGPTService{
    public static function QueryConnect(Array $data){

        try{

            $bearer_token = config('app.open_ai_secret_key');

            $content = $data['content'];
            $density = $data['density'];
            $tone = $data['tone'];

            $response =  Http::withHeaders([
                'Accept' => "application/json",
                'Content-Type' => "application/json",
                'Authorization' => 'Bearer ' . $bearer_token
            ])->timeout(1000)
            ->post('https://api.openai.com/v1/chat/completions', [
                        "model" => "gpt-3.5-turbo-16k",
                        "messages" => [
                            [
                                "role" => "system",
                                "content" => "You are a Top Notch Experienced CopyWriter able to write articles on any Topic."
                            ],
                            [
                                "role" => "user",
                                "content" => "Write on this topic: ".$content . " with keyword density of " . $density . " percent, using a " . $tone . " tone"
                            ]
                        ],
                        "temperature" => 1,
                         "max_tokens" => 3000
                    ])->body();


            // if ($response->failed()) {
            //     Log::error("Request Not Successful: ". $response);
            //     throw new \ErrorException("Request Not Successful");
            // }

            // $response_data = $response->json();
            Log::info("Result:" .$response);

            return $response['choices'][0]['message']['content'];
        } catch(\Exception $err){
            Log::error("Error: ".$err->getMessage());
            return "Exception Thrown: " . $err->getMessage();
        }

    }
}

