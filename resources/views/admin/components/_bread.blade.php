@component('partials._breadcrumbs')
    <li><a href="{{route('admin.panel')}}">Administrace</a></li>
    {{$slot}}
@endcomponent
