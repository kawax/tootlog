
# Add the laravel service to supervisord
#if sudo [ ! -f /etc/supervisor/conf.d/laravel-worker.conf ]; then

laravel_worker_block="[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/vagrant/code/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=vagrant
numprocs=8
redirect_stderr=true
stdout_logfile=/home/vagrant/code/storage/logs/queue.log"

sudo sh -c "echo '$laravel_worker_block' > '/etc/supervisor/conf.d/laravel-worker.conf'"
sudo supervisorctl reread
sudo supervisorctl update

#fi
