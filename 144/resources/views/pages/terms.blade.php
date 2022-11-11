@extends('layouts.app')

@section('title')
    @lang('pages/terms.terms')
@endsection

@section('content_title')
    @lang('pages/terms.terms')
@endsection

@section('meta_description')
    @lang('pages/terms.meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('terms') }}
@endsection

@section('content')

    <article>
        <x-card>
            @lang('pages/terms.content')
        </x-card>
    </article>

@endsection
