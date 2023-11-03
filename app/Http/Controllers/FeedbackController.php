<?php

namespace App\Http\Controllers;

use App\Enums\VoteTypeEnum;
use App\Models\Feedback;
use App\Models\FeedbackComment;
use App\Models\FeedbackVote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function storeFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'feedback_category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ], [
            'feedback_category_id.required' => 'The feedback category field is required.',
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            Feedback::create([
                'feedback_category_id' => $request->feedback_category_id,
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
            ]);
            DB::commit();
            return Redirect::back()->with('success', 'Feedback submitted successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Failed to submit feedback. Please try again.')->withInput();
        }
    }

    public function storeFeedbackComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'feedback_id' => 'required',
            'comment' => 'required',
        ], [
            'feedback_id.required' => 'Comment should be posted with feedback.',
            'comment.required' => "The comment can't be empty.",
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            FeedbackComment::create([
                'feedback_id' => $request->feedback_id,
                'content' => $request->comment,
                'user_id' => Auth::user()->id,
            ]);
            DB::commit();
            return Redirect::back()->with('success', 'Comment submitted successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Failed to submit feedback commit. Please try again.')->withInput();
        }
    }

    public function destroyFeedbackComment(FeedbackComment $feedback_comment)
    {
        $feedback_comment->delete();
    }

    public function storeFeedbackUpVote(Request $request)
    {
        try {
            DB::beginTransaction();
            FeedbackVote::create([
                'vote_type' => VoteTypeEnum::UP_VOTE->value,
                'feedback_id' => $request->feedback_id,
                'user_id' => Auth::user()->id,
            ]);
            DB::commit();
            return Redirect::back()->with('success', 'Upvote submitted successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Failed to submit feedback commit. Please try again.')->withInput();
        }
    }


    public function storeFeedbackDownVote(Request $request)
    {
        try {
            DB::beginTransaction();
            FeedbackVote::create([
                'vote_type' => VoteTypeEnum::DOWN_VOTE->value,
                'feedback_id' => $request->feedback_id,
                'user_id' => Auth::user()->id,
            ]);
            DB::commit();
            return Redirect::back()->with('success', 'Downvote submitted successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Failed to submit feedback commit. Please try again.')->withInput();
        }
    }
}
