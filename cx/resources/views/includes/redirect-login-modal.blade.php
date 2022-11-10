@if(!Auth::user() && (request()->akcios || request()->keszleten || request()->kifuto))
    <div id="redirect-login-modal" class="modal lg:!w-1/2 xl:!w-1/3">
        <h1>@lang('modals.required_login')</h1>
        <br>
        <p>@lang('modals.redirect_in_seconds')</p>
        <p>@lang('modals.please_log_in')</p>

        <div class="flex gap-4">

            <a href="{{LUrl::route('login')}}" class="btn login-btn">@lang('pages/auth.login')</a>
            <a href="#" rel="modal:close" class="btn-outline cancel-btn self-end ml-auto">@lang('global.cancel')</a>
        </div>

    </div>


    @push('scripts')
        <script>
            $("#redirect-login-modal").modal({
                fadeDuration: 100,
                clickClose: false
            });

            var timeleft = 5;
            var downloadTimer = setInterval(function () {
                if (timeleft <= 0) {
                    window.location.replace("{{LUrl::route('login')}}");
                    clearInterval(downloadTimer);
                }
                $('#redirect-login-modal #seconds-left').text(timeleft);
                timeleft -= 1;
            }, 1000);


            $(document).on('click', '#redirect-login-modal .cancel-btn, .close-modal', function () {
                clearInterval(downloadTimer);
            });


            $(document).keyup(function (e) {
                if (e.key === "Escape") {
                   clearInterval(downloadTimer);
                }
            });

        </script>
    @endpush
@endif
