@extends('layouts.backend.app')

@push('before-styles')
@endpush

@section('content')
        @include('backend.setting.alamat_pengirim.form')
@stop

@push('after-scripts')
    @include('backend.setting.alamat_pengirim.script')
@endpush