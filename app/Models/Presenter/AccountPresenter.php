<?php

namespace App\Models\Presenter;

trait AccountPresenter
{
    /**
     * @return string
     */
    public function getFaviconAttribute(): string
    {
        return $this->server->domain.'/'.
            data_get(config('tootlog.favicon'), $this->server->domain, 'favicon.ico');
    }
}
