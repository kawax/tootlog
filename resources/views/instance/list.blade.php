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

                            <div class="text-left">
                                <img src="{{ $instance->favicon }}" width="{{ config('tootlog.favicon_size') }}"
                                     class="rounded-circle mr-1" alt="favicon">

                                {{ $instance->domain }}
                            </div>

                            <div class="text-right">
                                <span
                                    class="badge badge-pill badge-secondary">{{ $instance->accounts_count }} users</span>
                                <span class="badge badge-pill badge-secondary">{{ $instance->version }}</span>
                            </div>

                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{ $instances->links() }}
    </div>
@endsection
