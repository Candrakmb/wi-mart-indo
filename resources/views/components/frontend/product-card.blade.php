<div class="product__item">
    <div class="product__item__pic set-bg"
        data-setbg="{{ $image }}">
        <div class="label new">New</div>
        <ul class="product__hover">
            <a href="{{ $image }}" class="btn btn-info image-popup" style="color: black;" onmouseover="this.style.color='white';" onmouseout="this.style.color='black';">Primary</a>
            {{-- <a href="{{ $route }}" class="btn btn-warning" style="color: black;">Primary</a> --}}
            <a href="/product/baju/baju" class="btn btn-warning" style="color: black;">Primary</a>
        </ul>
        

    </div>
    
    <div class="product__item__text">
        <h6><a href="{{ $route }}">{{ $name }}</a></h6>
        <div class="product__price">Rp.{{ $price }}</div>
    </div>
</div>