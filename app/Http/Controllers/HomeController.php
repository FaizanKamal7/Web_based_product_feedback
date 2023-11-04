<?php

namespace App\Http\Controllers;

use App\Enums\ReactionTypeEnum;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\FeedbackComment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return Auth::user()->is_admin ? redirect('/dashboard') : redirect()->route('welcome');
    }

    public function dashboard()
    {
        $feedbacks = Feedback::paginate(3);
        $feedback_categories = FeedbackCategory::get();
        $feedback_comments = FeedbackComment::get();
        $users = User::get();

        return view('dashboard', ['feedbacks' => $feedbacks, 'feedback_categories' => $feedback_categories, 'feedback_comments' => $feedback_comments, 'users' => $users]);
    }

    public function homeView()
    {
        $feedbacks = Feedback::get();
        $feedback_categories = FeedbackCategory::get();
        return view('welcome', ['feedbacks' => $feedbacks, 'feedback_categories' => $feedback_categories]);
    }

    public function parseMentions($content)
    {
        preg_match_all('/@(\w+)/', $content, $matches);

        return $matches[1] ?? [];
    }
}
