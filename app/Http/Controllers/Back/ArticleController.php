<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{

    public function index() {
        $articles = Article::orderBy('created_at')->get();

        return view('back.articles.index', compact('articles'));
    }

    public function create() {
        $categories = Category::all();

        return view('back.articles.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:100'
        ]);

        $article = new Article();
        $article->title         = $request->title;
        $article->category_id   = $request->category;
        $article->content       = $request->content;
        $article->slug          = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $article->image = 'uploads/' . $imageName;
        }

        $article->save();

        toastr()->success('Başarılı', 'Makale Başarıyla Oluşturuldu');

        return redirect()->route('admin.makaleler.index');
    }

    public function show($id) {
        print_r($id);
    }

    public function edit($id) {
        $article = Article::findOrFail($id);
        $categories = Category::all();

        return view('back.articles.edit', compact('categories', 'article'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jpeg,png,jpg|max:100'
        ]);

        $article = Article::findOrFail($id);
        $article->title         = $request->title;
        $article->category_id   = $request->category;
        $article->content       = $request->content;
        $article->slug          = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $article->image = 'uploads/' . $imageName;
        }

        $article->save();

        toastr()->success('Başarılı', 'Makale Başarıyla Güncellendi');

        return redirect()->route('admin.makaleler.index');
    }

    public function switch(Request $request) {
        $request->validate([
            'id'     => 'required|integer',
            'status' => 'required'
        ]);

        $article = Article::findOrFail($request->id);
        $article->status = ($request->status == 'true' ? '1' : '0');
        $article->save();

        return True;
    }

    public function delete($id) {
        Article::findOrFail($id)->delete();

        toastr()->success('Başarılı', 'Makale Başarıyla Silindi');

        return redirect()->route('admin.makaleler.index');
    }

    public function hardDelete($id) {
        $article = Article::onlyTrashed()->findOrFail($id);

        if (File::exists($article->image)) {
            File::delete(public_path($article->image));
        }

        $article->forceDelete();

        toastr()->success('Başarılı', 'Makale Kalıcı Olarak Silindi');

        return redirect()->route('admin.makaleler.index');
    }

    public function trashed() {
        $articles = Article::onlyTrashed()->get();

        return view('back.articles.trashed', compact('articles'));
    }

    public function recycle($id) {
        Article::onlyTrashed()->find($id)->restore();

        toastr()->success('Başarılı', 'Makale Başarıyla Kurtarıldı');

        return redirect()->route('admin.makaleler.index');
    }

    public function destroy($id) {

        return $id;
    }
}
