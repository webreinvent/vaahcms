@if (isset($errors) && count($errors) > 0)
    <!--errors-->

    <div class="p-message p-component p-message-warn" role="alert" data-v-b04128d6=""><div class="p-message-wrapper"><span class="p-message-icon pi pi-exclamation-triangle"></span><div class="p-message-text">Warning Message Content</div><button class="p-message-close p-link" type="button"><i class="p-message-close-icon pi pi-times"></i><span class="p-ink" role="presentation"></span></button></div></div>

    <div class="p-message p-component p-message-error" role="alert" data-v-b04128d6=""><div class="p-message-wrapper"><span class="p-message-icon pi pi-times-circle"></span><div class="p-message-text">Error Message Content</div><button class="p-message-close p-link" type="button"><i class="p-message-close-icon pi pi-times"></i><span class="p-ink" role="presentation"></span></button></div></div>

    <div class="p-message p-component p-message-error" role="alert" data-v-b04128d6="">
        <div class="p-message-wrapper">
            @foreach ($errors->all() as $error)
                <div class="p-message-text">{{$error}}</div>
            @endforeach
        </div>
    </div>
    <!--/errors-->
@endif
