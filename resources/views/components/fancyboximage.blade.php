<img src="{{ $src }}"
    class="cursor-pointer image-gallery"
    data-fancybox="image-gallery"
    data-src="{{ $src }}"
    @if(isset($width)) width="{{ $width }}" @endif
    @if(isset($height)) height="{{ $height }}" @endif
    @if(isset($alt)) alt="{{ $alt }}" @endif
    @if(isset($title)) title="{{ $title }}" @endif>

@if(!empty($created))
<div>Созданo: {{ $created }}</div>
@endif
@if(!empty($uploadedToOzon))
<div>Озон: {{ $uploadedToOzon }}</div>
@endif