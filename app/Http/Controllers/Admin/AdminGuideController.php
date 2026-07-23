<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\MediaStorage;
use App\Models\Guide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminGuideController extends Controller
{
    public function __construct(private readonly MediaStorage $mediaStorage)
    {
    }

    public function index(): View
    {
        $guides = Guide::all();

        $viewData = [];
        $viewData['title'] = __('controller.guides.manage');
        $viewData['guides'] = $guides;

        return view('admin.guide.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $guide = Guide::findOrFail($id);
        $viewData = [];
        $viewData['title'] = __('controller.colon_formatted.title', ['title' => $guide->getTitle()]);
        $viewData['guide'] = $guide;

        return view('admin.guide.show')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('controller.guides.create');

        return view('admin.guide.create')->with('viewData', $viewData);
    }

    public function save(Request $request): RedirectResponse
    {
        Guide::validate($request);

        $guide = new Guide();
        $guide->setTitle($request->input('title'));
        $guide->setContent($request->input('content'));
        $guide->save();

        if ($request->hasFile('image')) {
            $imageName = $guide->getId().'.'.$request->file('image')->extension();
            $guide->setImage($this->mediaStorage->upload($request->file('image'), 'guides', $imageName));
            $guide->save();
        }

        Session::flash('success', __('controller.guide.created_successfully', ['guide' => $guide->getId()]));

        return redirect()->route('admin.guide.index');
    }

    public function delete(string $id): RedirectResponse
    {
        $guide = Guide::findOrFail($id);
        $this->mediaStorage->delete($guide->getImage(), 'guides');
        $guide->delete();

        Session::flash('danger', __('controller.guide.deleted_successfully'));

        return redirect()->route('admin.guide.index')->with('viewData', $viewData);
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $guide = Guide::findOrFail($id);

        $viewData['title'] = '';
        $viewData['guide'] = $guide;

        return view('admin.guide.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        Guide::validate($request);

        $guide = Guide::findOrFail($id);
        $guide->setTitle($request->input('title'));
        $guide->setContent($request->input('content'));
        $guide->save();

        if ($request->hasFile('image')) {
            $imageName = 'guide'.$guide->getId().'.'.$request->file('image')->extension();

            $this->mediaStorage->delete($guide->getImage(), 'guides');
            $guide->setImage($this->mediaStorage->upload($request->file('image'), 'guides', $imageName));
        }

        $guide->save();

        Session::flash('message', __('controller.guide.edited_successfully'));

        return redirect()->route('admin.guide.index');
    }
}
