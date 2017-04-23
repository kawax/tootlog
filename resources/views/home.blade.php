@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                @include('side.account_add')
                @include('side.account_list')
            </div>
        </div>
    </div>
@endsection
