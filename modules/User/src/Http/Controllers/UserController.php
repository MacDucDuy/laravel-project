<?php

namespace Modules\User\src\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\User\src\Http\Requests\UserRequest;
use Modules\User\src\Repositories\UserRepository;
use Modules\User\src\Repositories\UserRepositoryInterface;
// use Yajra\DataTables\Contracts\DataTables;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        $title = 'Quản lý người dùng';

        // $check = $this->userRepository->checkPassword('123456',1);
        // dd($check);
        return view('user::lists', compact('title'));
    }

    public function data()
    {
        $users = $this->userRepository->getAllUsers();

        $data = DataTables::of($users)
            ->addColumn('edit', function ($user) {
                return '<a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-warning">Sửa</a>';
            })
            ->addColumn('delete', function ($user) {
                return
                    '<button  data-id= "' . $user->id . '" class="btn btn-danger btn-remove">Xóa</button>' .
                    '<input id="urlDelete" type="hidden" name="urlDelete" value="users/delete/"></input>';
            })
            ->editColumn('created_at', function ($user) {
                return Carbon::parse($user->created_at)->format('d/m/Y H:i:s');
            })
            ->rawColumns(['edit', 'delete'])
            ->toJson();
        return $data;
    }

    public function create()
    {
        $title = 'Thêm người dùng';
        return view('user::add', compact('title'));
    }

    public function store(UserRequest $request)
    {
       
        $this->userRepository->create([
            'name' => $request->name,
            'email' => $request->email,
            'group_id' => $request->group_id,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('msg', __('user::messages.create.success'));
    }

    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            abort(404);
        }

        $title = 'Cập nhật người dùng';

        return view('user::edit', compact('user', 'title'));
    }

    public function update(UserRequest $request, $id)
    {
        $data = $request->except('_token', 'password');

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $this->userRepository->update($id, $data);

        return  redirect()->route('admin.users.index')->with('msg', __('user::messages.update.success'));
    }

    public function delete($id)
    {
        // dd(123);
        $this->userRepository->delete($id);

        return response()->json(
            [
                "status" => true,
                'message' => 'Xóa dữ liệu thành công'
            ],
            200
        );
    }
}
