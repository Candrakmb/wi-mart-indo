@extends('layouts.backend.app')

@push('before-styles')
@endpush

@section('content')
    @if($type == "index")
        @include('backend.master.product.table')
    @else
        @include('backend.master.product.form')
    @endif
@stop

@push('after-scripts')
    @include('backend.master.product.script')
@endpush