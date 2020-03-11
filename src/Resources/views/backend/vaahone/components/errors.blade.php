@if (isset($errors) && count($errors) > 0)
<!--sections-->
<section class="section">
    <div class="container">

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>
</section>
<!--sections-->
@endif
