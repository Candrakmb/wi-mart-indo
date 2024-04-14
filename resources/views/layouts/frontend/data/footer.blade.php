<!-- Start Footer -->
<footer class="bg-light container_footer">
    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <div class="col-lg-3 col-md-12 pt-5">
                <a class="logo" href="{{ url('/') }}"><img src="{{ asset('img') }}/logo.png" alt="">Wimartindo</a>
                <ul class="list-unstyled text-dark footer-link-list">
                    <li>
                        <i class="fas fa-map-marker-alt fa-fw"></i>
                        Alamat
                    </li>
                    <li>
                        <i class="fa fa-phone fa-fw"></i>
                        <a class="text-decoration-none" href="https://wa.me/62895341044500">+62 895-3410-44500</a>
                    </li>
                    <li>
                        <i class="fa fa-envelope fa-fw"></i>
                        <a class="text-decoration-none" href="mailto:Boindonusantara@gmail.com">Boindonusantara@gmail.com</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-12 pt-5">
                <h2 class="h2 text-dark border-bottom pb-3 border-dark">Jelajahi</h2>
                <ul class="list-unstyled text-dark footer-link-list">
                    <li><a class="text-decoration-none" href="{{ url('/') }}">Home</a></li>
                    <li><a class="text-decoration-none" href="/product_list">Shop</a></li>
                    <li><a class="text-decoration-none" href="{{ route('category.index') }}">Category</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-12 pt-5">
                <h2 class="h2 text-dark border-bottom pb-3 border-dark">Pembayaran</h2>
                <div class="row gambar_pembayaran">
                    {{-- <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pembayaran/danamon.png" alt="">
                        </div>
                    </div> --}}
                    <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pembayaran/bca.png" alt="">
                        </div>
                    </div>
                    {{-- <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pembayaran/bni.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pembayaran/bri.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pembayaran/qris.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pembayaran/dana.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pembayaran/mandiri.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pembayaran/permata.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pembayaran/ovo.png" alt="">
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="col-lg-3 col-md-12 pt-5">
                <h2 class="h2 text-dark border-bottom pb-3 border-dark">Pengiriman</h2>
                <div class="row gambar_pembayaran">
                    <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pengiriman/jne.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pengiriman/tiki.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pengiriman/pos.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 gambar">
                        <div class="container_gambar">
                            <img src="{{ asset('img') }}/Pengiriman/wimart.png" alt="">
                        </div>
                    </div>
                </div>
            </div>

            
        </div>

        <div class="row text-dark mb-4 garis">
            <div class="col-12 mb-3">
                <div class="w-100 my-3 border-top border-dark"></div>
            </div>
            <div class="col-auto me-auto">
                <ul class="list-inline text-left footer-icons">
                    <li class="list-inline-item border border-dark rounded-circle text-center">
                        <a class="text-dark text-decoration-none" target="_blank" href="https://www.facebook.com/wirawiri.bojonegoro?mibextid=rS40aB7S9Ucbxw6v"><i class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-dark rounded-circle text-center">
                        <a class="text-dark text-decoration-none" target="_blank" href="https://www.instagram.com/wirawiri.indonesia?igsh=MW9yZHk5NmNpdWViZQ=="><i class="fab fa-instagram fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-dark rounded-circle text-center">
                        <a class="text-dark text-decoration-none" target="_blank" href="https://twitter.com/"><i class="fab fa-twitter fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-dark rounded-circle text-center">
                        <a class="text-dark text-decoration-none" target="_blank" href="https://www.linkedin.com/"><i class="fab fa-linkedin fa-lg fa-fw"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="w-100 bg-black py-3">
        <div class="container">
            <div class="row pt-2">
                <div class="col-12">
                    <p class="text-left text-dark">
                        Copyright &copy; 2024 Company Name 
                        | Designed by <a rel="sponsored" href="https://templatemo.com" target="_blank">Wimartindo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</footer>