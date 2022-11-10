@extends('layouts.app')

@section('main')
    @yield('top')
    <div class="row">
        <div class="col-md-8">
            @yield('content')
        </div>
        <div class="col-md-4">
            @yield('sidebar')
        </div>
    </div>
    @yield('bottom')
@endsection
