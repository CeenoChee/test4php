@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/accordion.css') }}" rel="stylesheet">
@endsection

@section('title')
    @lang('pages/faq.faq')
@endsection

@section('content_title')
    @lang('pages/faq.faq')
@endsection

@section('meta_description')
    @lang('pages/faq.faq_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('faq') }}
@endsection

@section('content')

    <x-prologue>
        @lang('pages/faq.intro')
    </x-prologue>

    <x-card class="accordion rounded-md">

        <div class="acc-item">
            <input type="checkbox" id="item1" name="item" class="item"/>
            <label for="item1" class="accordionitem">
                <h3>@lang('pages/faq.question_1')</h3>
            </label>
            <div class="hiddentext">
                {!! trans('pages/faq.answer_1') !!}
            </div>
        </div>

        <div class="acc-item">
            <input type="checkbox" id="item2" name="item" class="item"/>
            <label for="item2" class="accordionitem">
                <h3>@lang('pages/faq.question_2')</h3>
            </label>
            <div class="hiddentext">
                @lang('pages/faq.answer_2')
            </div>
        </div>

        <div class="acc-item">
            <input type="checkbox" id="item3" name="item" class="item"/>
            <label for="item3" class="accordionitem">
                <h3>@lang('pages/faq.question_3')</h3>
            </label>
            <div class="hiddentext">
                @lang('pages/faq.answer_3')
            </div>
        </div>

        <div class="acc-item">
            <input type="checkbox" id="item4" name="item" class="item"/>
            <label for="item4" class="accordionitem">
                <h3>@lang('pages/faq.question_4')</h3>
            </label>
            <div class="hiddentext">
                @lang('pages/faq.answer_4')
            </div>
        </div>

        <div class="acc-item">
            <input type="checkbox" id="item5" name="item" class="item"/>
            <label for="item5" class="accordionitem">
                <h3>@lang('pages/faq.question_5')</h3>
            </label>
            <div class="hiddentext">
                @lang('pages/faq.answer_5')
            </div>
        </div>

    </x-card>

@endsection
