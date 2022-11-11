<?php
$images = $product->images()->orderBy('sort')->get();
$mode = isset($mode) ? $mode : 'img';
$size = (! isset($size) || $size === null) ? 'thumbnail' : $size;
$src = count($images) > 0 ? $images[0]->getUrl($size) : asset('assets/images/product/no_image.png');
$s = isset($style) ? $style : '';
?>
@if($mode == 'img')
    <img data-src="{{ $src }}" alt="{{ $product->trans->Nev }}" class="mx-auto product-image lazyload" style="{{$s}}">
@elseif($mode == 'bg')
    <div class="lazyload w-[80px] h-[80px] @if(isset($list)) md:w-[60px] md:h-[60px] @else md:w-[140px] md:h-[140px] @endif bg-no-repeat bg-center bg-contain mx-auto md:mx-0 product-image" data-bg="{{ $src }}" title="{{ $product->trans->Nev }}"></div>
@endif
