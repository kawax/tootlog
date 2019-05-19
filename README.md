# tootlog
[![Build Status](https://travis-ci.org/kawax/tootlog.svg?branch=master)](https://travis-ci.org/kawax/tootlog)
[![Maintainability](https://api.codeclimate.com/v1/badges/5c9cb2346887324c8882/maintainability)](https://codeclimate.com/github/kawax/tootlog/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/5c9cb2346887324c8882/test_coverage)](https://codeclimate.com/github/kawax/tootlog/test_coverage)

Mastodon log archives service.

https://tootlog.net/

## Requirements
- Laravel + Vue.js
- PHP >= 7.2

## Development

```
git clone https://github.com/kawax/tootlog && cd $_
composer install
yarn
# npm i
cp .env.example .env
php artisan key:generate
```

### Homestead
https://laravel.com/docs/5.7/homestead#per-project-installation

after.sh for Laravel Horizon
```
laravel_worker_block="[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/vagrant/code/artisan horizon
autostart=true
autorestart=true
user=vagrant
numprocs=1
redirect_stderr=true
stdout_logfile=/home/vagrant/code/storage/logs/queue.log"

sudo sh -c "echo '$laravel_worker_block' > '/etc/supervisor/conf.d/laravel-worker.conf'"
sudo supervisorctl reread
sudo supervisorctl update
```

## LICENSE
MIT
