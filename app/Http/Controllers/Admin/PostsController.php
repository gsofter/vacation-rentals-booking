<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Post;
use App\Models\admin\Admin;
use App\Models\admin\Tag;
use App\Models\admin\Category;
use App\Models\admin\Post_Categories;
use App\Models\admin\Post_Tags;
use App\Models\admin\Post_Photos;

class PostsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Post 
     * @param: 
     * @return: view-> admin/posts/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function index()
    {           
        $data = Post::get();        
        return view('admin/posts/index', compact('data'));
        
    }

    /**
     * @des: add  Post 
     * @param: Post Add Form Data
     * @return: view-> admin/posts/add.blade.php  ///////  view-> admin/posts/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            $authores       = $referrals = $referrers = User::get();
            $categories     = Category::get();
            $tags           = Tag::get();
            return view('admin/posts/add', compact('authores', 'categories', 'tags'));
            
		}else{
                     
            $post                       = new Post;
            
            $post->title                = $request->title;
            $post->excerpt              = $request->excerpt;
            $post->content              = $request->content;
            $post->status               = $request->status;
            $post->author_id            = $request->author_id;
            $post->featured             = $request->featured;
            $post->publish_date         = $request->publish_date;

            if($request->featured == "1")
                $post->featured         = 1;
            else
                $post->featured         = 0;

            if($request->meta_description)
                $post->meta_description        = $request->meta_description;
            else
                $post->meta_description = $request->excerpt;
            
            if($request->meta_title)
                $post->meta_title             = $request->meta_title;
            else
                $post->meta_title = $request->title;
            
            if( $uploadimage			= $request -> file('image')) {			
                $file_name 				= time() .'_post_image.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/posts'), $file_name);
                $post->image 		= $file_name;
            }

            $post->save(); 

            if($request->categories){
                foreach($request->categories as $category){
                    $post_category              = new Post_Categories;
                    $post_category->post_id     = $post->id;
                    $post_category->category_id = $category;
                    $post_category->save();                    
                }
            }           
    
            if($request->tags){
                foreach($request->tags as $tag){
                    $post_tag          = new Post_Tags;
                    $post_tag->post_id = $post->id;
                    $post_tag->tag_id  = $tag;
                    $post_tag->save();
                }
            }
            return redirect()->route('admin.posts')
                    ->with('success','New  Post Added!');
			
		}
    }
        

    /**
     * @des: update  Post 
     * @param: Post Edit Form Data
     * @return: view-> admin/posts/edit.blade.php  ///////   view-> admin/posts/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function update(Request $request)
	{
		if(!$_POST){
            $post           = Post::find($request->id);
            $postCategories = Post_Categories::where('post_id', $request->id)->get();
            $postTags       = Post_Tags::where('post_id', $request->id)->get();
            $authores       = $referrals = $referrers = User::get();
            $categories     = Category::get();
            $tags           = Tag::get();            
			
            return view('admin/posts/edit', compact('post', 'postCategories', 'postTags', 'authores', 'categories', 'tags'));
            
		}else{		           
           
            $post                       = Post::find($request->id);
            $post->title                = $request->title;
            $post->excerpt              = $request->excerpt;
            $post->content              = $request->content;
            $post->status               = $request->status;
            $post->author_id            = $request->author_id;
            $post->featured             = $request->featured;
            $post->publish_date         = $request->publish_date;

            if($request->featured == "1")
                $post->featured         = 1;
            else
                $post->featured         = 0;

            if($request->meta_description)
                $post->meta_description = $request->meta_description;
            else
                $post->meta_description = $request->excerpt;
            
            if($request->meta_title)
                $post->meta_title       = $request->meta_title;
            else
                $post->meta_title = $request->title;
            
            if( $uploadimage			= $request -> file('image')) {			
                $file_name 				= time() .'_post_image.' . $uploadimage->getClientOriginalExtension();
               
                $uploadimage->move(public_path('images/posts'), $file_name);
                $post->image 		= $file_name;
            }

            $post->save(); 
            Post_Categories::where('post_id', $request->id)->delete();
            Post_Tags::where('post_id', $request->id)->delete();
            if($request->categories){
                foreach($request->categories as $category){
                    $post_category              = new Post_Categories;
                    $post_category->post_id     = $post->id;
                    $post_category->category_id = $category;
                    $post_category->save();                    
                }
            }           
    
            if($request->tags){
                foreach($request->tags as $tag){
                    $post_tag          = new Post_Tags;
                    $post_tag->post_id = $post->id;
                    $post_tag->tag_id  = $tag;
                    $post_tag->save();
                }
            }

            return redirect()->route('admin.posts')
                    ->with('success','Post Updated!');
			
		}
		
    }

    /**
     * @des: delete  Post 
     * @param: delete
     * @return: view-> admin/posts/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function delete(Request $request){
        Post_Categories::where('post_id', $request->did)->delete();
        Post_Tags::where('post_id', $request->did)->delete();
        Post::find($request->did)->delete();
        return redirect()->route('admin.posts')
                ->with('success','Post Deleted!');
    }
    



}