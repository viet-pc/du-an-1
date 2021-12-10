<?php
namespace App;

class Cart {
    public $products = null;
    public $totalPrice = 0;
    public $totalQuantity = 0;

    public function __construct($cart) {
        if ($cart) {
            $this->products = $cart->products;
            $this->totalPrice = $cart->totalPrice;
            $this->totalQuantity = $cart->totalQuantity;
        }
    }

    public function AddCart($product, $slug, $variantId, $quantity) {
        $price = $product->ProductPrice + ($product->ProductPrice * $product->VariantPrice);
        $newProduct = ['quantity' => 0, 'price' => $price, 'productInfo' => $product];
        if ($this->products) {
            if (array_key_exists($slug.'&'.$variantId, $this->products)) {
                $newProduct = $this->products[$slug.'&'.$variantId];
            }
        }
        $newProduct['quantity'] += $quantity;

        $newProduct['price'] = $newProduct['quantity'] * $price;
        $this->products[$slug.'&'.$variantId] = $newProduct;
        $this->totalPrice += $price * $quantity;
        $this->totalQuantity += $quantity;
    }

    public function DeleteItemCart($slug, $variantId) {
        $this->totalQuantity = abs($this->totalQuantity -= $this->products[$slug.'&'.$variantId]['quantity']);
        $this->totalPrice = abs($this->totalPrice -= $this->products[$slug.'&'.$variantId]['price']);
        unset($this->products[$slug.'&'.$variantId]);
    }

    public function UpdateItemCart($slug, $variantId, $quantity) {
        $this->totalQuantity -= $this->products[$slug.'&'.$variantId]['quantity'];
        $this->totalPrice -= $this->products[$slug.'&'.$variantId]['price'];

        $this->products[$slug.'&'.$variantId]['quantity'] = $quantity;
        $price = $this->products[$slug.'&'.$variantId]['productInfo']->ProductPrice + ($this->products[$slug.'&'.$variantId]['productInfo']->ProductPrice * $this->products[$slug.'&'.$variantId]['productInfo']->VariantPrice);
        $this->products[$slug.'&'.$variantId]['price'] = $quantity * $price;

        $this->totalQuantity += $this->products[$slug.'&'.$variantId]['quantity'];
        $this->totalPrice += $this->products[$slug.'&'.$variantId]['price'];
    }
}
