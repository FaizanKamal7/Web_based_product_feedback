@extends('layouts.master')
@section('title', 'Home')


@section('content')
<div class="container">
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
            @if (Auth::user()->is_admin)
            <a href="{{ url('/dashboard') }}" class="btn btn-outline-warning">Dashboard</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary">Log
                in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
            @endif
            @endauth
        </div>
        @endif


    </div>
    <h1 class="display-1 text-center">Product Feedback</h1>


    <div class="card text-center">
        <div class="card-header">
            Sample products
        </div>
        <div class="card-body">

            <div class="container mt-5">
                <div class="row">
                    <!-- Product Image -->
                    <div class="col-md-6">
                        <img src="https://zippypixels.com/wp-content/uploads/2015/12/01-free-iPhone-perspective-app-screen-mockup.jpg"
                            alt="Product Image" class="img-fluid" style="height: 20rem;">
                    </div>
                    <!-- Product Details -->
                    <div class="col-md-6">
                        <h2>Mango App</h2>
                        <p class="lead">An innovative app that simplifies your life.</p>
                        <p>Our app offers a comprehensive suite of tools designed to help you manage your daily tasks
                            with ease. With an intuitive design and user-friendly interface, you'll find everything you
                            need at your fingertips.</p>
                        <h3>$9.99</h3>
                        <button type="button" class="btn btn-primary">Download Now</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            Feedbacks: {{$feedbacks->count()}}
        </div>
    </div>
    <br><br>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Feedbacks</h5>

                @foreach ($feedbacks as $key => $feedback)
                <!-- FEEDBACKS -->
                <div class="media mb-4">
                    <img src="https://via.placeholder.com/64" alt="user" class="mr-3 rounded-circle">
                    <div class="media-body">
                        <h6 class="mt-0">{{$feedback->user->name}}<small> - {{$feedback->created_at}}</small>
                        </h6>
                        <span class="badge badge-pill badge-success">Category:
                            {{$feedback->feedbackCategory->name}}</span>

                        <h1 class="display-6">Title: {{$feedback->title}}</h1>
                        <p class="lead">
                            Description: {{$feedback->description}}</p>

                        <!-- Voting section -->
                        <div>
                            <!-- Upvote -->
                            <form action="{{ route('store_up_vote') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="feedback_id" value="{{ $feedback->id }}">
                                <button type="submit" class="text-success a_no_style border-0 bg-transparent p-0">
                                    Upvote <i class="bi bi-arrow-up-square"></i>
                                </button>
                            </form>

                            {{ $feedback->feedbackUpVotes()->count() - $feedback->feedbackDownVotes()->count()
                            }}

                            <!-- Downvote -->
                            <form action="{{ route('store_down_vote') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="feedback_id" value="{{ $feedback->id }}">
                                <button type="submit" class="text-danger mx-2 a_no_style border-0 bg-transparent p-0">
                                    <i class="bi bi-arrow-down-square"></i> Downvote
                                </button>
                            </form>

                            <a href="#" class="text-secondary a_no_style" data-bs-toggle="collapse"
                                data-bs-target="#replyComment1"><i class="bi bi-reply"></i> Reply</a>
                        </div>
                        <!-- Reply -->
                        <div class="collapse mt-2" id="replyComment1">
                            <div class="d-flex">
                                <input type="text" class="form-control form-control-sm" placeholder="Write a reply...">
                                <button type="button" class="btn btn-primary btn-sm ms-2">Reply</button>
                            </div>
                        </div>
                        <b onclick="toggleComments({{ $key }})" id="show_comments_text_id_{{ $key }}"><u> Hide all
                                comments</u></b>

                    </div>
                </div>


                <!-- Nested Comment -->
                <div class="comments" id="comments_{{ $key }}" style="display: block">
                    @foreach ($feedback->feedbackComments as $comment)
                    <div class="media mb-4 ml-5">
                        <img src="https://via.placeholder.com/64" alt="user" class="mr-3 rounded-circle">
                        <div class="media-body">
                            <h6 class="mt-0">{{$comment->user->name}} <small> - {{$comment->created_at}}</small></h6>
                            {!! Parsedown::instance()->text($comment->content) !!}

                            <!--<< Reactions >>-->
                            <div>
                                <form action="{{ route('store_reaction') }}" method="POST" style="display: inline;"
                                    id="reactionForm">
                                    @csrf
                                    <input type="hidden" name="comment_id" value="{{ $comment->id }}" id="commentId">
                                    <input type="hidden" name="reaction" value="" id="reactionType">

                                    <!-- Likes Span -->
                                    <span
                                        onclick="submitReaction('{{ $reactionTypeEnum::LIKE->value }}', '{{ $comment->id }}')"
                                        class="badge badge-secondary cursor-pointer" style="font-size:0.8rem;">
                                        {{ $comment->feedbackCommentLikes()->count() }} <i
                                            class="bi bi-hand-thumbs-up"></i>
                                    </span>

                                    <!-- Dislikes Span -->
                                    <span
                                        onclick="submitReaction('{{ $reactionTypeEnum::DISLIKE->value }}', '{{ $comment->id }}')"
                                        class="badge badge-secondary cursor-pointer" style="font-size:0.8rem;">
                                        {{ $comment->feedbackCommentDislikes()->count() }} <i
                                            class="bi bi-hand-thumbs-down"></i>
                                    </span>

                                    <!-- Hearts Span -->
                                    <span
                                        onclick="submitReaction('{{ $reactionTypeEnum::HEART->value }}',' {{ $comment->id }}')"
                                        class="badge badge-secondary cursor-pointer" style="font-size:0.8rem;">
                                        {{ $comment->feedbackCommentHearts()->count() }} <i class="bi bi-heart"></i>
                                    </span>

                                    <!-- Smile Span -->
                                    <span
                                        onclick="submitReaction('{{ $reactionTypeEnum::SMILE->value }}', '{{ $comment->id }}')"
                                        class="badge badge-secondary cursor-pointer" style="font-size:0.8rem;">
                                        {{ $comment->feedbackCommentSmile()->count() }} <i
                                            class="bi bi-emoji-smile"></i>
                                    </span>

                                    <!-- Sad Span -->
                                    <span
                                        onclick="submitReaction('{{ $reactionTypeEnum::SAD->value }}', '{{ $comment->id }}')"
                                        class="badge badge-secondary cursor-pointer" style="font-size:0.8rem;">
                                        {{ $comment->feedbackCommentSad()->count() }} <i class="bi bi-emoji-frown"></i>
                                    </span>

                                    <!-- Angry Span -->
                                    <span
                                        onclick="submitReaction('{{ $reactionTypeEnum::ANGRY->value }}', '{{ $comment->id }}')"
                                        class="badge badge-secondary cursor-pointer" style="font-size:0.8rem;">
                                        {{ $comment->feedbackCommentAngry()->count() }} <i
                                            class="bi bi-emoji-angry"></i>
                                    </span>
                                </form>

                            </div>
                        </div>
                    </div>
                    @endforeach


                    <!-- Add Comment -->
                    <form action="{{ route('store_feedback_comment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="feedback_id" value="{{$feedback->id}}">
                        <div class="mt-3 ml-5">
                            <label for="comment" class="form-label">Add Comment</label>
                            <!-- Textarea with decreased height -->
                            <textarea class="form-control" id="comment-{{ $key }}" name="comment"
                                rows="3"></textarea>
                            @error('comment')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </div>
                    </form>

                </div>
                <hr>
                @endforeach


            </div>
        </div>
    </div>



    {{-- A D D F E E D B A C K --}}
    @if (Auth::check())
    <div class="card border-secondary mb-3 mt-4" style="max-width: 100%;">
        <div class="card-header">Feedback</div>
        <div class="card-body text-secondary">
            <h5 class="card-title">Post a feedback</h5>
            <p class="card-text">
            <form action="{{ route('store_feedback') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Feedback Categories</label>
                    <select name="feedback_category_id" class="form-control" id="exampleFormControlSelect1">
                        @foreach ($feedback_categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    @error('feedback_category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input name="title" type="text" class="form-control" placeholder="Enter title">
                    @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Description</label>
                    <textarea name="description" class="form-control" id="exampleFormControlTextarea1"
                        rows="5"></textarea>
                    <small class="form-text text-muted">Provide detailed description.</small>
                    @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            </p>
        </div>
    </div>

    @else
    <div class="alert alert-warning" role="alert">
        Your need to <a href="{{ route('login') }}"> login </a> to post a feedback
    </div>
    @endif


</div>
<script>
    function toggleComments(key) {
        var comments = document.getElementById('comments_' + key);
        var text = document.getElementById('show_comments_text_id_' + key);

        if (comments.style.display === 'none') {
            comments.style.display = 'block';
            text.innerHTML = '<u>Hide all comments</u>';
        } else {
            comments.style.display = 'none';
            text.innerHTML = '<u>Show all comments</u>';
        }
    }

    function submitReaction(reactionValue, commentId) {
        document.getElementById('reactionType').value = reactionValue;
        document.getElementById('commentId').value = commentId;
        
        document.getElementById('reactionForm').submit();
        var comments = document.getElementById('comments');
        comments.style.display = 'block';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var textareas = document.querySelectorAll('.form-control');
        textareas.forEach(function(textarea) {
            new SimpleMDE({ element: textarea });
        });
    });
</script>


@endsection