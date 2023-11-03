<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        return Auth::user()->is_admin ? redirect('/dashboard') : redirect()->route('welcome');
    }

    public function homeView()
    {
        $feedbacks = Feedback::get();
        $feedback_categories = FeedbackCategory::get();
        return view('welcome', ['feedbacks' => $feedbacks, 'feedback_categories' => $feedback_categories]);
    }
}
