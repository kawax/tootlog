@can('hide', $status)
    <div class="panel-footer">
        @if($status->trashed())
            <tt-status-show status="{{ $status->id }}"></tt-status-show>
        @else
            <tt-status-hide status="{{ $status->id }}"></tt-status-hide>
        @endif
    </div>
@endcan
