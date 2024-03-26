<style>
    .product__item {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%; /* Mengisi tinggi kontainer */
    }

    .product__item__text {
        flex-grow: 1; /* Membuat konten teks memenuhi sisa ruang */
    }

    .product__item__text h6 {
        margin: 0; /* Menghapus margin agar rapi */
    }

    .product__item__text h6 a {
        font-size: 14px;
        font-weight: lighter;
        font-family: "Figtree", sans-serif;
        color: #111111;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 2;
        text-decoration: none; /* Menghapus dekorasi hyperlink */
    }

    .product__price {
        margin-top: 5px; /* Memberi sedikit jarak dengan judul */
        position: absolute; /* Mengatur posisi elemen */
        bottom: 60px
    }

    .product__hover {
        margin-top: 10px; /* Memberi sedikit jarak dari harga */
        bottom: 10px
    }
</style>

<div class="product__item">
    <div class="product__item__pic set-bg image-popup"
        data-setbg="{{ $image }}" href="{{ $image }}">
    </div>
    
    <div class="product__item__text">
        <h6><a href="{{ $route }}" class="text-ellipsis">{{ $name }}</a></h6>
        <div class="product__price">{{ $price }}</div>

        <ul class="product__hover">
            <a href="{{ $route }}" class="btn btn-primary" style="background-color: #237B9F">+ Keranjang</a>
        </ul>
    </div>
</div>