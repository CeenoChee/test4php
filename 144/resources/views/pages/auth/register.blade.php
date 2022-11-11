@extends('layouts.app')

@section('title')
    @lang('pages/auth.register')
@endsection

@section('content_title')
    @lang('pages/auth.register')
@endsection

@section('meta_description')
    @lang('pages/auth.register_meta_description')
@endsection

@section('content')

    <form method="POST" action="{{ route('register', ['locale' => app('Lang')->getLocale()]) }}">
        @csrf


        <x-card class="w-full md:w-1/2 mx-auto mb-8">

            <div class="text-riel-light mb-4 font-bold">
                @lang('form.personal_data')
            </div>

            <label for="lastname" class="required">@lang('form.lastname')</label>
            <input id="lastname" type="text" placeholder="@lang('form.placeholder.lastname')"
                   class="{{ $errors->has('lastname') ? 'invalid' : '' }}" name="lastname"
                   value="{{ old('lastname') }}">
            <x-input-error :field="'lastname'"/>

            <label for="firstname" class="required">@lang('form.firstname')</label>
            <input id="firstname" type="text" placeholder="@lang('form.placeholder.firstname')"
                   class="{{ $errors->has('firstname') ? 'invalid' : '' }}" name="firstname"
                   value="{{ old('firstname') }}">
            <x-input-error :field="'firstname'"/>

            <label for="title" class="required">@lang('form.position')</label>
            <input id="title" type="text" placeholder="@lang('form.placeholder.position')"
                   class="{{ $errors->has('title') ? 'invalid' : '' }}"
                   name="title" value="{{ old('title') }}">
            <x-input-error :field="'title'"/>

            <label for="mobile" class="required">@lang('form.mobile')</label>
            <input id="mobile" type="text" placeholder="@lang('form.placeholder.mobile')"
                   class="{{ $errors->has('mobile') ? 'invalid' : '' }}"
                   name="mobile" value="{{ old('mobile') }}">
            <x-input-error :field="'mobile'"/>

            <label for="telephone">@lang('form.phone_number')</label>
            <input id="telephone" type="text" placeholder="@lang('form.placeholder.phone')"
                   class="{{ $errors->has('telephone') ? 'invalid' : '' }}"
                   name="telephone" value="{{ old('telephone') }}">
            <x-input-error :field="'telephone'"/>

            <label for="fax">@lang('form.fax')</label>
            <input id="fax" type="text" placeholder="@lang('form.placeholder.fax')"
                   class="{{ $errors->has('fax') ? 'invalid' : '' }}"
                   name="fax" value="{{ old('fax') }}">
            <x-input-error :field="'fax'"/>

        </x-card>


        <x-card class="w-full md:w-1/2 mx-auto mb-8">

            <div class="text-riel-light mb-4 font-bold">
                @lang('form.company_data')
            </div>

            <label for="company_name" class="required">@lang('form.company_name')</label>
            <input id="company_name" type="text" placeholder="@lang('form.placeholder.company_name')"
                   class="{{ $errors->has('company_name') ? 'invalid' : '' }}"
                   name="company_name" value="{{ old('company_name') }}">
            <x-input-error :field="'company_name'"/>


            <label for="company_tax_number" class="required">@lang('form.company_tax_number')</label>
            <input id="company_tax_number" type="text" placeholder="@lang('form.placeholder.company_tax_number')"
                   class="{{ $errors->has('company_tax_number') ? 'invalid' : '' }}"
                   name="company_tax_number" value="{{ old('company_tax_number') }}">
            <div class="text-red-600 font-bold relative bottom-[10px] hidden" id="company-tax-number-error"></div>

            <x-input-error :field="'company_tax_number'"/>

            <label for="company_registration_number" class="required">@lang('form.company_registration_number')</label>
            <input id="company_registration_number" type="text"
                   placeholder="@lang('form.placeholder.company_registration_number')"
                   class="{{ $errors->has('company_registration_number') ? 'invalid' : '' }}"
                   name="company_registration_number" value="{{ old('company_registration_number') }}">
            <x-input-error :field="'company_registration_number'"/>

        </x-card>


        <x-card class="w-full md:w-1/2 mx-auto mb-8">

            <div class="text-riel-light mb-4 font-bold">
                @lang('form.head_office')
            </div>

            <label for="country" class="required">@lang('form.country')</label>
            {{ Form::select('country', $countries, 0, ['id' => 'country', 'class' => 'form-control ugyfel-field']) }}
            <x-input-error :field="'country'"/>


            <label for="zip" class="required">@lang('form.zip_code')</label>
            <input id="zip" type="text" placeholder="@lang('form.placeholder.hq_zip_code')"
                   class="{{ $errors->has('zip') ? 'invalid' : '' }}"
                   name="zip" value="{{ old('zip') }}">
            <x-input-error :field="'zip'"/>


            <label for="city" class="required">@lang('form.city')</label>
            <input id="city" type="text" placeholder="@lang('form.placeholder.hq_city')"
                   class="{{ $errors->has('city') ? 'invalid' : '' }}"
                   name="city" value="{{ old('city') }}">
            <x-input-error :field="'city'"/>

            <label for="address" class="required">@lang('form.address')</label>
            <input id="address" type="text" placeholder="@lang('form.placeholder.hq_street')"
                   class="{{ $errors->has('address') ? 'invalid' : '' }}" name="address"
                   value="{{ old('address') }}">
            <x-input-error :field="'address'"/>

        </x-card>


        <x-card class="w-full md:w-1/2 mx-auto mb-8">

            <div class="text-riel-light mb-4 font-bold">
                @lang('form.login_data')
            </div>

            <label for="email" class="required">@lang('form.email')</label>
            <input id="email" type="email" placeholder="@lang('form.placeholder.email')"
                   class="{{ $errors->has('email') ? 'invalid' : '' }}"
                   name="email" value="{{ old('email') }}">
            <x-input-error :field="'email'"/>


            <label for="password" class="required">@lang('form.password')</label>
            <input id="password" type="password" placeholder="@lang('form.placeholder.password')"
                   class="{{ $errors->has('password') ? 'invalid' : '' }}" name="password">
            <x-input-error :field="'password'"/>


            <label for="password_confirmation" class="required">@lang('form.password_confirmation')</label>
            <input id="password_confirmation" type="password"
                   placeholder="@lang('form.placeholder.confirm_password')"
                   class="{{ $errors->has('password_confirmation') ? 'invalid' : '' }}"
                   name="password_confirmation">
            <x-input-error :field="'password_confirmation'"/>


            <div class="flex mt-4">
                <div class="basis-1/6">
                    <label class="switch">
                        <input type="checkbox" name="aszf" @if(old('aszf')) checked="checked" @endif>
                        <span class="switch-slider"></span>
                    </label>
                </div>
                <span class="basis-5/6">
                    <label class="required">
                        @lang('pages/auth.register_accept', ['terms_link' => LUrl::route('terms'), 'privacy_link' => LUrl::route('privacy')])
                    </label>
                     <x-input-error :field="'aszf'"/>
                </span>
            </div>

            <div class="flex mt-4">
                <div class="basis-1/6">
                    <label class="switch">
                        <input type="checkbox" name="newsletter" @if(old('newsletter')) checked="checked" @endif>
                        <span class="switch-slider"></span>
                    </label>
                </div>
                <span class="basis-5/6">
                     <label>@lang('pages/auth.newsletter_accept')</label>
                     <x-input-error :field="'newsletter'"/>
                </span>
            </div>


            <div class="text-center">
                <button type="submit" class="btn mx-auto mt-4">@lang('pages/auth.register')</button>
            </div>

        </x-card>
    </form>

@endsection

@push('scripts')
    <script>

        $('#company_tax_number').change(function () {

            let taxNumber = $(this).val();

            if(taxNumber.length >= 8){
                $.ajax({
                    url: '/check-company',
                    data: {
                        taxNumber: taxNumber,
                    },
                    type: 'POST',
                    success: function (data) {

                        if(data.error){
                            $('#company-tax-number-error').removeClass('hidden').text(data.error);
                        }else{
                            $('#company-tax-number-error').addClass('hidden');
                            $('#country').val(data.countryId);
                            $('#company_name').val(data.companyName);
                            $('#zip').val(data.address.zip[0]);
                            $('#city').val(data.address.city);
                            $('#address').val(data.address.street);
                        }

                    }
                });
            }
        });

    </script>
@endpush
