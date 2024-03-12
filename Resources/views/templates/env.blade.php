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
DEBUGBAR_ENABLED=false
APP_URL={{$data->app_url ?? '' }}
APP_TIMEZONE={{$data->app_timezone ?? '' }}

#VAAHCMS_VERSION={{$data->vaahcms_version ?? '' }}

VAAHCMS_VUE_APP={{$data->vaahcms_vue_app ?? '' }}
#VAAHCMS_ASSETS={{$data->vaahcms_vue_app ?? '' }}

LOG_CHANNEL=stack

DB_CONNECTION={{vh_env_string($data->db_connection)}}
DB_HOST={{vh_env_string($data->db_host)}}
DB_PORT={{vh_env_string($data->db_port)}}
DB_DATABASE={{vh_env_string($data->db_database)}}
DB_USERNAME={{vh_env_string($data->db_username)}}
DB_PASSWORD={{vh_env_string($data->db_password)}}

BROADCAST_DRIVER=log
CACHE_DRIVER=file
CACHE_PREFIX={{$data->app_name ? strtolower($data->app_name): '' }}
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_COOKIE={{$data->app_name ? strtolower($data->app_name): '' }}
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER={{vh_env_string($data->mail_driver)}}
MAIL_HOST={{vh_env_string($data->mail_host)}}
MAIL_PORT={{vh_env_string($data->mail_port)}}
MAIL_USERNAME={{vh_env_string($data->mail_username)}}
MAIL_PASSWORD={{vh_env_string($data->mail_password)}}
MAIL_ENCRYPTION={{vh_env_string($data->mail_encryption)}}

MAIL_FROM_NAME={{vh_env_string($data->mail_from_name)}}
MAIL_FROM_ADDRESS={{vh_env_string($data->mail_from_address)}}

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
