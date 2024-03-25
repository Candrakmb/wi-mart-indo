<div class="product__item">
    <div class="product__item__pic set-bg"
        data-setbg="{{ $image }}">
    </div>
    
    <div class="product__item__text">
        <h6><a href="{{ $route }}">{{ $name }}</a></h6>
        <div class="product__price">Rp. {{ $price }}</div>

        <ul class="product__hover">
            <a href="{{ $image }}" class="btn btn-primary image-popup fa-solid fa-eye" style="background-color: #237B9F"></a>
            <a href="{{ $route }}" class="btn btn-primary fa-solid fa-cart-shopping" style="background-color: #237B9F"></a>
        </ul>
    </div>
</div>