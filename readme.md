# SE
* 確認 supervisor
* 確認 crontab

## 開發環境設置 
* Laravel Version：6.*
* PHP Version：PHP 7.3
* RDBMS Version：10.4.* MariaDB(MySQL 5.5.5)
* Redis Version：5.0.5

```sql
sudo mysql -u root
DROP DATABASE se_db;CREATE DATABASE se_db;

sudo mysql -u root -p se_db < 
```

## 其他設定
### Crontab
```
* * * * * /usr/bin/php /var/www/leoMail/artisan schedule:run >/dev/null 2>&1
```
### Supervisor
```
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/php /var/www/leoMail/artisan queue:work --sleep=3 --tries=1 --memory=2048 --timeout=0
autostart=true
autorestart=true
user=www-data
numprocs=8
redirect_stderr=true
stdout_logfile=/var/log/supervisor/laravel_supervisor.log
```

## Development
### install
* `git clone xxx`
* `set .env`
* `composer  install`
* `composer dump`
* `php artisan migrate:refresh --seed`
* `php artisan schedule:run`
* `php artisan queue:listen`


## Production
* `git clone xxx`
* `set .env`
* `composer install --no-dev`
* `composer dump -o`
* `sudo chown www-data:www-data storage`
* `php artisan config:clear`
* `php artisan storage:link`
### 全清
```

sudo supervisorctl stop laravel-worker:*;sudo supervisorctl reread;
sudo supervisorctl update;sudo supervisorctl start laravel-worker:*

php artisan config:clear;php artisan view:clear;php artisan route:clear; php artisan cache:clear; php artisan clear
```


### 測試
#### php artisan tinker
```
App\Models\EmailLog::query()->where([[EmailLog::IS_SEND, false]])->count();
```
