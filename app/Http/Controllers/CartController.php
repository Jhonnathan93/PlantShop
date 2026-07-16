<?php

// Made by: Santiago Neusa Ruiz

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plant;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $total = 0;
        $plantsInCart = [];

        $plantsInSession = $request->session()->get('plants');
        if ($plantsInSession) {
            $plantsInCart = Plant::findMany(array_keys($plantsInSession));
            $total = Plant::sumPricesByQuantities($plantsInCart, $plantsInSession);
        }

        $viewData = [];
        $viewData['title'] = __('controller.shopping_cart');
        $viewData['subtitle'] = __('controller.shopping_cart');
        $viewData['total'] = $total;
        $viewData['plants'] = $plantsInCart;
        $viewData['categories'] = Category::all();

        $userBalance = Auth::user()?->getBalance();
        $viewData['notEnoughBalance'] = $total !== 0 && ($userBalance === null || $userBalance < $total);
        $viewData['breadcrumbs'] = [
            ['title' => __('controller.home'), 'url' => route('home.index')],
            ['title' => __('controller.shopping_cart'), 'url' => route('cart.index')],
        ];

        return view('cart.index')->with('viewData', $viewData);
    }

    public function add(Request $request, string $id): RedirectResponse
    {
        $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        $plant = Plant::findOrFail($id);
        $quantity = (int) $request->input('quantity');

        if ($quantity > $plant->getStock()) {
            return back()->withErrors(['quantity' => __('controller.insufficient_stock', ['plant' => $plant->getName()])]);
        }

        $plants = $request->session()->get('plants', []);
        $plants[$id] = $quantity;
        $request->session()->put('plants', $plants);

        return redirect()->route('cart.index');
    }

    public function delete(Request $request): RedirectResponse
    {
        $request->session()->forget('plants');

        return redirect()->route('cart.index');
    }

    public function purchase(Request $request, CheckoutService $checkoutService): View|RedirectResponse
    {
        $request->validate(['address' => ['required', 'string', 'max:255']]);
        $plantsInSession = $request->session()->get('plants', []);

        if ($plantsInSession !== []) {
            $order = $checkoutService->purchase(Auth::user(), $plantsInSession, $request->string('address')->toString());
            $request->session()->forget('plants');

            $viewData = [];
            $viewData['title'] = __('controller.titles.purchase');
            $viewData['subtitle'] = __('controller.purchase_status');
            $viewData['order'] = $order;
            $viewData['categories'] = Category::all();
            $viewData['breadcrumbs'] = [
                ['title' => __('controller.home'), 'url' => route('home.index')],
                ['title' => __('controller.shopping_cart'), 'url' => route('cart.index')],
            ];

            return view('cart.purchase')->with('viewData', $viewData);

        }

        return redirect()->route('cart.index');
    }
}
