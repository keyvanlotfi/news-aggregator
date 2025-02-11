<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleFilterRequest;
use App\Http\Resources\ArticleResource;
use App\Repositories\ArticleRepositoryInterface;
use Illuminate\Http\JsonResponse;


class ArticleController extends Controller
{
    protected ArticleRepositoryInterface $articleRepository;


    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }


    public function index(ArticleFilterRequest $request): JsonResponse
    {
        try {
            $articles = $this->articleRepository->getFilteredArticles($request->validated());

            return response()->json([
                'success' => true,
                'data' => ArticleResource::collection($articles),
                'pagination' => [
                    'total' => $articles->total(),
                    'per_page' => $articles->perPage(),
                    'current_page' => $articles->currentPage(),
                    'last_page' => $articles->lastPage(),
                ],
            ], 200);
        }
        catch (\Exception $e) {
            \Log::error('Error fetching articles: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch articles. Please try again later.'
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        $article = $this->articleRepository->findById($id);

        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'Article Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ArticleResource($article)
        ]);
    }
}
