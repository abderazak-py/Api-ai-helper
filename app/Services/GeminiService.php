<?php

namespace App\Services;

use HosseinHezami\LaravelGemini\Facades\Gemini;
use Illuminate\Http\UploadedFile;;


class GeminiService
{
    public function generatedPromptFromImage(string $image): string
    {

        Gemini::setApiKey(config('services.gemini.key'));

        try {
            $response = Gemini::text()
                ->upload('image', $image) // image, video, audio, document
                ->prompt('Extract the key points from this document.')
                ->generate();

            return $response->content();
        } catch (\Exception $e) {
            throw new \RuntimeException('error generating prompt from image: ' . $e->getMessage());
        }
    }

    public function answerQuestion(string $question): string
    {
        Gemini::setApiKey(config('services.gemini.key'));
        try {
            $response = Gemini::text()
                ->prompt($question)
                ->generate();

            return $response->content();
        } catch (\Exception $e) {
            throw new \RuntimeException('error answering question: ' . $e->getMessage());
        }
    }
}
