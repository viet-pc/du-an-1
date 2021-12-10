<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Session;

class CartController extends Controller
{
    public function index()
    {
        return view('cart/cart');
    }

    public function AddCart(Request $request, $slug, $variantId, $quantity) {
        $product = DB::table('product')->Join('variant', 'product.ProductId', '=','variant.ProductId')
            ->Where('product.Slug', $slug)
            ->Where('variant.VariantId', $variantId)
            ->Select('product.*','variant.*', 'product.Price as ProductPrice', 'product.Active as ProductActive', 'variant.Price as VariantPrice', 'variant.Active as VariantActive')
            ->first();

        if ($product != null) {
            $oldCart = Session('Cart') ? Session('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->AddCart($product, $slug, $variantId, $quantity);

            $request->Session()->put('Cart', $newCart);
        }
        return view('cart/minicart');
    }

    public function DeleteItemCart(Request $request, $slug, $variantId) {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->DeleteItemCart($slug, $variantId);

        if (Count($newCart->products) > 0) {
            $request->Session()->put('Cart', $newCart);
        } else {
            $request->Session()->forget('Cart');
        }
        return view('cart/minicart');
    }

    public function DeleteItemListCart(Request $request, $slug, $variantId) {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->DeleteItemCart($slug, $variantId);

        if (Count($newCart->products) > 0) {
            $request->Session()->put('Cart', $newCart);
        } else {
            $request->Session()->forget('Cart');
        }
        return view('cart/cartlist');
    }

    public function SaveItemListCart(Request $request, $slug, $variantId, $quantity) {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->UpdateItemCart($slug, $variantId, $quantity);

        $request->Session()->put('Cart', $newCart);
        return view('cart/cartlist');
    }

    public function SaveAllListCart(Request $request) {
        foreach ($request->data as $item) {
            $oldCart = Session('Cart') ? Session('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->UpdateItemCart($item['slug'], $item['variant'], $item['quantity']);
            $request->Session()->put('Cart', $newCart);
        }
        return view('cart/cartlist');
    }

    public function DeleteAllListCart(Request $request) {
        $request->Session()->forget('Cart');
        return view('cart/cartlist');
    }

    public function CheckQuantity(Request $request, $slug, $variantId, $quantity, $check) {
        $quantt = DB::table('product')->Join('variant', 'product.ProductId', '=','variant.ProductId')
            ->Where('product.Slug', $slug)
            ->Where('variant.VariantId', $variantId)
            ->Select('variant.Quantity')
            ->first();

        if (Session()->has('Cart') && array_key_exists($slug.'&'.$variantId, Session()->get('Cart')->products) && ($request->Session()->get('Cart')->products[$slug.'&'.$variantId]['quantity'] + $quantity) > $quantt->Quantity && $check == 1) {
            return true;
        } else {
            return $quantity > $quantt->Quantity ? true : false;
        }
    }

    protected function Checkout()
    {
        return view('cart/checkout');
    }
}
