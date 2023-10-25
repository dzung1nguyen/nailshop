<?php

return [
    'groups' => [
        'settings' => 'Cài đặt',
        'blog' => 'Blog',
    ],

    'user' => [
        'users' => 'Tài khoản',
        'columns' => [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Tên',
            'password' => 'Mật khẩu',
        ],
    ],

    'post_category' => [
        'post_categories' => 'Danh mục',
        'columns' => [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Tên',
            'order' => 'Thứ tự',
        ],
    ],

    'post' => [
        'posts' => 'Bài viết',
        'setup' => 'Cài đặt',
        'columns' => [
            'id' => 'ID',
            'title' => 'Tiêu đề',
            'desciption' => 'Mô tả',
            'content' => 'Nội dung',
            'image' => 'Hình ảnh',
            'status' => 'Trạng thái',
            'featured' => 'Nổi bật?',
            'published_date' => 'Ngày xuất bản',
            'categories' => 'Danh mục',
        ],
        'enums' => [
            'draft' => 'Nháp',
            'published' => 'Xuất bản',
        ],
    ]
];
