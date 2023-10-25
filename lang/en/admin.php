<?php

return [
    'groups' => [
        'settings' => 'Settings',
        'blog' => 'Blog',
    ],

    'user' => [
        'users' => 'Users',
        'columns' => [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
        ],
    ],

    'post_category' => [
        'post_categories' => 'Categories',
        'columns' => [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'order' => 'Order',
        ],
    ],

    'post' => [
        'posts' => 'Posts',
        'setup' => 'Setup',
        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'desciption' => 'Desciption',
            'content' => 'Content',
            'image' => 'Image',
            'status' => 'Status',
            'featured' => 'Is featured?',
            'published_date' => 'Published date',
            'categories' => 'Categories',
        ],
        'enums' => [
            'draft' => 'Draft',
            'published' => 'Published',
        ],
    ],

    'contact' => [
        'contacts' => 'Contacts',
        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'message' => 'Message',
            'note' => 'Note',
            'status' => 'Status',
            'created_at' => 'Created at',
        ],
        'enums' => [
            'new' => 'New',
            'pending' => 'Pending',
            'processed' => 'Processed',
        ],
    ]
];
