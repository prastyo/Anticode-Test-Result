<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(Request $request)
    {
        // Retrieve the 'lang' input from the request.
        $lang = $request->input('lang');

        // Check if the 'lang' value is one of the allowed languages ('en', 'id', 'ko', 'zh'). 
        // If not, abort the request with a 400 (Bad Request) error.
        if (!in_array($lang, ['en', 'id', 'ko', 'zh'])) {
            abort(400);
        }

        // Store the selected language in the session under the 'locale' key.
        Session::put('locale', $lang);
        return redirect()->back();
    }
}