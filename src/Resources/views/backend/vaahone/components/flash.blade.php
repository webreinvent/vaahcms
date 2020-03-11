<!--flash message-->

@if(Session::has('flash_error'))
    <!--sections-->
    <section class="section">
        <div class="container">
            {{ Session::get('flash_error') }}
        </div>
    </section>
    <!--sections-->
@endif

@if(Session::has('flash_notice'))
    <!--sections-->
    <section class="section">
        <div class="container">
            {{ Session::get('flash_notice') }}
        </div>
    </section>
    <!--sections-->
@endif

@if(Session::has('flash_warning'))
    <!--sections-->
    <section class="section">
        <div class="container">
            {{ Session::get('flash_warning') }}
        </div>
    </section>
    <!--sections-->
@endif

@if(Session::has('flash_success'))
    <!--sections-->
    <section class="section">
        <div class="container">
            {{ Session::get('flash_success') }}
        </div>
    </section>
    <!--sections-->
@endif

<!--flash message-->
