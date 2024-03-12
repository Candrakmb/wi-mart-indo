@extends('layouts.backend.app')

@push('before-styles')
@endpush

@section('content')
    @include('backend.customer.table')
@endsection

@push('after-scripts')
    @include('backend.customer.script')
@endpush