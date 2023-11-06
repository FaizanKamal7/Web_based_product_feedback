<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\Feedback;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');


Route::get('/', [HomeController::class, 'homeView'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth', 'verified', 'is_admin'])->get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/delete-user/{id}', [ProfileController::class, 'deleteUser'])->name('delete_توھد');
    Route::post('/update-comment-status', [FeedbackController::class, 'updateStatus'])->name('comment.updateStatus');


    Route::group(['prefix' => 'feedback'], function () {
        Route::post('/store-feedback', [FeedbackController::class, 'storeFeedback'])->name('store_feedback');
        Route::post('/store-feedback-comment', [FeedbackController::class, 'storeFeedbackComment'])->name('store_feedback_comment');
        Route::post('/store-up-vote', [FeedbackController::class, 'storeFeedbackUpVote'])->name('store_up_vote');
        Route::post('/store-down-vote', [FeedbackController::class, 'storeFeedbackDownVote'])->name('store_down_vote');
        Route::delete('/delete-feedback/{id}', [FeedbackController::class, 'deleteFeedback'])->name('delete_feedback');

        Route::group(['prefix' => 'feedback-comment'], function () {
            Route::post('/store-comment-reaction', [FeedbackController::class, 'storeCommentReaction'])->name('store_reaction');
            Route::delete('/delete-comment/{id}', [FeedbackController::class, 'deleteComment'])->name('delete_comment');
        });
    });
});

require __DIR__ . '/auth.php';
