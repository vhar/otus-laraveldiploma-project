@component($typeForm, get_defined_vars())
<ul>
    @foreach ($list as $row)
        <li>{{ $row }}</li>
    @endforeach    
</ul>
@endcomponent