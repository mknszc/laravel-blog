<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function index() {
        $pages = Page::all();

        return view('back.pages.index', compact('pages'));
    }

    public function switch(Request $request) {
        $request->validate([
            'id'     => 'required|integer',
            'status' => 'required'
        ]);

        $page = Page::findOrFail($request->id);
        $page->status = ($request->status == 'true' ? '1' : '0');
        $page->save();

        return True;
    }

    public function create() {

        return view('back.pages.create');
    }

    public function edit($id) {
        $page = Page::findOrFail($id);

        return view('back.pages.edit', compact('page'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:100'
        ]);

        $last = Page::select('id')->latest('id')->first();

        $page = new Page();
        $page->title    = $request->title;
        $page->content  = $request->content;
        $page->order    = ($last->id + 1);
        $page->slug     = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $page->image = 'uploads/' . $imageName;
        }

        $page->save();

        toastr()->success('Başarılı', 'Sayfa Başarıyla Oluşturuldu');

        return redirect()->route('admin.page.index');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jpeg,png,jpg|max:100'
        ]);

        $page = Page::findOrFail($id);
        $page->title    = $request->title;
        $page->content  = $request->content;
        $page->slug     = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $page->image = 'uploads/' . $imageName;
        }

        $page->save();

        toastr()->success('Başarılı', 'Sayfa Başarıyla Güncellendi');

        return redirect()->route('admin.page.index');
    }

    public function delete($id) {
        $page = Page::findOrFail($id);

        if (File::exists($page->image)) {
            File::delete(public_path($page->image));
        }

        $page->delete();

        toastr()->success('Başarılı', 'Sayfa Kalıcı Olarak Silindi');

        return redirect()->route('admin.page.index');
    }

    public function orders(Request $request) {

        foreach ($request->get('page') as $key => $order) {
            Page::where('id', $order)->update(['order' => $key]);
        }

    }
}
