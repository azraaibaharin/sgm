<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Requests;
use App\Http\Requests\StoreArticle;
use App\Http\Requests\UpdateArticle;
use App\Traits\FlashModelAttributes;
use App\Article;

class ArticleController extends Controller
{
    use FlashModelAttributes;

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
     * @param  \App\Http\Requests\StoreArticle $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticle $request)
    {
        Log::info('Storing article');

        $this->article->title = $request->title;
        $this->article->image_link = $this->imageUpload($request, '', $this->article->id);
        $this->article->text = $request->text;
        $this->article->link = $request->link;
        $this->article->author = $request->author;
        $this->article->save();

        return redirect('articles/'.$this->article->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('Showing article: '.$id);

        return view('article.show', $this->article->findOrFail($id)->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->flashAttributesToSession($request, $this->article->findOrFail($id));

        return view('article.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatArticle  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticle $request, $id)
    {   
        Log::info('Updating article: '.$id);

        $toUpdateArticle = $this->article->findOrFail($id);
        $toUpdateArticle->title = $request->title;
        $toUpdateArticle->image_link = $this->imageUpload($request, $toUpdateArticle->image_link, $toUpdateArticle->id);
        $toUpdateArticle->text = $request->text;
        $toUpdateArticle->link = $request->link;
        $toUpdateArticle->author = $request->author;
        $toUpdateArticle->save();

        return redirect('articles/'.$id)->withMessage('Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Log::info('Removing article: '.$request->article_id);

        $articleId = $request->article_id;
        $articleTitle = $this->article->findOrFail($articleId)->title;
        $this->article->destroy($articleId);

        return redirect('articles')->withMessage('Deleted \''.$articleTitle.'\'');
    }

    /**
     * Manage image upload.
     *
     * @return void
     */
    public function imageUpload(Request $request, $old_value, $articleId)
    {
        $imageFieldName = 'image_link';
        $imagePrefix = 'article_';
        $imageFolderName = 'img';
        $imageName = $old_value;

        if ($request->hasFile($imageFieldName))
        {
            $this->validate($request, [
                $imageFieldName => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000'
            ]);

            $imageFile = $request->file($imageFieldName);
            $imageName = $imagePrefix.$articleId.'.'.$imageFile->getClientOriginalExtension();
            $imageMoved = $imageFile->move(public_path($imageFolderName), $imageName);
        }

        return $imageName;
    }
}
