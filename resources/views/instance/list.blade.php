@extends('layouts.app')

@section('title', 'Instances ' . config('app.name', 'tootlog'))

@section('content')
    <div class="container">
        <div class="card mb-2">
            <h2 class="card-header bg-white">Instances</h2>

            <div class="card-body">
                <div class="list-group">
                    @foreach($instances as $instance)
                        <a href="{{ $instance->domain }}"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                           target="_blank"
                           rel="noopener">

                            {{ $instance->domain }}

                            <span class="badge badge-pill badge-secondary ml-auto">{{ $instance->accounts_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{ $instances->links() }}
    </div>
@endsection
