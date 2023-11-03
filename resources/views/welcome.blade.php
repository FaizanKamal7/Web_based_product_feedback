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
            <a href="{{ url('/dashboard') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
            @else
            <a href="{{ route('login') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            @endif
            @endauth
        </div>
        @endif


    </div>
    <h1>Product Feedback</h1>

    <div class="card text-center">
        <div class="card-header">
            Product
        </div>
        <div class="card-body">
            <h5 class="card-title">TXT App</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
        <div class="card-footer text-muted">
            Upvotes: 157, Downvotes: 78
        </div>
    </div>
    <br><br>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Feedbacks</h5>

                @foreach ($feedbacks as $feedback)
                <!-- FEEDBACKS -->
                <div class="media mb-4">
                    <img src="https://via.placeholder.com/64" alt="user" class="mr-3 rounded-circle">
                    <div class="media-body">
                        <h6 class="mt-0">{{$feedback->user->name}}<small> - {{$feedback->created_at}}</small>
                        </h6>
                        <b>{{$feedback->title}}</b><br>
                        {{$feedback->description}}
                        <!-- Voting section -->
                        <div>
                            <!-- Upvote form -->
                            <form action="{{ route('store_up_vote') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="feedback_id" value="{{ $feedback->id }}">
                                <button type="submit" class="text-success a_no_style border-0 bg-transparent p-0">
                                    Upvote <i class="bi bi-arrow-up-square"></i>
                                </button>
                            </form>

                            {{ $feedback->feedbackUpVotes()->count() - $feedback->feedbackDownVotes()->count() }}

                            <!-- Downvote form -->
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
                        <!-- Reply form -->
                        <div class="collapse mt-2" id="replyComment1">
                            <div class="d-flex">
                                <input type="text" class="form-control form-control-sm" placeholder="Write a reply...">
                                <button type="button" class="btn btn-primary btn-sm ms-2">Reply</button>
                            </div>
                        </div>
                        <a href=""><b>Show all comments</b></a>

                    </div>
                </div>


                <!-- Nested Comment -->
                <div class="comments">
                    @foreach ($feedback->feedbackComments as $comment)
                    <div class="media mb-4 ml-5">
                        <img src="https://via.placeholder.com/64" alt="user" class="mr-3 rounded-circle">
                        <div class="media-body">
                            <h6 class="mt-0">{{$comment->user->name}} <small>· {{$comment->created_at}}</small></h6>
                            {{$comment->content}}
                            <!-- Reactions -->
                            <div>
                                <span class="badge badge-info" style="font-size:0.8rem;"> 12
                                    <i class="bi bi-hand-thumbs-up" onclick=""></i>
                                </span>
                                <span class="badge badge-info" style="font-size:0.8rem;"> 12
                                    <i class="bi bi-hand-thumbs-down" onclick=""></i>
                                </span>
                                <span class="badge badge-info" style="font-size:0.8rem;"> 12
                                    <i class="bi bi-heart" onclick=""></i>
                                </span>
                                <span class="badge badge-info" style="font-size:0.8rem;"> 12
                                    <i class="bi bi-emoji-smile" onclick=""></i>
                                </span>
                                <span class="badge badge-info" style="font-size:0.8rem;"> 12
                                    <i class="bi bi-emoji-frown" onclick=""></i>
                                </span>
                                <span class="badge badge-info" style="font-size:0.8rem;"> 12
                                    <i class=" bi bi-emoji-angry" onclick=""></i>
                                </span>

                            </div>
                        </div>
                    </div>
                    @endforeach


                    <!-- Add Comment -->
                    <form action="{{ route('store_feedback_comment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="feedback_id" value="{{$feedback->id}}">
                        <div class="mt-3  ml-5">
                            <label for="comment" class="form-label">Add Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="5"></textarea>
                            @error('comment')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </div>
                    </form>
                </div>
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
@endsection