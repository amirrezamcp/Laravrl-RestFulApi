<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\Article\ArticleListApiResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user')->get();

        return ArticleListApiResource::collection($articles);
    }
}
