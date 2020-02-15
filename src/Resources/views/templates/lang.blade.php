return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines for {{$language->name}} > {{$category->name}}
    |--------------------------------------------------------------------------
    |
    */

@foreach($strings as $string)
    '{{$string->slug}}' => '{{$string->content}}',
@endforeach

];
