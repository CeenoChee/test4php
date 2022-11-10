@extends('layouts.app')

@section('title')
    @lang('pages/repair.repair')
@endsection

@section('content_title')
	@lang('pages/repair.repair')
@endsection

@section('meta_description')
	@lang('pages/repair.repair_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('repair') }}
@endsection

@section('content')

		<x-prologue>
            @lang('pages/repair.main_text')
            <br><br>
            @lang('pages/repair.main_text_bottom')
        </x-prologue>


		<div class="grid grid-cols-1 grid-rows-3 lg:grid-cols-3 lg:grid-rows-1 gap-4 text-center ">

			<div class="p-8 bg-white shadow-2xl rounded-md">

                <div class="text-[55px] font-raleway font-black text-riel-light mb-8">1</div>

				<div class="text-content">
					<h3 class="text-2lg font-thin mb-6">@lang('pages/repair.box_title_1')</h3>
                    @lang('pages/repair.box_text_1')
				</div>
			</div>



            <div class="p-8 bg-white shadow-2xl rounded-md">

                <div class="text-[55px] font-raleway font-black text-riel-light mb-8">2</div>

                <div class="text-content">
                    <h3 class="text-2lg font-thin mb-6">@lang('pages/repair.box_title_2')</h3>
                    @lang('pages/repair.box_text_2')
                </div>
            </div>


            <div class="p-8 bg-white shadow-2xl rounded-md">

                <div class="text-[55px] font-raleway font-black text-riel-light mb-8">3</div>

                <div class="text-content">
                    <h3 class="text-2lg font-thin mb-6">@lang('pages/repair.box_title_3')</h3>
                    @lang('pages/repair.box_text_3')
                </div>
            </div>

            <div class="p-8 bg-white shadow-2xl rounded-md">

                <div class="text-[55px] font-raleway font-black text-riel-light mb-8">4</div>

                <div class="text-content">
                    <h3 class="text-2lg font-thin mb-6">@lang('pages/repair.box_title_4')</h3>
                    @lang('pages/repair.box_text_4')
                </div>
            </div>

            <div class="p-8 bg-white shadow-2xl rounded-md">

                <div class="text-[55px] font-raleway font-black text-riel-light mb-8">5</div>

                <div class="text-content">
                    <h3 class="text-2lg font-thin mb-6">@lang('pages/repair.box_title_5')</h3>
                    @lang('pages/repair.box_text_5')
                </div>
            </div>

            <div class="p-8 bg-white shadow-2xl rounded-md">

                <div class="text-[55px] font-raleway font-black text-riel-light mb-8">6</div>

                <div class="text-content">
                    <h3 class="text-2lg font-thin mb-6">@lang('pages/repair.box_title_6')</h3>
                    @lang('pages/repair.box_text_6')
                </div>
            </div>
		</div>

@endsection
