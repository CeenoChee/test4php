@extends('layouts.app')

@section('title')
    @lang('pages/orders.cart')
@endsection

@section('content_title')
    @lang('pages/orders.cart')
@endsection

@section('meta_description')
    @lang('pages/orders.cart_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('cart') }}
@endsection



@section('content')

    @if(count($cartItems))
        <x-order-steps :step="'cart'"/>


            <div id="cart">

                @if($errorMessages->getHeadMessages())

                    <x-alert class="alert-danger">
                        @foreach($errorMessages->getHeadMessages() as $errorMessage)
                            <div>{{ $errorMessage }}</div>
                        @endforeach
                    </x-alert>
                @endif

                <div class="prods">

                    @foreach($cartItems as $cartItem)
                        @include('pages.cart.includes.item', ['cartItem' => $cartItem, 'errorMessages' => $errorMessages])
                    @endforeach
                </div>

                @include('pages.cart.includes.summary', ['nextUrl' => LUrl::route('billing')])


            </div>


    @else
        <div class="text-center">
            <div class="text-xl">
                @lang('pages/orders.the_cart_is_empty')
            </div>

            <div class="mt-4 text-gray-500">
                Böngéssz a széles termékkínálatunkból! Ha bármilyen kérdésed van keress fel minket bátran!<br />
                Ne felejtsd el megnézni az aktuális akciókat is!
            </div>
        </div>



        <div>
           <a href="{{ LUrl::route('product.category.main') }}" class="btn bg-gradient-to-r from-cyan-500 to-sky-500 w-fit text-lg mx-auto mt-8">
               <i class="fa-solid fa-cart-shopping-fast text-2lg"></i> @lang('pages/products.go_to_products')
           </a>
        </div>


        <div class="text-center mt-4">
            <a href="{{ LUrl::route('page.promotion') }}"
               class="py-1 px-2 rounded-md hover:bg-red-500 hover:text-white bg-red-600 text-white">
                <i class="fa mr-1 fa-percent"></i>
                @lang('pages/sales.sales')
            </a>
        </div>




    @endif



@endsection
