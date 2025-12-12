<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use OpenAI\Factory;

class OpenAiService
{
    public function generatedPromptFromImage(UploadedFile $image): string
    {
        $imageData = base64_encode(file_get_contents($image->getPathname()));

        $mimeType = $image->getClientMimeType();

        $client = (new Factory)->withApiKey(config('services.openai.key'))->withBaseUri('http://127.0.0.1:1337/v1')->make();
        try {
            $response = $client->chat()->create([
                'model' => 'OpenGVLab_InternVL3_5-1B-IQ2_M',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => 'generate prompt from image',
                            ],
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => 'data:' . $mimeType . ';base64,' . $imageData,
                                ],
                            ],
                        ],
                    ],
                ],

            ]);

            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            throw new \RuntimeException('error generating prompt from image: ' . $e->getMessage());
        }
    }

    public function answerQuestion(string $question): string
    {
        $client = (new Factory)->withApiKey(config('services.openai.key'))->withBaseUri('http://127.0.0.1:1337/v1')->make();
        try {
            $response = $client->chat()->create([
                'model' => 'OpenGVLab_InternVL3_5-1B-IQ2_M',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $question,
                    ],
                ],
            ]);

            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            throw new \RuntimeException('error generating prompt from image: ' . $e->getMessage());
        }
    }
}
