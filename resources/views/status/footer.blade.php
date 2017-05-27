@can('hide', $status)
    <div class="panel-footer">
        @if($status->trashed())
            <tt-status-toggle status="{{ $status->id }}"></tt-status-toggle>
        @else
            <tt-status-toggle checked status="{{ $status->id }}"></tt-status-toggle>
        @endif
    </div>
@endcan
