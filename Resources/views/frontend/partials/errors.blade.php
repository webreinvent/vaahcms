@if (isset($errors) && count($errors) > 0)
    <div class="p-message p-component p-message-error" role="alert" data-v-b04128d6="">
        <div class="p-message-wrapper">
            @foreach ($errors->all() as $error)
                <div class="p-message-text">{{$error}}</div>
            @endforeach
        </div>
    </div>
    <!-- /.p-message-error -->
@endif
