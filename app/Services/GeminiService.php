<?php

namespace App\Services;

use HosseinHezami\LaravelGemini\Facades\Gemini;

class GeminiService
{
    public function generatedPromptFromImage(UploadedFile $image): string
    {
        $imageData = base64_encode(file_get_contents($image->getPathname()));

        $mimeType = $image->getClientMimeType();

        Gemini::setApiKey(config('services.gemini.key'));

        try {
            $response = Gemini::text()
                ->upload('image', $image->getPathname) // image, video, audio, document
                ->prompt('Extract the key points from this document.')
                ->generate();

            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            throw new \RuntimeException('error generating prompt from image: ' . $e->getMessage());
        }
    }

    public function answerQuestion(string $question): string
    {
        Gemini::setApiKey(config('services.gemini.key'));
        try {
            $response = Gemini::text()
                ->prompt('Hello Gemini!')
                ->generate();

            return $response->content;
        } catch (\Exception $e) {
            throw new \RuntimeException('error answering question: ' . $e->getMessage());
        }
    }
}
