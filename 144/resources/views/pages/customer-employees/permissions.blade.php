@extends('layouts.with-left-sidebar')

@section('head')
    <link href="{{ mix('css/datatable.css') }}" rel="stylesheet">
    <style>
        .inactive td {
            color: #b9b9b9;
            font-style: italic;
        }
    </style>
@endsection

@section('title')
    @lang('pages/account.permissions')
@endsection

@section('content_title')
    @lang('pages/account.permissions')
@endsection


@section('breadcrumb')
    {{ Breadcrumbs::render('permissions') }}
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('right-content')

    <x-card>

        @if($user->isCustomerAdmin())
            <a href="{{ LUrl::route('employee.invite.user.form') }}" class="btn w-60 mx-auto mb-8 mt-4">
                <i class="fa-solid fa-person-circle-plus text-lg"></i> @lang('pages/account.invite_employee')
            </a>
        @endif

            <div class="overflow-x-auto p-4">

                <table id="permission-table" class="w-full">
                    <thead>
                    <tr class="border-b border-gray-500">
                        <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('form.name')</th>
                        <th class="px-6 py-4 before:py-2 after:py-2 text-xs text-gray-500 uppercase">@lang('form.email')</th>
                        <th class="px-6 py-4 before:py-2 after:py-2 text-xs text-gray-500 uppercase">@lang('pages/account.permissions')</th>
                        <th class="px-6 py-4 before:py-2 after:py-2 text-xs text-gray-500 uppercase"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $employee)
                        <tr class="border-b border-gray-200 @if(!$employee->active) inactive @endif">
                            <td class="px-6 py-4 text-sm text-center text-gray-500">
                                <div>
                                    {{ $employee->name }}
                                </div>
                                <div class="text-xs italic text-gray-400">
                                    {{ $employee->position }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500">{{ $employee->mail }}</td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500">

                                <i class="fa-solid text-lg fa-user-circle @if($employee->userId) text-riel-light @else text-gray-200 @endif"
                                   title="Webes regisztráció"></i>


                                @if(isset($employee->permissions))
                                    @foreach($employee->permissions as $permission)
                                        @if(!empty($permission->icon))
                                        <i class="fa-solid text-lg {{$permission->icon}} @if($permission->value) text-riel-light @else text-gray-200 @endif"
                                           title="{{$permission->name}}"></i>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500">
                                @if(!$user->isCustomerAdmin())
                                    <a class="text-riel-light border border-riel-light rounded-full h-[40px] w-[40px] block leading-[2.8] hover:text-white hover:bg-riel-light"
                                       href="{{ LUrl::route('employee.show', ['customerId' => $employee->customerId, 'customerEmployeeId' => $employee->customerEmployeeId]) }}">
                                        <i class="fal fa-eye text-lg"></i></a>
                                    </a>
                                @elseif($employee->userId)
                                    <a class="text-riel-light border border-riel-light rounded-full h-[40px] w-[40px] block leading-[2.8] hover:text-white hover:bg-riel-light"
                                       href="{{ LUrl::route('employee.settings', ['userId' => $employee->userId]) }}">
                                        <i class="fal fa-cog text-lg"></i></a>
                                    </a>
                                @elseif($employee->customerEmployeeId)
                                    <a class="text-riel-light border border-riel-light rounded-full h-[40px] w-[40px] block leading-[2.8] hover:text-white hover:bg-riel-light"
                                       href="{{ LUrl::route('employee.invite.form', ['customerId' => $employee->customerId, 'customerEmployeeId' => $employee->customerEmployeeId]) }}">
                                        <i class="fal fa-paper-plane text-lg"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

    </x-card>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#permission-table').DataTable({
                language: {
                    url: "/assets/lang/datatable/hu.json"
                },
                columnDefs: [{
                    targets: 3,
                    orderable: false
                }]
            });
        });
    </script>
@endpush
