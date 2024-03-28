@extends('layouts.backend.app')

@push('before-styles')
@endpush

@section('content')
    @if($type == "index")
        @include('backend.order.table')
    @else
        @include('backend.order.show')
    @endif
@stop

@push('after-scripts')
    @include('backend.order.script')
@endpush