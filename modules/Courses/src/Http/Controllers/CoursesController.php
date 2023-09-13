<?php

namespace Modules\Courses\src\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Categories\src\Repositories\CategoriesRepository;
use Modules\Categories\src\Repositories\CategoriesRepositoryInterface;
use Modules\Courses\src\Http\Requests\CoursesRequest;
use Modules\Courses\src\Repositories\CoursesRepository;
use Modules\Courses\src\Repositories\CoursesRepositoryInterface;
use Modules\Teacher\src\Repositories\TeacherRepository;
use Modules\Teacher\src\Repositories\TeacherRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class CoursesController extends Controller
{
    protected $coursesRepository;
    protected $categoriesRepository;
    protected $teacherRepository;

    public function __construct(
        CoursesRepository $coursesRepository,
        CategoriesRepositoryInterface $categoriesRepository,
        // TeacherRepositoryInterface $teacherRepository
    ) {
        $this->coursesRepository = $coursesRepository;
        $this->categoriesRepository = $categoriesRepository;
        // $this->teacherRepository = $teacherRepository;
    }
    public function index()
    {
        $title = 'Quản lý khóa học';

        return view('courses::lists', compact('title'));
    }

    public function data()
    {
        $courses = $this->coursesRepository->getAllCourses();

        $data = DataTables::of($courses)
            ->addColumn('edit', function ($course) {
                return '<a href="' . route('admin.courses.edit', $course) . '" class="btn btn-warning">Sửa</a>';
            })
            ->addColumn('delete', function ($course) {
                return
                    '<button  data-id= "' . $course->id . '" class="btn btn-danger btn-remove">Xóa</button>' .
                    '<input id="urlDelete" type="hidden" name="urlDelete" value="courses/delete/"></input>';
            })
            ->editColumn('created_at', function ($course) {
                return Carbon::parse($course->created_at)->format('d/m/Y H:i:s');
            })
            ->editColumn('status', function ($course) {
                return $course->status == 1 ? '<button class="btn btn-success">Ra mắt</button>' : '<button class="btn btn-warning">Chưa ra mắt</button>';
            })
            ->editColumn('price', function ($course) {
                if ($course->price) {
                    if ($course->sale_price) {
                        $price = number_format($course->sale_price) . 'đ';
                    } else {
                        $price = number_format($course->price) . 'đ';
                    }
                } else {
                    $price = 'Miễn phí';
                }

                return $price;
            })
            ->rawColumns(['edit', 'delete', 'status'])
            ->toJson();
        return $data;
    }

    public function create()
    {
        $title = 'Thêm khóa học';

        $categories = $this->categoriesRepository->getAllCategories()->get();
        // dd($categories);
        // $teacher = $this->teacherRepository->getAllTeacher()->get();

        return view('courses::add', compact('title', 'categories'));
    }

    public function store(CoursesRequest $request)
    {
        // dd('123');
        $courses = $request->except('_token');
        // dd($courses);
        if (!$courses['sale_price']) {
            $courses['sale_price'] = 0;
        }

        if (!$courses['price']) {
            $courses['price'] = 0;
        }

        $course = $this->coursesRepository->create($courses);

        $categories = $this->getCategories($courses);

        // $this->coursesRepository->createCourseCategories($course, $categories);

        return redirect()->route('admin.courses.index')->with('msg', __('courses::messages.create.success'));
    }

    public function edit($id)
    {
        $course = $this->coursesRepository->find($id);
        // dd($course);
        // $categoryIds = $this->coursesRepository->getRelatedCategories($course);

        $categories = $this->categoriesRepository->getAllCategories()->get();
        // dd($categories);
        // $teacher = $this->teacherRepository->getAllTeacher()->get();

        if (!$course) {
            abort(404);
        }

        $title = 'Cập nhật khóa học';

        return view('courses::edit', compact('course', 'title', 'categories'));
    }

    public function update(CoursesRequest $request, $id)
    {

        $courses = $request->except(['_token', '_method']);
        if (!$courses['sale_price']) {
            $courses['sale_price'] = 0;
        }

        if (!$courses['price']) {
            $courses['price'] = 0;
        }

        $this->coursesRepository->update($id, $courses);

        $categories = $this->getCategories($courses);

        $course = $this->coursesRepository->find($id);

        // $this->coursesRepository->updateCourseCategories($course, $categories);s

        return back()->with('msg', __('courses::messages.update.success'));
    }

    public function delete($id)
    {
        $this->coursesRepository->delete($id);
        //$this->coursesRepository->deleteCourseCategories($course);
        $status = $this->coursesRepository->delete($id);

        return response()->json(
            [
                "status" => true,
                'message' => 'Xóa dữ liệu thành công'
            ],
            200
        );
    }

    public function getCategories($courses)
    {
        $categories = [];
        foreach ($courses['categories'] as $category) {
            $categories[$category] = ['created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')];
        }

        return $categories;
    }
}
