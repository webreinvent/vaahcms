APP_NAME={{$data->app_name ?? '' }}
@if($data->app_env == 'custom')
APP_ENV={{$data->app_env_custom ?? '' }}
@else
APP_ENV={{$data->app_env ?? '' }}
@endif
APP_KEY={{$data->app_key ?? '' }}
@isset($data->app_debug)
APP_DEBUG=true
@endisset
APP_URL={{$data->app_url ?? '' }}
APP_TIMEZONE={{$data->app_timezone ?? '' }}
VAAHCMS_VERSION={{$data->vaahcms_version ?? '' }}

APP_VAAHCMS_ENV={{$data->app_vaahcms_env ?? '' }}

LOG_CHANNEL=stack

DB_CONNECTION={{$data->db_connection ?? '' }}
DB_HOST={{$data->db_host ?? '' }}
DB_PORT={{$data->db_port ?? '' }}
DB_DATABASE={{$data->db_database ?? '' }}
DB_USERNAME={{$data->db_username ?? '' }}
DB_PASSWORD={{$data->db_password ?? '' }}

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER={{$data->mail_driver ?? '' }}
MAIL_HOST={{$data->mail_host ?? '' }}
MAIL_PORT={{$data->mail_port ?? '' }}
MAIL_USERNAME={{$data->mail_username ?? '' }}
MAIL_PASSWORD={{$data->mail_password ?? '' }}
MAIL_ENCRYPTION={{$data->mail_encryption ?? '' }}

MAIL_FROM_NAME={{$data->mail_from_name ?? '' }}
MAIL_FROM_ADDRESS={{$data->test_email_to ?? '' }}

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
