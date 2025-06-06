@extends('layouts.backend.app')
@section('content')
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card card-statistic-2">
                <div class="card-stats mb-4">
                    <div class="card-stats-title">Order Statistics This Month
                    </div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                             <div class="card-stats-item-count">{{ $total_pending }}</div>
                            <div class="card-stats-item-label">Pending</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $total_shipping }}</div>
                            <div class="card-stats-item-label">Shipping</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $total_completed }}</div>
                            <div class="card-stats-item-label">Completed</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Orders</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_order }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>product</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_product }}
                    </div>
                </div>
            </div>
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>User</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_user }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body mb-3">
                  {!! $chartPie->container() !!}
                </div>
              </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Grafik Penjualan</h4>
                <div class="card-header-action">
                    <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                </div>
              </div>
                <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">latest order</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive table-invoice">
                <table class="table table-striped table-md">
                    <tbody>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Products</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @foreach ( $last_order as $order)
                            <tr>
                                <td><a
                                        href="{{ route('order.lihat',$order->id) }}">{{ $order->invoice_number }}</a>
                                </td>
                                <td class="font-weight-600">{{ $order->one_product }}</td>
                                <td>{!! $order->status_name !!}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <a href="{{ route('order.lihat',$order->id) }}"
                                        class="btn btn-danger">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
                <h4>Best Products</h4>
            </div>
            <div class="card-body">
                <div class="owl-carousel owl-theme" id="products-carousel">
                    @foreach ($best_products as $best_product)
                    <div class="card border-dark bg-light" style="width: auto;">
                        <div style="height: 200px; width: 241px;"> <!-- Contoh tinggi dan lebar elemen induknya -->
                            <img src="{{ $best_product->thumbnails_path }}" style="height: 100%; width: 100%;" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <div class="produk">
                                <div class="product-item pb-3">
                                    {{-- <div class="product-image">
                                        <img alt="image" src="" class="img-fluid">
                                    </div> --}}
                                    <div class="product-details">
                                        <div class="product-name">{{ $best_product->name }}</div>
                                      
                                        <div class="text-muted text-small">{{ $best_product->total_sold }}
                                            {{ __('text.sold') }}</div>
                                        <div class="product-cta">
                                            <a href="/product" class="btn btn-primary">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    {{ $chart->script() }}
    {{ $chartPie->script() }}
    <script>
        $("#products-carousel").owlCarousel({
            items: 3,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 2
                },
                768: {
                    items: 2
                },
                1200: {
                    items: 4
                }
            }
        });
    </script>
@endpush
