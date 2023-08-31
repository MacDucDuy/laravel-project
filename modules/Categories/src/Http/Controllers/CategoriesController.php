<?php

namespace Modules\Categories\src\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Modules\Categories\src\Http\Requests\CategoryRequest;
use Modules\Categories\src\Repositories\CategoriesRepository;
use Yajra\DataTables\Facades\DataTables;


class CategoriesController extends Controller
{
    protected $categoryRepository;
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoryRepository = $categoriesRepository;
    }
    public function index()
    {
        $title = 'Quản lí danh mục';
        $categories = $this->categoryRepository->getCategories()->get()->toArray();
        // dd($categories);
        return view('categories::lists', ['title' => $title]);
    }

    public function data()
    {
        $categories = $this->categoryRepository->getCategories();

        $categories = DataTables::of($categories)
            // ->addColumn('edit', function ($category) {
            //     return '<a href="' . route('admin.categories.edit', $category->id) . '" class="btn btn-warning">Sửa</a>';
            // })
            // ->addColumn('link', function ($category) {
            //     return '<a href="' . $category->slug . '" class="btn btn-warning">Link</a>';
            // })
            // ->addColumn('delete', function ($category) {
            //     return
            //         '<button  data-id= "' . $category->id . '" class="btn btn-danger btn-remove">Xóa</button>' .
            //         '<input id="urlDelete" type="hidden" name="urlDelete" value="categories/delete/"></input>';
            // })
            // ->editColumn('created_at', function ($category) {
            //     return Carbon::parse($category->created_at)->format('d/m/Y H:i:s');
            // })
            // ->rawColumns(['edit', 'delete', 'link'])
            ->toArray();
       
        $categories['data']= $this->getCategoriesTable($categories['data']);
  
        return $categories;
    }

    public function getCategoriesTable($categories, $char = '', &$result = [])
    {
        if (!empty($categories)) {
            foreach ($categories as $key => $category) {
                $row = $category;
                $row['name'] = $char . $row['name'];
                $row['edit'] = '<a href="' . route('admin.categories.edit', $category['id']) . '" class="btn btn-warning">Sửa</a>';
                $row['delete'] = '<button  data-id= "' . $category['id'] . '" class="btn btn-danger btn-remove">Xóa</button>' .
                '<input id="urlDelete" type="hidden" name="urlDelete" value="categories/delete/"></input>' ;
                $row['link'] = '<a target="_blank" href="/danh-muc/' . $category['slug'] . '" class="btn btn-primary">Xem</a>';
                $row['created_at'] = Carbon::parse($category['created_at'])->format('d/m/Y H:i:s');
                unset($row['sub_categories']);
                unset($row['updated_at']);
                $result[] = $row;
                if (!empty($category['sub_categories'])) {
                    $this->getCategoriesTable($category['sub_categories'], $char . '|--', $result);
                }
            }
        }

        return $result;
    }

    public function create()
    {
        $title = 'Thêm danh muc ';
        $categories = $this->categoryRepository->getAllCategories()->get();
        // dd($categories);
        return view('categories::add', compact('title', 'categories'));
    }

    // public function getCategories(){

    // }

    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->create([
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id,

        ]);

        return redirect()->route('admin.categories.index')->with('msg', __('categories::messages.create.success'));
    }

    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            abort(404);
        }
        $categories = $this->categoryRepository->getAllCategories();

        $title = 'Cập nhật danh mục';

        return view('categories::edit', compact('category', 'title', 'categories'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $data = $request->except('_token');


        $this->categoryRepository->update($id, $data);

        return  redirect()->route('admin.categories.index')->with('msg', __('categories::messages.update.success'));
    }

    public function delete($id)
    {
        $this->categoryRepository->delete($id);

        return response()->json(
            [
                "status" => true,
                'message' => 'Xóa dữ liệu thành công'
            ],
            200
        );
    }
}
