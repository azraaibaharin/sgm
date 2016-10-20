<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;

class ArticleController extends Controller
{

    /**
     * The Article instance.
     * @var App\Article
     */
    protected $article;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->article->take(50)->orderBy('title')->get();
        return view('article.index')->with('articles', $articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = $this->article;

        $article->title = $request['title'];
        $article->text = $request['text'];
        $article->link = $request['link'];
        $article->author = $request['author'];
        $article->save();

        return redirect('articles/'.$article->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = $this->article->find($id);
        if (is_null($article))
        {
            return redirect('articles')->with('message', 'Article not found.');
        }
        return view('article.show', $article->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = $this->article->find($id);
        if (is_null($article))
        {
            return redirect('articles')->with('message', 'Article not found.');
        }
        return view('article.edit', $article->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = $this->article->find($id);
        if (is_null($article))
        {
            return redirect('articles')->with('message', 'Article not found.');
        }

        $article->title = $request['title'];
        $article->text = $request['text'];
        $article->link = $request['link'];
        $article->author = $request['author'];
        $article->save();

        return back()->with('success','Update successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
