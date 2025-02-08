<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;

class Openaicontroller extends Controller
{
    protected $openAIService;

    public function __construct()
    {
        $openAIService = new openAIService();
    }

    /**
     * Send a request to OpenAI API with the 'text-davinci-003' model.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getInsight($logs, $content)
    {
        $openAIService = new openAIService();
        // Generate response from OpenAI
        $response = $this->openAIService->generateResponse('text-davinci-003', $request->input('prompt'));

        if (isset($response['error'])) {
            // Handle errors
            return back()->withErrors(['error' => $response['error']]);
        }

        return $response;
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
        return redirect()->route('/')->with('success', 'Insight created successfully!');
    }
}


