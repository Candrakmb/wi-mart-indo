@extends('layouts.backend.app')

@push('before-styles')
@endpush

@section('content')
    @if($type == "index")
        @include('backend.setting.bank.table')
    @else
        @include('backend.setting.bank.form')
    @endif
@stop

@push('after-scripts')
    @include('backend.setting.bank.script')
@endpush