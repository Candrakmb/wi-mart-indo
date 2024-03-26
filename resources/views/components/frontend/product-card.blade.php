<style>
    .product__item {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-wrap: wrap;
        height: 95%; /* Mengisi tinggi kontainer */
    }

    .product__item__text {
        flex-grow: 1; /* Membuat konten teks memenuhi sisa ruang */
    }

    .product__item__text h6 {
        margin: 0; /* Menghapus margin agar rapi */
    }

    .product__item__text h6 a {
        font-size: 13px;
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
        bottom: 65px
    }

    .product__hover {
        margin-top: 10px; /* Memberi sedikit jarak dari harga */
        bottom: 25px
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
        .product__item__text h6 a {
            font-size: 25px;
            margin-bottom: 55px;
        }
        
        .product__item__text .product__price {
            margin-bottom: 50px;
            font-size: 30px;
        }

        .product__hover a {
            width: 290px;
            height: 50px;
            font-size: 20px;
            padding-top: 10px;
            margin-bottom: 15px;
        }
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