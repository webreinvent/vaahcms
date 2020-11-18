@if (isset($errors) && count($errors) > 0)
<!--sections-->
<section class="section">
    <div class="container">


        @foreach ($errors->all() as $error)
        <div class="notification is-danger is-light">
            {{ $error }}
        </div>

        @endforeach



    </div>
</section>
<!--sections-->
@endif
