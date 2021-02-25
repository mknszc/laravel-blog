<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();

        return view('back.categories.index', compact('categories'));
    }

    public function switch(Request $request) {
        $request->validate([
            'id'     => 'required|integer',
            'status' => 'required'
        ]);

        $category = Category::findOrFail($request->id);
        $category->status = ($request->status == 'true' ? '1' : '0');
        $category->save();

        return True;
    }

    public function create(Request $request) {
        $request->validate([
            'category' => 'min:2'
        ]);

        $isExist = Category::where('slug', Str::slug($request->category))->first();

        if ($isExist) {
            toastr()->error('Hata', 'Kategori Zaten Var');

            return redirect()->route('admin.categories');
        }

        $category = new Category();
        $category->name  = $request->category;
        $category->slug  = Str::slug($request->category);
        $category->save();

        toastr()->success('Başarılı', 'Kategori Başarıyla Oluşturuldu');

        return redirect()->route('admin.categories');

    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required|integer',
            'category' => 'min:2'
        ]);

        $isExist = Category::where('slug', Str::slug($request->category))->first();

        if ($isExist) {
            toastr()->error('Hata', 'Kategori Zaten Var');

            return redirect()->route('admin.categories');
        }

        $category = Category::find($request->id);
        $category->name  = $request->category;
        $category->slug  = Str::slug($request->category);
        $category->save();

        toastr()->success('Başarılı', 'Kategori Başarıyla Değiştirildi');

        return redirect()->route('admin.categories');

    }

    public function delete(Request $request) {
        $request->validate([
            'id'     => 'required|integer',
        ]);

        $category = Category::findOrFail($request->id);

        if ($category->id == 1) {
            return redirect()->back();
        }

        if ($category->articleCount() > 0) {
            Article::where('category_id', $category->id)->update(['category_id' => 1]);
        }

        $category->delete();

        toastr()->success('Başarılı', 'Kategori Başarıyla Silindi');

        return redirect()->back();
    }

    public function getData(Request $request) {
        $request->validate([
            'id'     => 'required|integer',
        ]);

        $category = Category::select('id', 'name')->findOrFail($request->id);

        return response()->json($category);
    }
}
