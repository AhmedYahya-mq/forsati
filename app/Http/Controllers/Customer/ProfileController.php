<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $align=App::getLocale() !=="en"?"right":"left";
        $dir=App::getLocale() !=="en"?"rtl":"ltr";
        $timezone = session('user_timezone', 'Asia/Aden');
        // Carbon::se(); // تعيين المنطقة الزمنية لليمن

        $currentTime = Carbon::now($timezone)->format('h:i A'); // الحصول على الوقت بتنسيق 12 ساعة مع AM/PM

        return view("customer.profile.index",[
            "align"=>$align,
            "dir"=>$dir,
            "locale"=>App::getLocale(),
            "user"=>\Illuminate\Support\Facades\Auth::user(),
            "countries" => json_decode(file_get_contents(storage_path('app/countries.json'))),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
