<div class="product__item">
    <div class="product__item__pic set-bg"
        data-setbg="{{ $image }}">
        <ul class="product__hover">
            <a href="{{ $image }}" class="btn btn-primary image-popup fa-solid fa-eye"></a>
            <a href="{{ $route }}" class="btn btn-primary fa-solid fa-cart-shopping"></a>
        </ul>
        

    </div>
    
    <div class="product__item__text">
        <h6><a href="{{ $route }}">{{ $name }}</a></h6>
        <div class="product__price">Rp. {{ $price }}</div>
    </div>
</div>