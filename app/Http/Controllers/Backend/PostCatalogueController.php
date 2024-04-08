<?php

namespace App\Http\Controllers\Backend;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostCatalogueRequest;
use App\Http\Requests\StorePostCatalogueRequest;
use App\Http\Requests\UpdatePostCatalogueRequest;
use App\Models\Language;
use App\Models\PostCatalogue;
use Illuminate\Http\Request;

class PostCatalogueController extends Controller
{
    private $postCatalogue;
    protected $nestedset;

    public function __construct()
    {
        $this->postCatalogue = new PostCatalogue();
        $this->nestedset = new Nestedsetbie([
            'table' => "post_catalogues",
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1
        ]);
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'post.catalogue');

        $title = 'Quản lý nhóm bài viết';
        $condition['kw'] = $request->kw;
        $condition['publish'] = $request->integer('publish');
        $condition['where'] = [
            ['tb2.language_id', '=', 1]
        ];
        $perpage = $request->integer('perpage');


        $postCatalogues = $this->postCatalogue->pagination(
            [
                'post_catalogue_id as id',
                'post_catalogues.publish',
                'post_catalogues.image',
                'post_catalogues.level',
                'post_catalogues.order',
                'tb2.name as name',
                'tb2.canonical',
            ],
            $condition,
            [
                ['post_catalogue_language as tb2', 'post_catalogues.id', '=', 'tb2.post_catalogue_id']
            ],
            $perpage,
            [],
            [
                'post_catalogues.lft',
                'asc'
            ]
        );

        // $postCatalogues = postCatalogue::paginate(10);
        return view('backend.post.catalogue.index', compact('postCatalogues', 'title'));
    }

    public function create()
    {
        $this->authorize('modules', 'post.catalogue.create');

        $title = 'Thêm mới nhóm bài viết';
        $method = 'create';
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);

        return view("backend.post.catalogue.store", compact('title', 'method', 'dropdown'));
    }


    public function store(StorePostCatalogueRequest $request)
    {
        if ($this->postCatalogue->createPostCatalogue($request)) {
            return redirect()->route('post.catalogue.index')->with("success", "Thêm mới nhóm bài viết thành công");
        }
        return redirect()->route('post.catalogue.index')->with("error", "Thêm mới nhóm bài viết thất bại. Hãy thử lại");
    }

    public function edit($id)
    {
        $this->authorize('modules', 'post.catalogue.edit');

        $title = 'Sửa thông tin nhóm bài viết';
        $postCatalogue = $this->postCatalogue->findPostCatalogueById(
            $id,
            1,
            [
                'post_catalogues.id as id',
                'post_catalogues.parent_id',
                'post_catalogues.publish',
                'post_catalogues.image',
                'post_catalogues.icon',
                'post_catalogues.album',
                'post_catalogues.follow',
                'tb2.name as name',
                'tb2.description as description',
                'tb2.content as content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ],
            [
                ['post_catalogue_language as tb2', 'post_catalogues.id', '=', 'tb2.post_catalogue_id']
            ]
        );
        $method = 'edit';
        $album = json_decode($postCatalogue->album);
        $dropdown = $this->nestedset->Dropdown();
        return view("backend.post.catalogue.store", compact('title', 'postCatalogue', 'method', 'dropdown', 'album'));
    }
    public function update(UpdatePostCatalogueRequest $request, $id)
    {
        if ($this->postCatalogue->edit($id, $request)) {
            return redirect()->route('post.catalogue.index')->with("success", "Cập nhật bản ghi thành công");
        }
        return redirect()->route('post.catalogue.index')->with("error", "Cập nhật bản ghi thất bại. Hãy thử lại");
    }

    public function delete($id)
    {
        $this->authorize('modules', 'post.catalogue.delete');

        $postCatalogue = $this->postCatalogue->findPostCatalogueById(
            $id,
            1,
            [
                'post_catalogues.id as id',
                'tb2.name as name',
            ],
            [
                ['post_catalogue_language as tb2', 'post_catalogues.id', '=', 'tb2.post_catalogue_id']
            ]
        );
        $title = 'Xóa nhóm bài viết';

        return view("backend.post.catalogue.delete", compact('postCatalogue', 'title'));
    }

    public function destroy($id, DeletePostCatalogueRequest $request)
    {
        if ($this->postCatalogue->deletePostCatalogueById($id)) {
            return redirect()->route('post.catalogue.index')->with("success", "Xóa bản ghi thành công");
        }
        return redirect()->route('post.catalogue.index')->with("error", "Xóa bản ghi thất bại. Hãy thử lại");
    }
}
