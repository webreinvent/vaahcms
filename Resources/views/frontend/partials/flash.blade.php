<!--flash message-->
@if(Session::has('flash_error'))
    <div class="notification is-danger is-light">
        <button class="delete"></button>
        {{ Session::get('flash_error') }}
    </div>
    <br clear="all"/>
@endif


@if(Session::has('flash_notice'))
    <div class="notification is-info is-light">
        <button class="delete"></button>
        {{ Session::get('flash_notice') }}
    </div>
    <br clear="all"/>
@endif

@if(Session::has('flash_warning'))
    <div class="notification is-warning is-light">
        <button class="delete"></button>
        {{ Session::get('flash_warning') }}
    </div>
    <br clear="all"/>
@endif

@if(Session::has('flash_success'))
    <div class="notification is-success is-light">
        <button class="delete"></button>
        {{ Session::get('flash_success') }}
    </div>
    <br clear="all"/>
@endif
<!--flash message-->
