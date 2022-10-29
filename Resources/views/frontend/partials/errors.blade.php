@if (isset($errors) && count($errors) > 0)
    <!--sections-->
    <div class="errors">
        @foreach ($errors->all() as $error)
            <div class="bg-red-300">
                {{$error}}
            </div>

        @endforeach
    </div>
    <!--sections-->
@endif
