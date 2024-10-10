<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_permissions', only: ['index', 'show', 'export', 'print']),
            new Middleware('permission:create_permissions', only: ['store']),
            new Middleware('permission:edit_permissions', only: ['update']),
            new Middleware('permission:delete_permissions', only: ['delete'])
        ];
    }
    public function index(){

        return view('pages.permissions');
    }

    public function datatables():JsonResponse
    {
        $permissions = Permission::with('roles')->orderBy('id','desc')->get();
        return DataTables::of($permissions)
        ->addIndexColumn()
        ->addColumn('roles_list', function ($item) {
            return $item->roles->map(fn($role) => $role->role_badge)->implode(' ');
        })
        ->addColumn('action', function ($item) {
            $button  = '<div class="btn-group">';
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail"><i class="fas fa-search"></i></button>';
            if (Auth::user()->can('edit_permissions')){
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit"><i class="fas fa-pen"></i></button>';
            }
            if (Auth::user()->can('delete_permissions')){
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->name.'" data-target="#modal_delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })
        ->removeColumn(['roles'])
        // raw HTML (not escaped)
        ->rawColumns(['permission_badge', 'roles_list', 'action'])
        ->make();
    }

    public function store(StorePermissionRequest $request):JsonResponse
    {
        Permission::create($request->all());
        return response()->json([
            'message'   => __('site.insert_success')
        ]);
    }

    public function update(UpdatePermissionRequest $request, $id):JsonResponse
    {
        $permissions = Permission::findOrFail($id);
        $permissions->update($request->all());

        return response()->json([
            'message'   => __('site.update_success')
        ]);
    }

    public function show($id):JsonResponse
    {
        $data = Permission::with('roles')->findOrFail($id);
        $data->roles_list = $data->roles->map(fn($role) => $role->role_badge)->implode(' ');

        $data->makeHidden('roles');
        return response()->json([
            "data" => $data,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $data = Permission::findOrFail($request->id);
        $data->delete();

        return response()->json([
            'message'   => __('site.delete_success')
        ]);
    }
}