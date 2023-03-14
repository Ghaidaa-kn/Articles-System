<?php

namespace App\Http\Controllers;

use Illuminate\support\facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ArticleCategory;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Article::orderBy('id' , 'asc')->get();
        if(!empty($all)){
            return response()->json([
                'articles' => $all
            ]);
        }else{
            return response()->json([
                'message' => 'No articles until now'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(is_null($request->title) || is_null($request->body) || is_null($request->categories)){
            return response()->json([
                'message' => 'All data are required'
            ]);
        }else{
            $categories = $request->categories;
            $article = new Article();
            $article->title = $request->title;
            $article->body = $request->body;
            if($article->save()){
                $article->categories()->attach($categories);
                return response()->json([
                    'message' => 'Article added successfully'
                ]);
            }else{
                return response()->json([
                    'message' => 'Something error while adding'
                ]);
            }
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        if(!empty($article)){
            $categories = $article->categories;
            return response()->json([
                'article' => $article
            ]);
        }else{
            return response()->json([
                'message' => 'Article Id not found'
            ]);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $article = Article::find($id);
        if(!empty($article)){
            $new_categories = $request->categories;
            $article->title = $request->title;
            $article->body = $request->body;
            if($article->save()){
                $old_categories = ArticleCategory::where('article_id' , $id)->get();
                foreach ($old_categories as $value) {
                    ArticleCategory::destroy($value->id);
                }
                $article->categories()->attach($new_categories);
                return response()->json([
                    'message' => 'Article updated successfully'
                ]);
            }else{
                return response()->json([
                    'message' => 'Something error while updating'
                ]);
            }
        }else{
            return response()->json([
                'message' => 'Article Id not found'
            ]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        if(!empty($article)){
            $article_category = ArticleCategory::where('article_id' , $id)->get();
            foreach ($article_category as $value) {
                ArticleCategory::destroy($value->id);
            }
            Article::destroy($id);
            return response()->json([
                'message' => 'Article deleted successfully'
            ]);
        }else{
            return response()->json([
                'message' => 'Article Id not found'
            ]);
        }
    }
}
