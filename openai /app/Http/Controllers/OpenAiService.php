<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Openaiservice extends Controller
{

    /**
     * Send a request to OpenAI API with the 'text-davinci-003' model.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getInsight($logs, $content)
    {
        // The API key from the .env file
        $apiKey = env('OPENAI_API_KEY');

        // Prepare the request data
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey
        ])
        ->post("https://api.openai.com/v1/completions", [
            'model' => 'gpt-3.5-turbo-instruct',  // The model you want to use
            'prompt' => $content, // The prompt you want to send
            'max_tokens' => 150,  // Maximum number of tokens to generate
            'temperature' => 0.7, // Controls randomness
            'top_p' => 1,         // Nucleus sampling
            'n' => 1,             // Number of responses
            'stop' => null        // Optional stop sequence
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'response' => $response->json()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error communicating with OpenAI API',
                'error' => $response->body()
            ]);
        }
    }

    public function storegetInsight(Request $request){
        $validated = $request->validate([
            'summarize_logs' => 'required|string|max:255',  // Title is required and cannot exceed 255 characters
            'content' => 'required|string|min:10', // Content is required and must be at least 10 characters
        ]);

        $this->getInsights($request->input('summarize_logs'), $request->input('content'));

        Insight::create([
            'summarize_logs' => $validated['summarize_logs'],
            'content' => $validated['content'],
        ]);

        // Redirect back to the form with a success message
        return redirect()->route('i/')->with('success', 'Insight created successfully!');
    }
}


