<?php

namespace App\Http\Controllers;
use App;

use Illuminate\Http\Request;

class LangController extends Controller
{
    public function langChange($lang)
    {
        App::setLocale($lang);
        session()->put('new_lang', $lang);
        return redirect()->back();
    }
}
