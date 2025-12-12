<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneratePromptRequest;
use App\Http\Resources\PromptGenerationResource;
use App\Services\OpenAiService;
use App\Services\GeminiService;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromptGenearationController extends Controller
{
    public function __construct(private OpenAiService $openAiService, private GeminiService $geminiService) {}

    /**
     * List all prompt.
     *
     *List all prompt generations for the authenticated user.
     */
    #[QueryParameter(
        'search',
        'Filter results by matching the generated prompt text.',
        type: 'string',
        example: 'cat'
    )]
    #[QueryParameter(
        'sort',
        'Sort field, prefix with "-" for descending (e.g. "-created_at").
        allowed filters: created_at, generated_prompt, original_filename, file_size,',
        type: 'string',
        example: '-created_at'
    )]
    #[QueryParameter(
        'per_page',
        'Number of items per page.',
        type: 'integer',
        example: 15
    )]
    public function index(Request $request)
    {

        $user = $request->user();
        $query = $user->imageGenerations();

        if ($request->has('search') && ! empty($request->search)) {
            $query->where('generated_prompt', 'like', '%' . $request->search . '%');
        }

        $allowedSortFields = [
            'created_at',
            'generated_prompt',
            'original_filename',
            'file_size',
        ];

        $sortField = 'created_at';
        $sortDirection = 'desc';

        if ($request->has('sort') && ! empty($request->sort)) {
            $sort = $request->sort;

            if (str_starts_with($sort, '-')) {
                $sortField = substr($sort, 1);
                $sortDirection = 'desc';
            } else {
                $sortField = $sort;
                $sortDirection = 'asc';
            }
        }

        if (! in_array($sortField, $allowedSortFields)) {
            $sortField = 'created_at';
            $sortDirection = 'desc';
        }

        $query->orderBy($sortField, $sortDirection);

        $imageGenerations = $query->paginate($request->get('per_page'));

        return PromptGenerationResource::collection($imageGenerations);
    }

    /**
     * Generate Prompt
     *
     * Generate prompt from image and store the result
     */
    public function store(GeneratePromptRequest $request)
    {
        $user = $request->user();
        $image = $request->file('image');

        $originalFileName = $image->getClientOriginalName();
        $sanitizedFileName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', pathinfo($originalFileName, PATHINFO_FILENAME));
        $extension = $image->getClientOriginalExtension();
        $safeFileName = $sanitizedFileName . '_' . Str::random(10) . '.' . $extension;
        $imagePath = $image->storeAs('images', $safeFileName, 'public');

        if ($request->has('type') && $request->type === 'local') {
            $generatedPrompt = $this->openAiService->generatedPromptFromImage($image);
        } else {
            $fullPath = storage_path('app/public/' . $imagePath);

            $generatedPrompt = $this->geminiService->generatedPromptFromImage($fullPath);
        }

        $imageGeneration = $user->imageGenerations()->create([
            'image_path' => $imagePath,
            'generated_prompt' => $generatedPrompt,
            'original_file_name' => $originalFileName,
            'image_size' => $image->getSize(),
            'mime_type' => $image->getClientMimeType(),
        ]);

        return response()->json($imageGeneration, 201);
    }
}
