<?php

namespace App\Http\Controllers\Backend;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostCatalogueRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $post;
    protected $nestedset;

    public function __construct()
    {
        $this->post = new Post();
        $this->nestedset = new Nestedsetbie([
            'table' => "post_catalogues",
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1
        ]);
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'post');

        $title = 'Quản lý nhóm bài viết';

        $condition['kw'] = $request->kw;
        $condition['publish'] = $request->integer('publish');
        $condition['post_catalogue_id'] = $request->input("post_catalogue_id");
        $condition['where'] = [
            ['tb2.language_id', '=', 1]
        ];
        $perpage = $request->integer('perpage');
        $dropdown = $this->nestedset->Dropdown();


        $posts = $this->post->pagination(
            [
                'posts.id',
                'posts.publish',
                'posts.image',
                'posts.order',
                'tb2.name',
                'tb2.canonical',
            ],
            $condition,
            [
                ['post_language as tb2', 'posts.id', '=', 'tb2.post_id'],
                ['post_catalogue_post as tb3', 'posts.id', '=', 'tb3.post_id']
            ],
            $perpage,
            ['post_catalogues'],
            [
                'posts.id',
                'desc'
            ],
            $this->whereRaw($request),
            [
                'posts.id',
                'posts.publish',
                'posts.image',
                'posts.order',
                'tb2.name',
                'tb2.canonical',
            ]
        );

        // $posts = post::paginate(10);
        return view('backend.post.post.index', compact('posts', 'title', 'dropdown'));
    }

    public function create()
    {
        $this->authorize('modules', 'post.create');

        $title = 'Thêm mới nhóm bài viết';
        $method = 'create';
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        return view("backend.post.post.store", compact('title', 'method', 'dropdown'));
    }


    public function store(StorePostRequest $request)
    {
        if ($this->post->createPost($request)) {
            return redirect()->route('post.index')->with("success", "Thêm mới nhóm bài viết thành công");
        }
        return redirect()->route('post.index')->with("error", "Thêm mới nhóm bài viết thất bại. Hãy thử lại");
    }

    public function edit($id)
    {
        $this->authorize('modules', 'post.edit');

        $title = 'Sửa thông tin nhóm bài viết';
        $post = $this->post->findPostById(
            $id,
            1,
            [
                'posts.id as id',
                'posts.post_catalogue_id',
                'posts.publish',
                'posts.image',
                'posts.icon',
                'posts.album',
                'posts.follow',
                'tb2.name as name',
                'tb2.description as description',
                'tb2.content as content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ],
            [
                ['post_language as tb2', 'posts.id', '=', 'tb2.post_id']
            ]
        );
        $method = 'edit';
        $album = json_decode($post->album);
        $dropdown = $this->nestedset->Dropdown();
        return view("backend.post.post.store", compact('title', 'post', 'method', 'dropdown', 'album'));
    }
    public function update(UpdatePostRequest $request, $id)
    {
        if ($this->post->edit($id, $request)) {
            return redirect()->route('post.index')->with("success", "Cập nhật bản ghi thành công");
        }
        return redirect()->route('post.index')->with("error", "Cập nhật bản ghi thất bại. Hãy thử lại");
    }

    public function delete($id)
    {
        $this->authorize('modules', 'post.delete');

        $post = $this->post->findPostById(
            $id,
            1,
            [
                'posts.id as id',
                'tb2.name as name',
            ],
            [
                ['post_language as tb2', 'posts.id', '=', 'tb2.post_id']
            ]
        );
        $title = 'Xóa nhóm bài viết';

        return view("backend.post.post.delete", compact('post', 'title'));
    }

    public function destroy($id, Request $request)
    {
        if ($this->post->deletePostById($id)) {
            return redirect()->route('post.index')->with("success", "Xóa bản ghi thành công");
        }
        return redirect()->route('post.index')->with("error", "Xóa bản ghi thất bại. Hãy thử lại");
    }

    private function whereRaw($request)
    {
        $rawCondition = [];
        if ($request->integer('post_catalogue_id') > 0) {
            $rawCondition['whereRaw'] = [
                [
                    'tb3.post_catalogue_id in (
                    Select id
                    from post_catalogues
                    where lft >= (Select lft from post_catalogues where id = ?)
                    and rgt <= (Select rgt from post_catalogues where id = ?))',
                    [$request->integer('post_catalogue_id'), $request->integer('post_catalogue_id')]
                ]
            ];
        }
        return $rawCondition;
    }
}
