<?php

namespace App\Http\Controllers\Front;

use App\Models\Front\Page;
use App\Models\Front\User;
use App\Traits\MetaHelpers;
use Illuminate\Http\Request;
use App\Models\Front\Post;
use App\Models\Front\Category;
use App\Models\Front\Admin;
use App\Models\Front\Rooms;
use App\Models\Front\Tag;
use Carbon\Carbon;
use App\Http\Start\Helpers;
use App\Http\Controllers\Controller;

/**
 * Class PostController
 *
 * @package App\Http\Controllers
 */
class PostController extends Controller{
	use MetaHelpers;

	protected $helper; // Global variable for instance of Helpers

	public function __construct(){
		$this->helper = new Helpers;
	}

	/**
	 * @param \App\Models\Front\Page $page
	 *
	 * @param \App\Models\Front\Post $post
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 * @throws \InvalidArgumentException
	 */
	public function index(   ) {
		
		$featured      = Post::where( 'status', 'Publish' )->where( 'featured', 1 )->latest( 'publish_date' )->take( 6 )->get();
		$last_featured = null;
		if($featured->isNotEmpty()){
			$last_featured = Post::with( 'permalink' )->where( 'status', 'Publish' )->where( 'featured', 1 )->latest( 'publish_date' )->first();
			$posts         = Post::where( 'status', 'Publish' )->where( 'id', '<>', $last_featured->id )->latest( 'publish_date' )->paginate( 20 );
		}else{
			$posts = Post::where( 'status', 'Publish' )->latest( 'publish_date' )->paginate( 20 );
		}
	 
		$latest_listing = Rooms::where('status', 'Listed')->latest()->take(6)->get();
		$categories     = Category::all();
		$tags           = Tag::all();
 
        return [
			'posts'          => $posts,
			'tags'           => $tags,
			'categories'     => $categories,
			'last_featured'  => $last_featured,
			'featured'       => $featured,
			'latest_listing' => $latest_listing
		];
	 
	}

	/**
	 * @param \App\Models\Front\Post $post
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function detail( Post $post ) {
	 
		$data['post']           = $post;
		$data['related_posts']  = $post->related();
        return $data;
	}

	/**
	 * @param $slug
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function searchByCategory($slug){
		$last_featured  = null;
		$latest_listing = Rooms::where('status', 'Listed')->latest()->take(6)->select('name', 'sub_name', 'id')->get();
		$category       = Category::where('slug', $slug)->first();
		
		$featured       = Post::where( 'status', 'Publish' )->where( 'featured', 1 )->latest( 'publish_date' )->take( 6 )->get();
		$posts          = $category->posts->all();

		return  [
			'posts'          => $posts,
			'category'     => $category,
			
		];
	}

	/**
	 * @param $author
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function searchByAuthor($author){
		$last_featured  = null;
		$latest_listing = Rooms::where('status', 'Listed')->latest()->take(6)->select('name', 'sub_name', 'id')->get();
		$categories     = Category::all();
		$tags           = Tag::all();
		$author         = User::where('id', $author)->first();
		$featured       = Post::where( 'status', 'Publish' )->where( 'featured', 1 )->latest( 'publish_date' )->take( 6 )->get();
		$posts          = $author->posts;

		return [
			'posts'          => $posts,
			'author' 		=> $author
		];
	}

	/**
	 * @param $slug
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function searchByTag($slug){
		$last_featured  = null;
		$latest_listing = Rooms::where('status', 'Listed')->latest()->take(6)->select('name', 'sub_name', 'id')->get();
		$categories     = Category::all();
		$tags           = Tag::all();
		$tag            = Tag::where('slug', $slug)->first();
		$featured       = Post::where( 'status', 'Publish' )->where( 'featured', 1 )->latest( 'publish_date' )->take( 6 )->get();
		$posts          = $tag->posts;

		return [
			'posts'          => $posts,
			'tag' =>		$tag
		];
	}


	public function getAuthorInfo($author_id){
		return User::with('profile_picture')->where('id', $author_id)->first();
	}
}

