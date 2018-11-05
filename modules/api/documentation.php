<?php

return [
    '/api/users/sign-in' => [
        'methods' => ['POST'],
        'description' => 'Allows users to sign in',
        'requireAuthorization' => false,
        'bodyParams' => [
            'email' => 'required,string,email',
            'password' => 'required,string',
        ],
        'responseSample' => '
{
    "success": true,
    "error": null,
    "data":{
        "user": {
            "id": 4,
            "email": "deniskoronets+2@woo.zp.ua",
            "created_at": "2018-11-02 14:40:53",
            "updated_at": null,
            "avatarUrl": "http://localhost:8080/avatars5bdc61f523353.jpg",
            "avatarThumbnailUrl": "http://localhost:8080/avatars5bdc61f58d910.jpg"
        },
        "jwtToken": "..."
    }
}
        '
    ],
    '/api/users/sign-up' => [
        'methods' => ['POST'],
        'description' => 'Allows users to sign up',
        'requireAuthorization' => false,
        'bodyParams' => [
            'email' => 'required,string,email',
            'password' => 'required,string,min=6',
            'avatar' => 'required,file(image)'
        ],
        'responseSample' => '
{
    "success": true,
    "error": null,
    "data":{
        "avatar": "http://localhost:8080/avatars5bdc61f523353.jpg",
        "jwtToken": "..."
    }
}
        '
    ],
    '/api/github/email-users' => [
        'methods' => ['POST'],
        'description' => 'Allows users to sign in',
        'requireAuthorization' => true,
        'bodyParams' => [
            'usernames' => 'required,array',
            'usernames[]' => 'string,min=2,max=32',
            'message' => 'required,string,max=10000',
        ],
        'responseSample' => '
{
    "success": true,
    "error": null,
    "data":[
        {
            "email": "deniskoronets@woo.zp.ua",
            "text": "Hello, my friend :)\n\nWeather at Ukraine, Zaporizhya is: Unknown",
            "sent": true
        },
        {
            "email": "octocat@github.com",
            "text": "Hello, my friend :)\n\nWeather at San Francisco is: mist",
            "sent": true
        }
    ]
}
        ',
    ],
];