@extends('layouts.app')

@section('content')
    <div class="xl:flex">

        <div class="basis-1/4 hidden lg:block xl:mr-8">
            <div class="xl:w-72 w-full px-4 py-8 rounded-md shadow-2xl bg-white" >
                @yield('sidebar')
            </div>
        </div>

        <div class="basis-3/4">
           @yield('right-content')
        </div>
    </div>
@endsection
