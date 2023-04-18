<?php


namespace App\Http\Services\Article;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ArticleService
{
    public function getAllArticles()
    {
        $articles = Article::all();
        return $articles;
    }

    public function storeArticle(Request $request)
    {
        DB::beginTransaction();
        $request->validate([
                                'title'         => array(
                                                            'required',
                                                            'unique:articles,title',
                                                            'regex: /^[a-zA-Z0-9]*$/'
                                                        ),
                                'description'   => 'nullable|max:1000',
                                'image'         => 'required',
                                'images'        => 'required',
                            ],[
                                'title.required' =>' عنوان المقال مطلوب ',
                                'title.unique'   =>' عنوان المقال يجب ان لا يتكرر ',
                                'title.regex'    =>' عنوان المقال يجب ان يحتوى على حروف انجليزى او ارقام بدون مسافات  ',
                                'description'    => 'وصف المقال لا يزيد عن 1000 حرف',
                                'image'    => ' صوره المقال الرئيسيه مطلوبه ',
                                'images'    => ' الصور مطلوبه',
                            ]);
        try
        {
            $article = new Article();
            $article->title = $request->title;
            $article->description = $request->description;
            $filename = $request->file('image');
            $path = 'images/articls';
            $article->image = saveimage($filename,$path);
            $article->save();
    
            if($request->file('images'))
            {
                foreach($request->file('images') as $image)
                {
                    $newimage = new ArticleImage();
                    $filename = $image;
                    $path = 'images/articls/images';
                    $newimage->image = saveimage($filename,$path);
                    $newimage->article_id = $article->id;
                    $newimage->save();
                }
            }
            DB::commit();
            return redirect()->route('article.index');
        }
        catch (\Exception $e) 
        {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } 
    }

    public function editArticle($id)
    {
        $article = Article::find($id);
        return $article;
    }

    public function updateArticle(Request $request,$id)
    {
        DB::beginTransaction();
        $request->validate([
                                'title'         => array(
                                                            'required',
                                                            'unique:articles,title,'.$id,
                                                            'regex: /^[a-zA-Z0-9]*$/'
                                                        ),
                                'description'   => 'nullable|max:1000',
                            ],[
                                'title.required' =>' عنوان المقال مطلوب ',
                                'title.unique'   =>' عنوان المقال يجب ان لا يتكرر ',
                                'title.regex'    =>' عنوان المقال يجب ان يحتوى على حروف انجليزى او ارقام بدون مسافات  ',
                                'description'    => 'وصف المقال لا يزيد عن 1000 حرف',
                            ]);
        try
        {
            $article = Article::find($id);
            $article->title = $request->title;
            $article->description = $request->description;
            
            if($request->file('image'))
            {
                if (File::exists('images/articls/'.$article->image)) 
                {
                    File::delete('images/articls/'.$article->image);
                }
                $filename = $request->file('image');
                $path = 'images/articls';
                $article->image = saveimage($filename,$path);
            }
            $article->save();
    
            if($request->file('images'))
            {
                $imagearticles = ArticleImage::where('article_id',$article->id)->get();
                foreach($imagearticles as $image)
                {
                    if (File::exists('images/articls/images/'.$image->image)) 
                    {
                        File::delete('images/articls/images/'.$image->image);
                    }
                    $image->delete();
                }
    
                foreach($request->file('images') as $image)
                {
                    $newimage = new ArticleImage();
                    $filename = $image;
                    $path = 'images/articls/images';
                    $newimage->image = saveimage($filename,$path);
                    $newimage->article_id = $article->id;
                    $newimage->save();
                }
            }
            DB::commit();
        }
        catch (\Exception $e) 
        {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } 
    }


    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);
        if (File::exists('images/articls/'.$article->image)) 
        {
            File::delete('images/articls/'.$article->image);
        }
        foreach($article->images as $image)
        {
            if (File::exists('images/articls/images/'.$image->image)) 
            {
                File::delete('images/articls/images/'.$image->image);
            }
            $image->delete();
        }
        $article->delete();
    }

    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);
        $articles = Article::whereIn('id', $delete_all_id)->get();

        foreach($articles as $article)
        {
            $imagearticles = ArticleImage::where('article_id',$article->id)->get();

            if (File::exists('images/articls/'.$article->image)) 
            {
                File::delete('images/articls/'.$article->image);
            }
            foreach($article->images as $image)
            {
                if (File::exists('images/articls/images/'.$image->image)) 
                {
                    File::delete('images/articls/images/'.$image->image);
                }
                $image->delete();
            }
            $article->delete();
        }
    }
}
