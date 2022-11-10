<?php

namespace App\Http\Controllers;

use App\Libs\Fct;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = app('Cart');
        $errorMessages = $cart->validate();

        return view('pages.cart.index', [
            'cart' => $cart,
            'cartItems' => $cart->getCartItems(),
            'errorMessages' => $errorMessages,
        ]);
    }

    public function add(Request $request): array
    {
        $product = Product::visibleForCustomer()->findOrFail($request->Termek_ID);

        $qty = (int) $request->qty;
        if ($qty < 1) {
            $qty = 1;
        }

        $cart = app('Cart');

        $error = false;
        $message = '';

        $productCustomerPrice = $product->customerPrice;
        if (! $productCustomerPrice || ! $productCustomerPrice->UgyfelAr) {
            $error = false;
        } elseif ($product->Kifuto || $product->KeszletErejeig) {
            $cartItem = $cart->getCartItem($product);
            $cartQty = $cartItem ? $cartItem->Mennyiseg : 0;

            $freeStock = $product->getStock() - ($cartQty + $cart->getAllOrderedQty($product));
            if ($freeStock < $qty) {
                $error = true;
                $message = trans('stocks.out_of_stock');
            }
        }

        if (! $error) {
            $cart->addProductQty($product, $qty);
        }

        $customerPrice = $product->getCustomerPrice();

        return [
            'error' => $error,
            'qty' => $qty,
            'delivery_time' => $this->renderDeliveryTime($product, $qty),
            'message' => $message,
            'item_price_text' => Fct::price($customerPrice),
            'sum_price_text' => Fct::price($cart->getTotal()),
            'shipping_price_text' => Fct::price($cart->getShipmentAmount()),
            'cart_qty' => $cart->getCount(),
        ];
    }

    public function set(Request $request): array
    {
        $product = Product::visibleForCustomer()->findOrFail($request->Termek_ID);

        $qty = (int) $request->qty;

        if ($qty < 1) {
            $qty = 1;
        }

        $cart = app('Cart');

        $error = false;
        $message = '';

        $customerPrice = $product->getCustomerPrice();

        if (! $customerPrice) {
            $error = true;
        } elseif ($product->Kifuto || $product->KeszletErejeig) {
            $freeStock = $product->getStock() - $cart->getAllOrderedQty($product);
            if ($freeStock < $qty) {
                $error = true;
                $message = trans('stocks.out_of_stock');
            }
        }

        if (! $error) {
            $cart->setProductQty($product, $qty);
        }

        return [
            'error' => false,
            'message' => $message,
            'qty' => $qty,
            'delivery_time' => $this->renderDeliveryTime($product, $qty),
            'item_price_text' => Fct::price($customerPrice->multiplication($qty)),
            'sum_price_text' => Fct::price($cart->getTotal()),
            'shipping_price_text' => Fct::price($cart->getShipmentAmount()),
            'cart_qty' => $cart->getCount(),
        ];
    }

    public function delete(Request $request): array
    {
        $product = Product::findOrFail($request->Termek_ID);

        $cart = app('Cart');
        $cart->deleteCartItem($product);

        return [
            'error' => false,
            'count' => $cart->getCount(),
            'sum_price_text' => Fct::price($cart->getTotal()),
            'cart_qty' => $cart->getCount(),
        ];
    }

    private function renderDeliveryTime($product, $qty): string
    {
        return view('pages.products.includes.delivery-time', ['product' => $product, 'qty' => $qty])->render();
    }
}
