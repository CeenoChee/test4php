@extends('layouts.app')

@section('title')
    @lang('pages/downloads.download')
@endsection

@section('content_title')
    @lang('pages/downloads.download')
@endsection

@section('meta_description')
    @lang('pages/downloads.downloads_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('download', $download) }}
@endsection


@section('content')
    <x-card class="">
        <div class="mb-2">
            <img class="mx-auto"
                 src="{{ route('file.download.image', ['thumbnail', $download->getIcon()->file_name]) }}">
        </div>

        <h3 class="font-semibold text-center mb-1">
            {{ $download->trans()->name }} {{ $download->version }}
        </h3>

        <div class="text-xs text-gray-400 mb-4 text-center">
            {{ Fct::formatBytes($download->getDownload()->size) }}
        </div>

        <div class="text-gray-500 mb-8 text-center">
            {{ $download->trans()->description }}
        </div>

        <a class="btn w-48 mx-auto" href="{{ route('media.get', $download->getDownload()->file_name) }}">
            <i class="fal fa-download"></i> @lang('pages/downloads.download')
        </a>

    </x-card>

@endsection
