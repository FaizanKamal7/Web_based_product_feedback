<?php

namespace App\Http\Controllers;

use App\Enums\VoteTypeEnum;
use App\Interfaces\FeedbackInterface;
use App\Models\Feedback;
use App\Models\FeedbackComment;
use App\Models\FeedbackVote;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{

    private $feedback_repository;
    public function __construct(FeedbackInterface $feedback_repository)
    {
        $this->feedback_repository = $feedback_repository;
    }

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
            $this->feedback_repository->createFeedback([
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
            $comment = $this->feedback_repository->createFeedbackComment([
                'feedback_id' => $request->feedback_id,
                'content' => $request->comment,
                'user_id' => Auth::user()->id,
            ]);

            preg_match_all('/@([\w\-]+)/', $request->body, $matches);
            $names = $matches[1];

            foreach ($names as $name) {
                $user = User::where('name', $name)->first();
                if ($user) {
                    $mention = new Mention(['user_id' => $user->id]);
                    $comment->mentions()->save($mention);

                    // Notify the mentioned user
                    $user->notify(new UserMentioned($comment));
                }
            }

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
            $this->feedback_repository->createFeedbackVote([
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
            $this->feedback_repository->createFeedbackVote([
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


    public function storeCommentReaction(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->feedback_repository->createFeedbackCommentReaction([
                'reaction' => $request->reaction,
                'comment_id' => $request->comment_id,
                'user_id' => Auth::user()->id,
            ]);
            DB::commit();
            return Redirect::back()->with('success', 'Reaction uploaded successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Reaction not uploaded. Please try again.')->withInput();
        }
    }

    public function deleteComment($id)
    {
        $comment = FeedbackComment::findOrFail($id);
        $comment->delete();

        return response()->json(['success' => 'Comment deleted successfully'], 200);
    }

    public function deleteFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return response()->json(['success' => 'Feedback deleted successfully'], 200);
    }

    public function updateStatus(Request $request)
    {
        // Validate request, for example, ensure 'status' is a boolean
        $validatedData = $request->validate([
            'status' => 'required',
        ]);

        // Update the setting in the database...
        // Assuming you have a Model 'Setting' and a 'comments_enabled' column
        $per =  Permission::where('name', 'can_comment')->update(['is_active' => $validatedData['status'] == 'true' ? 1 : 0]);
        // Return a response, for example a simple success message
        return response()->json(['message' => 'Comment status updated successfully!']);
    }
}
