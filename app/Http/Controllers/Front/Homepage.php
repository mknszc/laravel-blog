<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

use App\Models\Category;
use App\Models\Article;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Config;

use Mail;

class Homepage extends Controller
{
    public  function __construct() {
        if (Config::find(1)->active == 0) {

            return redirect()->to('bakim')->send();
        }

        view()->share('pages', Page::orderBy('order')->get());
        view()->share('categories', Category::where('status', 1)->get());
    }

    public function index() {
        $data['articles'] = Article::with('getCategory')->where('status', 1)->whereHas('getCategory', function($query) {
            $query->where('status', 1);
        })->paginate(10);

        return view('front.homepage', $data);
    }

    public function single($categorySlug, $slug) {
        $category = Category::where(['slug' => $categorySlug, 'status' => 1])->first() ?? abort(403, 'Error');
        $article  = Article::where(['slug' => $slug, 'category_id' => $category->id, 'status' => 1,])->first() ?? abort(403, 'Error');
        $article->increment('hit');

        $data['article']    = $article;

        return view('front.single', $data);
    }

    public function category($slug) {
        $category = Category::where(['slug' => $slug, 'status' => 1])->first() ?? abort(403, 'Error');
        $articles = Article::where(['category_id' => $category->id, 'status' => 1])->paginate(10) ?? abort(403, 'Error');

        $data['category']   = $category;
        $data['articles']   = $articles;

        return view('front.category', $data);
    }

    public function page($slug) {
        $page = Page::where(['slug' => $slug, 'status' => 1])->first() ?? abort(403, 'Error');
        $data['page'] = $page;

        return view('front.page', $data);
    }

    public function contact() {


        return view('front.contact');
    }

    public function contactPost(Request $request) {
        $rules = [
            'name'      => 'required|min:5',
            'email'     => 'required|email',
            'topic'     => 'required',
            'message'   => 'required|min:10'
        ];

        $validate = Validator::make($request->post(), $rules);

        if ($validate->fails()) {
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }


        $contact = new Contact();

        $contact->name          = $request->name;
        $contact->email         = $request->email;
        $contact->topic         = $request->topic;
        $contact->message       = $request->message;
        $contact->save();

        return redirect()->route('contact')->with('success', 'Mesajınız İletildi');
    }
}
