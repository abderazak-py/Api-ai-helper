<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use App\Http\Resources\AnswerResource;
use App\Services\GeminiService;
use App\Services\OpenAiService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function __construct(private OpenAiService $openAiService, private GeminiService $geminiService) {}

    public function index(Request $request)
    {
        $user = $request->user();
        $answers = $user->answers()->get();

        return AnswerResource::collection($answers);
    }

    public function store(AnswerRequest $request)
    {
        $user = $request->user();

        $question = $request->input('question');

        if ($request->has('type') && $request->type === 'local') {
            $answer = $this->openAiService->answerQuestion($question);
        } else {
            $answer = $this->geminiService->answerQuestion($question);
        }

        $response = $user->answers()->create([
            'question' => $question,
            'answer' => $answer,
        ]);

        return response()->json($response, 201);
    }
}
