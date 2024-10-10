<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_roles', only: ['index', 'show', 'export', 'print']),
            new Middleware('permission:create_roles', only: ['store']),
            new Middleware('permission:edit_roles', only: ['update']),
            new Middleware('permission:delete_roles', only: ['delete'])
        ];
    }

    public function index(){

        return view('pages.roles');
    }

    public function datatables():JsonResponse
    {
        $roles = Role::with('users', 'permissions')->get();
        return DataTables::of($roles)
        ->addIndexColumn()
        ->addColumn('user_count', function ($item) {
            return count($item->users);
        })
        ->addColumn('permission_list', function ($item) {
            return $item->permissions->map(fn($permission) => $permission->permission_badge)->implode(' ');
        })
        ->addColumn('action', function ($item) {
            $button  = '<div class="btn-group">';
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail"><i class="fas fa-search"></i></button>';
            if (Auth::user()->can('edit_roles')){
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit"><i class="fas fa-pen"></i></button>';
            }
            if (Auth::user()->can('delete_roles')){
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->name.'" data-target="#modal_delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })
        ->removeColumn(['permissions', 'users'])
        ->rawColumns(['role_badge', 'permission_list', 'user_count', 'action'])
        ->make();
    }

    public function store(StoreRoleRequest $request):JsonResponse
    {

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->checked);

        return response()->json([
            'message'   => __('site.insert_success')
        ]);
    }

    public function update(UpdateRoleRequest $request, $id):JsonResponse
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->checked);

        return response()->json([
            'message'   => __('site.update_success')
        ]);
    }

    public function show($id = null, $plain = null):JsonResponse
    {    
        $roleWithPermission = [];
        $role = '';
        if($id != null){
            // Find the role by ID, or throw a 404 error if not found.
            $role = Role::findOrFail($id);
            $roleWithPermission = $role->permissions->pluck('name')->toArray();
        }
        // Retrieve all permissions from the database.
        $permissions = Permission::all();
        $result = [];

        // Loop through each permission.
        foreach($permissions as $permission){
            // Split the permission name by underscores.
            $parts  = explode('_', $permission->name);
            // Get the first part as the prefix.
            $prefix = array_shift($parts );
            // Combine the remaining parts into a group permission string.
            $groupPermission = implode(' ', $parts );
            // Organize permissions into a nested array based on group and prefix.
            $result[$groupPermission][$prefix] = $permission->name;
        }

        $table = '';
        foreach($result as $groupPermission => $prefix){
            $table .= '<tr>';
            $table .= '<td>'.$groupPermission.'</td>';
            // Loop through the permissions under the group.
            foreach($prefix as $key => $rule){
                $class = 'text-secondary';

                // Check if the current rule is associated with the role.
                $checked = in_array($rule, $roleWithPermission) ? 'checked' : '';
                $class = $checked ? 'text-success' : 'text-secondary';

                if ($plain === null) {
                    $table .= '<td><input class="form-check-input list_check_input" type="checkbox" value="'. $rule .'" id="'. $rule .'" '. $checked .'><label class="form-check-label" for="'. $rule .'">'. $key .'</label></td>';
                } else {
                    $table .= '<td><span class="badge badge-shadow '. $class .' m-1"><i class="fas fa-check"></i> '.$key.'</span></td>';
                }
            }
            $table .= '</tr>';
        }

        return response()->json([
            'data'  => $role,
            "table" => $table
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $role = Role::findOrFail($request->id);
        $role->delete();

        return response()->json([
            'message'   => __('site.delete_success')
        ]);
    }
}