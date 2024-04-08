<?php
return [
    'postCatalogue' => [
        'index' => [
            'title' => "Quản lý nhóm bài viết",
            'table' => 'Danh sách nhóm bài viết'
        ],
        'create' => [
            'title' => "Thêm mới nhóm bài viết",
        ],
        'edit' => [
            'title' => "Cập nhật nhóm bài viết"
        ],
        'delete' => [
            'title' => "Xóa nhóm bài viết"
        ],

    ],
    'permission' => [
        'index' => [
            'title' => "Quản lý Quyền",
            'table' => 'Danh sách Quyền'
        ],
        'create' => [
            'title' => "Thêm mới Quyền",
        ],
        'edit' => [
            'title' => "Cập nhật Quyền"
        ],
        'delete' => [
            'title' => "Xóa Quyền"
        ],

    ],

    'userCatalogue' => [
        'index' => [
            'title' => "Quản lý nhóm thành viên",
            'table' => 'Danh sách nhóm thành viên'
        ],
        'create' => [
            'title' => "Thêm mới nhóm thành viên",
        ],
        'edit' => [
            'title' => "Cập nhật nhóm thành viên"
        ],
        'delete' => [
            'title' => "Xóa nhóm thành viên"
        ],
        'permission' => [
            'title' => "Quản lý quyền nhóm thành viên"
        ],

    ],
    'parent' => "Chọn danh mục cha",
    'parentNotice' => "* Chọn root nếu không có danh mục cha",
    'image' => 'Chọn ảnh đại diện',
    'advance' => 'CẤU HÌNH NÂNG CAO',
    'search' => "Tìm kiếm",
    'searchInput' => "Nhập từ khóa muốn tìm kiếm",
    'perpage' => 'bảng ghi',
    'title' => 'Tiêu đề',
    'description' => 'Mô tả ngắn',
    'content' => 'Nội dung',
    'uploadMultipleImage' => 'Upload nhiều hình ảnh',
    'seo' => 'CẤU HÌNH SEO',
    'seoTitle' => 'Bạn chưa có tiêu đề SEO',
    'seoCanonical' => 'http://duong-dan-cua-ban.html',
    'seoDescription' => 'Bạn chưa có mô tả SEO',
    'seoMetaTitle' => 'Tiêu đề SEO',
    'seoMetaKeyword' => 'Từ khóa SEO',
    'seoMetaDescription' => 'Mô tả SEO',
    'character' => 'ký tự',
    'canonical' => 'Đường dẫn',
    'tableName' => "Tên nhóm",
    'tableStatus' => "Tình trạng",
    'tableAction' => "Thao tác",
    'deleteButton' => 'Xóa dữ liệu',
    'publish' => [
        '0' => 'Chọn tình trạng',
        '1' => 'Không xuất bản',
        '2' => 'Xuất bản',
    ],
    'follow' => [
        '1' => 'No Follow',
        '2' => 'Follow',
    ],
    'generalInfo' => "Thông tin chung",
    'generalTitle' => "- Bạn đang muốn xóa ngôn ngữ có tên là:",
    'generalDescription' => "- Lưu ý: Xóa không thể khôi phục thành viên sau khi xóa. Hãy chắc chắn bạn muốn thực hiện chức năng này.",
];
