<br/>
<p align="center">
    <img src="https://raw.githubusercontent.com/webreinvent/vaahcms/master/Resources/assets/backend/vaahone/images/vaahcms-logo.svg" width="50%" />
</p>

<br/>

> **[VaahCMS](https://vaah.dev/cms)** is an open-source web application development platform shipped with headless content management system.

<br/>

**VaahCMS** is built  with `laravel 8`, `vue`, `vuex`, `buefy` and `bulma` which follows **Hierarchical Model View Controller (HMVC)** structure for its **Modules** & **Themes**.

## Quick Start
```shell
npm i vaah -g
```

```shell
vaah cms:install
```

<br/>

---

<div align="center">
  <h3>
    <a href="https://vaah.dev/cms">
      Website
    </a>
    <span> | </span>
    <a href="https://docs.vaah.dev/vaahcms">
      Documentation
    </a>
  </h3>
</div>

---

<br/>

## How is VaahCMS different?

- It's purposed to develop large applications

- Structured (**HMVC**) based modules & themes

- Shipped with **headless** CMS
  
- Encourages to use latest technologies like `Vue`, `Vuex`, `Buefy`

- Inspired with the simplicity of WordPress

<br/>

## Why VaahCMS?

Well, to answer that, ask a question to yourself: Do you want to develop an enterprise application with content management that doesn't come in your way? If answer is yes, VaahCMS is for you.



## API

#### Registration : -

- Create

##### URL
```php
GET/POST <public-url>/api/registrations/create
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    "email",                    // required
    "username",
    "password",                 // required
    "display_name",
    "title",
    "designation",
    "first_name",               // required
    "middle_name",
    "last_name",
    "gender",                   // m for male , f for female , o for Other 
    "country_calling_code",
    "phone", 
    "bio",
    "timezone",
    "alternate_email",
    "avatar_url",
    "birth", 
    "country",
    "country_code",
    "status",                  // user-created , email-verified , email-verification-pending
    "activation_code",
    "activation_code_sent_at",
    "activated_ip",
    "invited_by",
    "invited_at",
    "invited_for_key", 
    "invited_for_value", 
    "user_id",
    "user_created_at", 
    "created_ip",
    "registration_id", 
    "meta"                     // json format
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "item": {
            .............
            .............
        }
    },
    "messages": [
        "Saved successfully."
    ]
}
```
- Get a List

##### URL
```php
GET/POST <public-url>/api/registrations
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    'q'                         => 'search_item', 
    'from'                      => 'search_item', 
    'to'                        => 'search_item', 
    'status'                    => 'search_item', 
    'per_page'                  => 20,
    'trashed'                   => false,          // true, false        
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "list": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
                ..............
            ],
            "first_page_url": "<public-url>/api/registrations?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "<public-url>/api/registrations?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "<public-url>/api/registrations?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "<public-url>/api/registrations",
            "per_page": 20,
            "prev_page_url": null,
            "to": 2,
            "total": 2
        }
    }
}
```
- Get Item

##### URL
```php
GET/POST <public-url>/api/registrations/{column}/{value}
```

##### Request samples
```php
parameter = [

   'api_token'                 => 'xxxxxxxxxxx',   // for authentication
   'trashed'                   => false,          // true, false  
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        .............
        .............
        .............
    }
}
```
- Update

##### URL
```php
GET/POST <public-url>/api/registrations/{column}/{value}/update
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    "email",                    // required
    "username",
    "password",                 // required
    "display_name",
    "title",
    "designation",
    "first_name",               // required
    "middle_name",
    "last_name",
    "gender",                   // m for male , f for female , o for Other 
    "country_calling_code",
    "phone", 
    "bio",
    "timezone",
    "alternate_email",
    "avatar_url",
    "birth", 
    "country",
    "country_code",
    "status",                  // required - user-created , email-verified , email-verification-pending
    "activation_code",
    "activation_code_sent_at",
    "activated_ip",
    "invited_by",
    "invited_at",
    "invited_for_key", 
    "invited_for_value", 
    "user_id",
    "user_created_at", 
    "created_ip",
    "registration_id", 
    "meta"                     // json format
];
```

##### Response samples
```php
{
    "status": "success",
    "messages": [
        "Saved"
    ],
    "data": {
        ...........
        ...........
        ...........
    }
}
```
- Delete

##### URL
```php
GET/POST <public-url>/api/registrations/{column}/{value}/delete
```

##### Response samples
```php
{
    "status": "success",
    "data": [],
    "messages": [
        "Action was successful"
    ]
}
```
- Create User

##### URL
```php
GET/POST <public-url>/api/registrations/{column}/{value}/create-user
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "user": {
            ...........
            ...........
            ...........
        }
    },
    "messages": [
        "User is created."
    ]
}
```


#### User : -

- Create

##### URL
```php
GET/POST <public-url>/api/users/create
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    "email",                    // required
    "username",
    "password",                 // required
    "display_name",
    "title",
    "designation",
    "first_name",               // required
    "middle_name",
    "last_name",
    "gender",                   // m for male , f for female , o for Other 
    "country_calling_code",
    "phone", 
    "bio",
    "timezone",
    "alternate_email",
    "avatar_url",
    "birth", 
    "country",
    "country_code",
    "is_active",                // required       true , false
    "status",                   // required       active , in-active
    "activation_code",
    "activation_code_sent_at",
    "activated_ip",
    "invited_by",
    "invited_at",
    "invited_for_key", 
    "invited_for_value", 
    "user_id",
    "user_created_at", 
    "created_ip",
    "registration_id", 
    "meta"                     // json format
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "item": {
           ..........
           ..........
           ..........
        }
    },
    "messages": [
        "Saved successfully."
    ]
}
```
- Get a List

##### URL
```php
GET/POST <public-url>/api/users
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    'q'                         => 'search_item', 
    'from'                      => 'search_item', 
    'to'                        => 'search_item', 
    'status'                    => 'search_item', 
    'per_page'                  => 20,
    'trashed'                   => false,          // true, false        
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "list": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
                ..............
            ],
            "first_page_url": "<public-url>/api/users?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "<public-url>/api/users?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "<public-url>/api/users?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "<public-url>/api/users",
            "per_page": 20,
            "prev_page_url": null,
            "to": 2,
            "total": 2
        }
    }
}
```
- Get Item

##### URL
```php
GET/POST <public-url>/api/users/{column}/{value}
```

##### Request samples
```php
parameter = [

   'api_token'                 => 'xxxxxxxxxxx',   // for authentication
   'trashed'                   => false,          // true, false  
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        .............
        .............
        .............
    }
}
```
- Update

##### URL
```php
GET/POST <public-url>/api/users/{column}/{value}/update
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    "email",                    // required
    "username",
    "password",                 // required
    "display_name",
    "title",
    "designation",
    "first_name",               // required
    "middle_name",
    "last_name",
    "gender",                   // m for male , f for female , o for Other 
    "country_calling_code",
    "phone", 
    "bio",
    "website",
    "timezone",
    "alternate_email",
    "avatar_url",
    "birth", 
    "country",
    "country_code",
    "last_login_at",
    "last_login_ip",
    "remember_token",
    "login_otp",
    "api_token",
    "api_token_used_at",
    "api_token_used_ip",
    "is_active",
    "activated_at",
    "status",                  // required - user-created , email-verified , email-verification-pending
    "affiliate_code",
    "affiliate_code_used_at",
    "reset_password_code",
    "reset_password_code_sent_at",
    "reset_password_code_used_at",
    "foreign_user_id",
    "meta"                     // json format
    "created_ip"
];
```

##### Response samples
```php
{
    "status": "success",
    "messages": [
        "Saved"
    ],
    "data": {
        ...........
        ...........
        ...........
    }
}
```
- Delete

##### URL
```php
GET/POST <public-url>/api/users/{column}/{value}/delete
```

##### Response samples
```php
{
    "status": "success",
    "data": [],
    "messages": [
        "Action was successful"
    ]
}
```
- Get User's Roles

##### URL
```php
GET/POST <public-url>/api/users/{column}/{value}/roles
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',   // for authentication
    'q'                         => 'search_item', 
    'per_page'                  =>  20,
];
```

##### Response samples
```php
{
    "data": {
        "user": {
            .............
            .............
            .............
        },
        "roles": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
            ],
            "first_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/users/id/2/roles?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/users/id/2/roles?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "http://localhost/vikram/vaahcms-dev-env/public/api/users/id/2/roles?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "http://localhost/vikram/vaahcms-dev-env/public/api/users/id/2/roles",
            "per_page": 20,
            "prev_page_url": null,
            "to": 3,
            "total": 3
        }
    },
    "status": "success"
}
```
- User has Role

##### URL
```php
GET/POST <public-url>/api/users/{column}/{value}/roles/{role_slug}
```

##### Response samples
```php
{
    "data": true/false,
    "status": "success"
}
```
- Get User's Permissions

##### URL
```php
GET/POST <public-url>/api/users/{column}/{value}/permissions
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',   // for authentication
    'q'                         => 'search_item', 
    'per_page'                  =>  20,
];
```

##### Response samples
```php
{
    "data": {
        "user": {
            .............
            .............
            .............
        },
        "permissions": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
            ],
            "first_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/users/{column}/{value}/permissions?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/users/{column}/{value}/permissions?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "http://localhost/vikram/vaahcms-dev-env/public/api/users/{column}/{value}/permissions?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "http://localhost/vikram/vaahcms-dev-env/public/api/users/{column}/{value}/permissions",
            "per_page": 20,
            "prev_page_url": null,
            "to": 3,
            "total": 3
        }
    },
    "status": "success"
}
```
- User has Permission

##### URL
```php
GET/POST <public-url>/api/users/{column}/{value}/permissions/{permission_slug}
```

##### Response samples
```php
{
    "data": true/false,
    "status": "success"
}
```

#### Role : -

- Create

##### URL
```php
GET/POST <public-url>/api/roles/create
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    "name",                     // required
    "slug",                     // required
    "details",                  // required
    "is_active",                // required
    "type",                     // backend, frontend
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "item": {
           ..........
           ..........
           ..........
        }
    },
    "messages": [
        "Saved successfully."
    ]
}
```
- Get a List

##### URL
```php
GET/POST <public-url>/api/roles
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',   // for authentication
    'q'                         => 'search_item', 
    'from'                      =>  DateTime', 
    'to'                        =>  DateTime, 
    'filter'                    => 'active / inactive / frontend / backend', 
    'per_page'                  =>  20,
    'trashed'                   =>  false,          // true, false        
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "list": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
                ..............
            ],
            "first_page_url": "<public-url>/api/roles?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "<public-url>/api/roles?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "<public-url>/api/roles?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "<public-url>/api/roles",
            "per_page": 20,
            "prev_page_url": null,
            "to": 2,
            "total": 2
        }
    }
}
```
- Get Item

##### URL
```php
GET/POST <public-url>/api/roles/{column}/{value}
```

##### Request samples
```php
parameter = [

   'api_token'                 => 'xxxxxxxxxxx',   // for authentication
   'trashed'                   => false,          // true, false  
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        .............
        .............
        .............
    }
}
```
- Update

##### URL
```php
GET/POST <public-url>/api/roles/{column}/{value}/update
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    "name",                     // required
    "slug",                     // required
    "details",                  // required
    "is_active",                // required
    "type",                     // backend, frontend
];
```

##### Response samples
```php
{
    "status": "success",
    "messages": [
        "Saved"
    ],
    "data": {
        ...........
        ...........
        ...........
    }
}
```
- Delete

##### URL
```php
GET/POST <public-url>/api/roles/{column}/{value}/delete
```

##### Response samples
```php
{
    "status": "success",
    "data": [],
    "messages": [
        "Action was successful"
    ]
}
```
- Get Role's Users

##### URL
```php
GET/POST <public-url>/api/roles/{column}/{value}/users
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',   // for authentication
    'q'                         => 'search_item', 
    'per_page'                  =>  20,
];
```

##### Response samples
```php
{
    "data": {
        "role": {
            .............
            .............
            .............
        },
        "users": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
            ],
            "first_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/roles/id/2/users?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/roles/id/2/users?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "http://localhost/vikram/vaahcms-dev-env/public/api/roles/id/2/users?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "http://localhost/vikram/vaahcms-dev-env/public/api/roles/id/2/users",
            "per_page": 20,
            "prev_page_url": null,
            "to": 3,
            "total": 3
        }
    },
    "status": "success"
}
```
- Get Role's Permissions

##### URL
```php
GET/POST <public-url>/api/roles/{column}/{value}/permissions
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',   // for authentication
    'q'                         => 'search_item', 
    'per_page'                  =>  20,
];
```

##### Response samples
```php
{
    "data": {
        "role": {
            .............
            .............
            .............
        },
        "permissions": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
            ],
            "first_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/roles/{column}/{value}/permissions?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/roles/{column}/{value}/permissions?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "http://localhost/vikram/vaahcms-dev-env/public/api/roles/{column}/{value}/permissions?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "http://localhost/vikram/vaahcms-dev-env/public/api/roles/{column}/{value}/permissions",
            "per_page": 20,
            "prev_page_url": null,
            "to": 3,
            "total": 3
        }
    },
    "status": "success"
}
```

#### Permission : -

- Get a List

##### URL
```php
GET/POST <public-url>/api/permissions
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',   // for authentication
    'q'                         => 'search_item', 
    'from'                      =>  DateTime', 
    'to'                        =>  DateTime, 
    'filter'                    => 'active / inactive / {module_name}', 
    'section'                   => '',     // if filter = {module_name}
    'per_page'                  =>  20,
    'trashed'                   =>  false,          // true, false        
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "list": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
                ..............
            ],
            "first_page_url": "<public-url>/api/permissions?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "<public-url>/api/permissions?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "<public-url>/api/permissions?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "<public-url>/api/permissions",
            "per_page": 20,
            "prev_page_url": null,
            "to": 2,
            "total": 2
        }
    }
}
```
- Get Item

##### URL
```php
GET/POST <public-url>/api/permissions/{column}/{value}
```

##### Request samples
```php
parameter = [

   'api_token'                 => 'xxxxxxxxxxx',   // for authentication
   'trashed'                   => false,          // true, false  
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        .............
        .............
        .............
    }
}
```
- Delete

##### URL
```php
GET/POST <public-url>/api/roles/{column}/{value}/delete
```

##### Response samples
```php
{
    "status": "success",
    "data": [],
    "messages": [
        "Action was successful"
    ]
}
```
- Get Role's Users

##### URL
```php
GET/POST <public-url>/api/permissions/{column}/{value}/users
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',   // for authentication
    'q'                         => 'search_item', 
    'per_page'                  =>  20,
];
```

##### Response samples
```php
{
    "data": {
        "role": {
            .............
            .............
            .............
        },
        "users": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
            ],
            "first_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/permissions/id/2/users?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/permissions/id/2/users?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "http://localhost/vikram/vaahcms-dev-env/public/api/permissions/id/2/users?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "http://localhost/vikram/vaahcms-dev-env/public/api/permissions/id/2/users",
            "per_page": 20,
            "prev_page_url": null,
            "to": 3,
            "total": 3
        }
    },
    "status": "success"
}
```
- Get Permission's Roles

##### URL
```php
GET/POST <public-url>/api/permissions/{column}/{value}/roles
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',   // for authentication
    'q'                         => 'search_item', 
    'per_page'                  =>  20,
];
```

##### Response samples
```php
{
    "data": {
        "role": {
            .............
            .............
            .............
        },
        "permissions": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
            ],
            "first_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/permissions/{column}/{value}/roles?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://localhost/vikram/vaahcms-dev-env/public/api/permissions/{column}/{value}/roles?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "http://localhost/vikram/vaahcms-dev-env/public/api/permissions/{column}/{value}/roles?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "http://localhost/vikram/vaahcms-dev-env/public/api/permissions/{column}/{value}/roles",
            "per_page": 20,
            "prev_page_url": null,
            "to": 3,
            "total": 3
        }
    },
    "status": "success"
}
```

#### Taxonomy : -

- Create

##### URL
```php
GET/POST <public-url>/api/taxonomies/create
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    "name",                     // required
    "slug",                     // required
    "type",                     // required   {type_slug}
    "parent",                   // {parent_slug}
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "item": {
           ..........
           ..........
           ..........
        }
    },
    "messages": [
        "Saved successfully."
    ]
}
```

- Get a List

##### URL
```php
GET/POST <public-url>/api/taxonomies
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',   // for authentication
    'q'                         => 'search_item', 
    'from'                      =>  DateTime', 
    'to'                        =>  DateTime, 
    'status'                    => 'active / inactive', 
    'types'                    =>  []   {type_slugs}
    'per_page'                  =>  20,
    'trashed'                   =>  false,          // true, false        
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "list": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
                ..............
            ],
            "first_page_url": "<public-url>/api/taxonomies?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "<public-url>/api/taxonomies?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "<public-url>/api/taxonomies?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "<public-url>/api/taxonomies",
            "per_page": 20,
            "prev_page_url": null,
            "to": 2,
            "total": 2
        }
    }
}
```
- Get Item

##### URL
```php
GET/POST <public-url>/api/taxonomies/{column}/{value}
```

##### Request samples
```php
parameter = [

   'api_token'                 => 'xxxxxxxxxxx',   // for authentication
   'trashed'                   => false,          // true, false  
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        .............
        .............
        .............
    }
}
```
- Update

##### URL
```php
GET/POST <public-url>/api/taxonomies/{column}/{value}/update
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    "name",                     // required
    "slug",                     // required
    "type",                     // required   {type_slug}
    "parent",                   // {parent_slug}
];
```

##### Response samples
```php
{
    "status": "success",
    "messages": [
        "Saved"
    ],
    "data": {
        ...........
        ...........
        ...........
    }
}
```
- Delete

##### URL
```php
GET/POST <public-url>/api/taxonomies/{column}/{value}/delete
```

##### Response samples
```php
{
    "status": "success",
    "data": [],
    "messages": [
        "Action was successful"
    ]
}
```

#### Taxonomy Type : -

- Create

##### URL
```php
GET/POST <public-url>/api/taxonomy-types/create
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    "name",                     // required
    "slug",                     // required
    "parent",                   // {parent_slug}
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "item": {
           ..........
           ..........
           ..........
        }
    },
    "messages": [
        "Saved successfully."
    ]
}
```

- Get a List

##### URL
```php
GET/POST <public-url>/api/taxonomy-types
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',   // for authentication
    'q'                         => 'search_item', 
    'from'                      =>  DateTime', 
    'to'                        =>  DateTime, 
    'per_page'                  =>  20,
    'trashed'                   =>  false,          // true, false        
    'with_children'             =>  false,          // true, false        
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        "list": {
            "current_page": 1,
            "data": [
                ..............
                ..............
                ..............
                ..............
            ],
            "first_page_url": "<public-url>/api/taxonomy-types?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "<public-url>/api/taxonomy-types?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "<public-url>/api/taxonomy-types?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "<public-url>/api/taxonomy-types",
            "per_page": 20,
            "prev_page_url": null,
            "to": 2,
            "total": 2
        }
    }
}
```
- Get Item

##### URL
```php
GET/POST <public-url>/api/taxonomy-types/{column}/{value}
```

##### Request samples
```php
parameter = [

   'api_token'                 => 'xxxxxxxxxxx',   // for authentication
   'trashed'                   => false,          // true, false  
];
```

##### Response samples
```php
{
    "status": "success",
    "data": {
        .............
        .............
        .............
    }
}
```
- Update

##### URL
```php
GET/POST <public-url>/api/taxonomy-types/{column}/{value}/update
```

##### Request samples
```php
parameter = [

    'api_token'                 => 'xxxxxxxxxxx',  // for authentication
    "name",                     // required
    "slug",                     // required
    "parent",                   // {parent_slug}
];
```

##### Response samples
```php
{
    "status": "success",
    "messages": [
        "Saved"
    ],
    "data": {
        ...........
        ...........
        ...........
    }
}
```
- Delete

##### URL
```php
GET/POST <public-url>/api/taxonomy-types/{column}/{value}/delete
```

##### Response samples
```php
{
    "status": "success",
    "data": [],
    "messages": [
        "Action was successful"
    ]
}
```


<br/>

## Join us
- Contribute and raise issues at: [GitHub](https://github.com/webreinvent/vaahcms)
- Join us at: [Slack](https://join.slack.com/t/vaah/shared_invite/zt-tlop66za-yKKtiuMZ5S4lAYUQ6gtfMw)
- See roadmap at: [Trello](https://trello.com/b/MI18Rbs5/vaahcms)

We're actively seeking contributors for our [vaahcms's documentation](https://github.com/webreinvent/vaah-docs), feel free to send `pull requests`.  

<br/>

## Support us

Please consider starring the project to show your :heart: and support.

[WebReinvent](https://webreinvent.com) is a web agency based in Delhi, India. You'll find an overview of all our open source projects [on github](https://github.com/webreinvent).


<br/>

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

<br/>

[license-url]: LICENSE.md
[license-image]: https://img.shields.io/github/license/webreinvent/vaahcms?style=for-the-badge

[synk-image]: https://img.shields.io/snyk/vulnerabilities/github/webreinvent/vaahcms?label=Synk%20Vulnerabilities&style=for-the-badge
[synk-url]: https://snyk.io/test/github/webreinvent/vaahcms?targetFile=package.json "synk"
