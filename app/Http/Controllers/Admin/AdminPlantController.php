<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\MediaStorage;
use App\Models\Category;
use App\Models\Plant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminPlantController extends Controller
{
    public function __construct(private readonly MediaStorage $mediaStorage)
    {
    }

    public function index(Request $request): View
    {
        $plants = Plant::all();

        $viewData = [];
        $viewData['title'] = __('controller.plants.manage');
        $viewData['plants'] = $plants;

        return view('admin.plant.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $plant = Plant::findOrFail($id);
        $viewData = [];
        $viewData['title'] = __('controller.colon_formatted.title', ['title' => $plant->getName()]);
        $viewData['plant'] = $plant;
        $viewData['category_name'] = $plant->getCategory()->getName();

        return view('admin.plant.show')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = 'Create plant';
        $viewData['categories'] = Category::all();

        return view('admin.plant.create')->with('viewData', $viewData);
    }

    public function save(Request $request): RedirectResponse
    {
        Plant::validate($request);

        $plant = new Plant();
        $plant->setName($request->input('name'));
        $plant->setDescription($request->input('description'));
        $plant->setPrice($request->input('price'));
        $plant->setStock($request->input('stock'));
        $plant->setCategoryId($request->input('category_id'));
        $plant->save();

        if ($request->hasFile('image')) {
            $imageName = $plant->getId().'.'.$request->file('image')->extension();
            $plant->setImage($this->mediaStorage->upload($request->file('image'), 'plants', $imageName));
            $plant->save();
        }

        Session::flash('success', __('controller.plants.created_successfully', ['plant' => $plant->getId()]));

        return redirect()->route('admin.plant.index');
    }

    public function delete(string $id): RedirectResponse
    {
        $plant = Plant::findOrFail($id);
        $this->mediaStorage->delete($plant->getImage(), 'plants');
        $plant->delete();

        Session::flash('danger', __('controller.plants.deleted_successfully'));

        return redirect()->route('admin.plant.index')->with('viewData', $viewData);
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $plant = Plant::findOrFail($id);

        $viewData['title'] = '';
        $viewData['plant'] = $plant;
        $viewData['category_name'] = $plant->getCategory()->getName();
        $viewData['category_id'] = $plant->getCategory()->getId();
        $viewData['categories'] = Category::all();

        return view('admin.plant.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        Plant::validate($request);

        $plant = Plant::findOrFail($id);
        $plant->setName($request->input('name'));
        $plant->setDescription($request->input('description'));
        $plant->setPrice((int) $request->input('price'));
        $plant->setStock((int) $request->input('stock'));
        $plant->setCategoryId((int) $request->input('category_id'));

        if ($request->hasFile('image')) {
            $imageName = $plant->getId().'.'.$request->file('image')->extension();

            $this->mediaStorage->delete($plant->getImage(), 'plants');
            $plant->setImage($this->mediaStorage->upload($request->file('image'), 'plants', $imageName));
        }

        $plant->save();

        Session::flash('message', __('controller.plants.editted_successfully'));

        return redirect()->route('admin.plant.index');
    }
}
