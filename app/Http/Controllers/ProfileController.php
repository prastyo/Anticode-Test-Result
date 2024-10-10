<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateProfileRequest;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.profile');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request):JsonResponse
    {
        $user = User::find(auth()->id());
        $filter = array_filter($request->all());
        $user->update($filter);

        return response()->json([
            'message'   => __('site.update_success')
        ]);
    }

}
