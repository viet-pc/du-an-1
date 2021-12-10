{{--@foreach($data as $value)--}}
{{--    {{$value}}--}}
{{--    @endforeach--}}
{{--@foreach($moredata as $value)--}}
{{--    {{$value}}--}}
{{--@endforeach--}}

frofile view
name : {{$loggedUserInfo->Fullname}} </br>
email: {{$loggedUserInfo->Email}} </br>
<a href="{{route('buyer.logout')}}" > logout </a>

