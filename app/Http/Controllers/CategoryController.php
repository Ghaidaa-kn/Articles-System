<?php

namespace App\Http\Controllers;

use Illuminate\support\facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ArticleCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Category::orderBy('id' , 'asc')->get();
        if(!empty($all)){
            return response()->json([
                'categories' => $all
            ]);
        }else{
            return response()->json([
                'message' => 'No categories until now'
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
        if(!is_null($request->name)){
            $category = new Category();
            $category->name = $request->name;
            if($category->save()){
                return response()->json([
                    'message' => 'Category added successfully'
                ]);
            }else{
                return response()->json([
                    'message' => 'Something error while adding'
                ]);
            }
        }else{
            return response()->json([
                'message' => 'Category name can\'t be null'
            ]);
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
        $category = Category::find($id);
        if(!empty($category)){
            return response()->json([
                'category' => $category
            ]);
        }else{
            return response()->json([
                'message' => 'Category Id not found'
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
        $category = Category::find($id);
        if(!empty($category)){
            if(!is_null($request->name)){
                if(DB::update('update categories set name = ? where id = ?',[$request->name ,$id])){
                    return response()->json([
                        'message' => 'Category updated successfully'
                    ]);
                }else{
                    return response()->json([
                        'message' => 'Something error while updating'
                    ]);
                }
            }else{
                return response()->json([
                        'message' => 'Category name can\'t be null'
                    ]);
            } 
        }else{
            return response()->json([
                'message' => 'Category Id not found'
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
        $category = Category::find($id);
        if(!empty($category)){
            $article_category = ArticleCategory::where('category_id' , $id)->get();
            foreach ($article_category as $value) {
                ArticleCategory::destroy($value->id);
            }
            Category::destroy($id);
            return response()->json([
                'message' => 'Category deleted successfully'
            ]);
        }else{
            return response()->json([
                'message' => 'Category Id not found'
            ]);
        }
        
    }
}
