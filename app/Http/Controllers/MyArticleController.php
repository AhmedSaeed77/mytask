<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Article\ArticleService;

class MyArticleController extends Controller
{

    protected $articleservice;

    public function __construct(ArticleService $articleservice)
    {
        $this->articleservice = $articleservice;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = $this->articleservice->getAllArticles();
        return view('article.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('article.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->articleservice->storeArticle($request);
        return redirect()->route('article.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::find($id);
        return view('article.showdetails',compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = $this->articleservice->editArticle($id);
        return view('article.edit',compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->articleservice->updateArticle($request,$id);
        return redirect()->route('article.index');   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->articleservice->deleteArticle($id);
        return redirect()->route('article.index');
    }

    public function delete_all(Request $request)
    {
        $this->articleservice->delete_all($request);
        return redirect()->route('article.index');
    }
}
