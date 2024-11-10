<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function __invoke(Request $request)
    {
        $scholarships=\App\Models\Scholarship::with(['degree_levels', 'specializations'])->take(value: self::perPage)->get();
        $advertisements=\App\Models\Advertisement::take(5)->get();
        $blogs=\App\Models\Blog::take(10)->get();
        $locale=\Illuminate\Support\Facades\App::getLocale();
        $funding_types = [
            "full" => $locale !== 'en' ? "تمويل كامل" : "Full Funding",
            "partial" => $locale !== 'en' ? "تمويل جزئي" : "Partial Funding",
            "private" => $locale !== 'en' ? "نفقة خاصة" : "Private Funding",
        ];
        return view('customer.index',
        [
            'user' => $request->user('web')?? null,
            'scholarships' => $scholarships,
            'blogs' =>$blogs,
            "advertisements"=> $advertisements,
            "locale"=>$locale,
            "funding_types"=>$funding_types,
        ]
        );
    }
}
