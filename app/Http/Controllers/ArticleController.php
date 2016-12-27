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
        $articles = $this->article->take(50)->orderBy('updated_at')->get();
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
        $article->image_link = $this->imageUpload($request, 'image_link', $article->image_link, 'article_'.$article->id);
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
        $article->image_link = $this->imageUpload($request, 'image_link', $article->image_link, 'article_'.$article->id);
        $article->text = $request['text'];
        $article->link = $request['link'];
        $article->author = $request['author'];
        $article->save();

        return back()->with('success','Update successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $article_id = $request['article_id'];
        $article = $this->article->findOrFail($article_id);
        $articleTitle = $article->title;
        $this->article->destroy($article_id);

        return redirect('articles')->with('message', 'Successfully deleted \''.$articleTitle.'\'');
    }

    /**
     * Manage image upload.
     *
     * @return void
     */
    public function imageUpload(Request $request, $field_name, $old_value, $prefix)
    {
        $imageName = $old_value;

        if ($request->hasFile($field_name))
        {
            $this->validate($request, [
                $field_name => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            ]);

            $imageFile = $request->file($field_name);
            $imageName = $prefix.'.'.$imageFile->getClientOriginalExtension();
            $imageMoved = $imageFile->move(public_path('img'), $imageName);
        }

        return $imageName;
    }
}
