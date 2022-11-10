@extends('layouts.app')

@section('title')
    @lang('pages/sales.title')
@endsection

@section('content_title')
    @lang('pages/sales.title')
@endsection

@section('meta_description')
    @lang('pages/sales.title')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('promotion') }}
@endsection

@section('content')

    <x-prologue>
        @lang('pages/sales.description')
    </x-prologue>

    @foreach($sales as $sale)
        <div class="text-center bg-white shadow-2xl py-6 my-8">
            <h3 class="text-xl font-thin mb-6">{{ $sale->name }}</h3>
            @if(!$sale->images->isEmpty())
                <img class="mx-auto mb-4" src="{{ $sale->images->first()->getUrl('product-big') }}">
            @endif
            <div class="w-1/2 mx-auto font-thin mb-4">{!! $sale->description !!}</div>
            <div class="font-semibold mb-4">{!! $sale->condition !!}</div>
            <a href="{{ $sale->link }}" class="btn w-36 mx-auto" target="_blank">@lang('form.next')</a>
        </div>
    @endforeach

@endsection
