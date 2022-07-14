<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DataTables;

class AdminController extends Controller
{
    public function index(Request $request) {
        $data = User::orderBy('name', 'ASC')->where('role', 'admin')->get();
        // dd($data);
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="table-action edit_admin" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Edit Admin"><i class="fas fa-user-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="table-action delete_admin" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Delete Admin"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.admin');
    }

    public function storeAdmin(Request $request) {
        if ($request->action == 'create') {
            $newUser = new CreateNewUser();
            $user = $newUser->create($request->all());
        } else {
            if ($request->password) {
                $validator = $this->validate(
                    $request,
                    [
                        'nama_admin' => 'required',
                        'username' => 'required',
                        'email' => 'email|nullable|unique:users,email,'.$request->admin_id,
                        'phone' => 'required|unique:users,phone,'.$request->admin_id,
                        'password' => (new Password)->length(8)->requireNumeric(),
                        'alamat' => 'required'
                    ],
                    [
                        'phone.unique' => "This phone number already taken by other user"
                    ]
                );

                $user = User::updateOrCreate(
                    ['id' => $request->admin_id],
                    [
                        'name' => $request->nama_admin,
                        'username' => $request->username,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'password' => Hash::make($request->password),
                        'address' => $request->alamat
                    ]
                );
            } else {
                $validator = $this->validate(
                    $request,
                    [
                        'nama_admin' => 'required',
                        'username' => 'required',
                        'email' => 'email|nullable|unique:users,email,'.$request->admin_id,
                        'phone' => 'required|unique:users,phone,'.$request->admin_id,
                        'alamat' => 'required'
                    ],
                    [
                        'phone.unique' => "This phone number already taken by other user"
                    ]
                );

                $user = User::updateOrCreate(
                    ['id' => $request->admin_id],
                    [
                        'name' => $request->nama_admin,
                        'username' => $request->username,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->alamat
                    ]
                );
            }
        }

        return response()->json(['response' => $user]);
    }

    public function fetchAdmin($id) {
        $admin = User::find($id);
        return response()->json($admin);
    }

    public function deleteAdmin($id) {
        User::find($id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
