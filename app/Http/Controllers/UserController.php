<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UserExcel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_users', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_users', only: ['store']),
            new Middleware('permission:edit_users', only: ['update']),
            new Middleware('permission:delete_users', only: ['delete']),
            new Middleware('permission:trash_users', only: ['purge', 'restore']),
        ];
    }

    public function index(){
        $roles = Role::get();// Retrieve role data for the select input

        return view('pages.users.index' , compact('roles'));
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the User model and order by 'id' in descending order
        $users = User::with('roles')->orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $users->onlyTrashed();

        return DataTables::of($users)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', User::onlyTrashed()->count())
        ->addColumn('role_badge', function($user) { return $user->roles->pluck('role_badge')->implode(', '); })
        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_users') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_users') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->name.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->rawColumns(['role_badge','action'])->make(); // Generate the response for DataTables
    }

    public function store(StoreUserRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the User model using the data from the request
        $users = User::create($data);
        $users->syncRoles($request->role_name);
        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $users
        ]);
    }

    public function update(UpdateUserRequest $request, $id):JsonResponse
    {
        $users = User::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the User entry with the filtered data
        $users->update($filter);
        $users->syncRoles($request->role_name);
        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $users
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the User entry by its ID or fail if not found
        $users = User::with(
                            'roles',
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $users,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $users = User::findOrFail($request->id);
        $users->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $users
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new UserExcel($request->excel_search), 'users-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $users = User::with('roles')->get();

        $pdf = Pdf::loadView('pages.users.print', compact('users'));
        return $pdf->download('users-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $users = User::with('roles')->get();
        return view('pages.users.print' , compact('users'));
    }

    public function purge(Request $request):JsonResponse
    {
        $users = User::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $users->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $users = User::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $users->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $users
        ]);
    }
}