@extends('layouts.app')

@section('title')
    @lang('pages/privacy.title')
@endsection

@section('content_title')
    @lang('pages/privacy.title')
@endsection

@section('meta_description')
    @lang('pages/privacy.meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('privacy') }}
@endsection

@section('content')
    <article class="content">
        <x-card>
            @lang('pages/privacy.content')
        </x-card>
    </article>
@endsection
