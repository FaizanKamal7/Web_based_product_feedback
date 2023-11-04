{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}



@extends('layouts.master')
@section('title', 'Home')


@section('extra_style')
<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection

@include('layouts.navigation')

@section('content')
<x-slot name="header">

    <div class="container">
        <div class="alert alert-warning alert-dismissible fade show m-4" role="alert">
            <strong></strong> You are logged in as admin
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

    <!-- Main Dashboard Container -->
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar Column -->
            <div class="col-md-3">
                <div class="list-group">
                    <button type="button" class="list-group-item list-group-item-action active"
                        onclick="showSection('dashboard')">Dashboard</button>
                    <button type="button" class="list-group-item list-group-item-action"
                        onclick="showSection('users')">Orders</button>
                    <button type="button" class="list-group-item list-group-item-action"
                        onclick="showSection('retention')">Comments</button>
                </div>
            </div>
            <!-- ============================================== -->
            <!-- Dashboard Content Column -->
            <!-- ============================================== -->

            <div id="dashboard" class="content-section col-md-9">
                <h1>Welcome to the Dashboard</h1>
                <!-- Dummy Data Section -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Products</h5>
                                <p class="card-text">1</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Feedbacks</h5>
                                <p class="card-text">500</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <div class="row product-widget">
                        <!-- Product Image -->
                        <div class="col-4 col-sm-4 d-flex align-items-center">
                            <img src="https://zippypixels.com/wp-content/uploads/2015/12/01-free-iPhone-perspective-app-screen-mockup.jpg"
                                alt="Product Image" class="product-img">
                        </div>
                        <!-- Product Details -->
                        <div class="col-8 col-sm-8">
                            <div class="product-details">
                                <h2>Mango App</h2>
                                <p class="lead">An innovative app that simplifies your life.</p>
                                <p>Our app offers a comprehensive suite of tools designed to help you manage your
                                    daily
                                    tasks
                                    with ease. With an intuitive design and user-friendly interface, you'll find
                                    everything you
                                    need at your fingertips.</p>
                                <p class="product-price">$9.99</p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <hr>
                <h1 class="display-4">Feedbacks</h1>
                <!-- More Dummy Data -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">User</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>


                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $feedback->user->name }}</td>
                                    <td>{{ $feedback->title }}</td>
                                    <td>
                                        <span class="badge badge-success">{{ $feedback->feedbackCategory->name }}</span>
                                    </td>
                                    <td>{{ $feedback->description }}</td>
                                    <td>
                                        <i class="bi bi-trash-fill" data-id="{{ $feedback->id }}"
                                            data-action="deleteFeedback" style="cursor:pointer;"></i>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">No feedbacks found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Pagnation links -->
                        <div>
                            {{ $feedbacks->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================== -->
            <!-- Users Content Column -->
            <!-- ============================================== -->
            <div id="users" class="content-section col-md-9" style="display: none;">
                <h1 class="display-4">Users</h1>
                <!-- More Dummy Data -->
                <div class="row">
                    <div class="col-md-9">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">User</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Feedbacks</th>
                                    <th scope="col">Comments</th>
                                    <th scope="col">Comment Reactions</th>
                                    <th scope="col">Feedback Votes</th>
                                    <th scope="col">Creation Date</th>
                                    <th scope="col">Action</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}<br>
                                        <span class="badge badge-success">{{$user->id}}
                                    </td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->feedbacks->count() ?? 0}}</td>
                                    <td>{{$user->feedbackComments->count() ?? 0}}</td>
                                    <td>{{$user->feedbackCommentReactions->count() ?? 0}}</td>
                                    <td>{{$user->feedbackVotes->count() ?? 0}}</td>
                                    <td>{{$user->created_at ?? 0}}</td>
                                    <td>
                                        <i class="bi bi-trash-fill" data-id="{{ $user->id }}" data-action="deleteUser"
                                            style="cursor:pointer;"></i>

                                    </td>


                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- Retention Content Column -->
            <!-- ============================================== -->
            <div id="retention" class="content-section col-md-9" style="display: none;">
                <h1>Welcome to the Dashboard</h1>
                <!-- Dummy Data Section -->

                <div class="container mt-3">
                    <div class="row product-widget">
                        <!-- Product Image -->
                        <div class="col-4 col-sm-4 d-flex align-items-center">
                            <img src="https://zippypixels.com/wp-content/uploads/2015/12/01-free-iPhone-perspective-app-screen-mockup.jpg"
                                alt="Product Image" class="product-img">
                        </div>
                        <!-- Product Details -->
                        <div class="col-8 col-sm-8">
                            <div class="product-details">
                                <h2>Mango App</h2>
                                <p class="lead">An innovative app that simplifies your life.</p>
                                <p>Our app offers a comprehensive suite of tools designed to help you manage your
                                    daily
                                    tasks
                                    with ease. With an intuitive design and user-friendly interface, you'll find
                                    everything you
                                    need at your fingertips.</p>
                                <p class="product-price">$9.99</p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <hr>

                <h1 class="display-4">Comments</h1>
                <!-- More Dummy Data -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Content</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feedback_comments as $comment)

                                <tr>
                                    <td><b>{{$comment->content}}</b></td>
                                    <td>{{$comment->user->name}}</td>
                                    <td>
                                        <i class="bi bi-trash-fill" data-id="{{ $comment->id }}"
                                            data-action="deleteComment" style="cursor:pointer;"></i>

                                    </td>
                                </tr>
                                <tr style="opacity: 0.5;">
                                    <td colspan="3" class="m-1" style="border: 1px dotted black">
                                        <!-- Merge into one cell -->
                                        Feedback: <small><b>{{$comment->feedback->title}}</b></small>
                                        <!-- Display title in bold -->
                                        <small>{{$comment->feedback->description}}</small>
                                        <!-- Display description in a smaller text -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <script>
        // JavaScript to switch between content sections
        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.style.display = 'none';
            });
    
            // Remove active class from all buttons
            const buttons = document.querySelectorAll('.list-group-item');
            buttons.forEach(button => {
                button.classList.remove('active');
            });
    
            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
    
            // Add active class to the button that corresponds to the section
            document.querySelector(`[onclick="showSection('${sectionId}')"]`).classList.add('active');
        }
    
        // Call showSection with 'dashboard' on page load to display only the dashboard initially
        document.addEventListener('DOMContentLoaded', function() {
            showSection('dashboard');
        });


        document.addEventListener('DOMContentLoaded', function() {
            // Handle click on any trash icon
            document.querySelectorAll('.bi-trash-fill').forEach(function(icon) {
                icon.addEventListener('click', handleIconClick);
            });
        });

        function handleIconClick(event) {
            var id = this.getAttribute('data-id');
            var action = this.getAttribute('data-action');

            switch(action) {
                case 'deleteUser':
                    deleteUser(id);
                    break;
                case 'deleteFeedback':
                    deleteFeedback(id);
                    break;
                case 'deleteComment':
                    deleteComment(id);
                    break;
                default:
                    console.log('No action defined for this element');
            }
        }


        function deleteComment(id) {
            // Confirmation dialog
            if(confirm('Are you sure you want to delete this comment?')) {
                // AJAX request
                jQuery.ajax({
                    url: '/feedback/feedback-comment/delete-comment/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') // <-- And here as well
                    },
                    success: function(result) {
                        // On success, remove the comment from the DOM or reload
                        window.location.reload();
                    },
                    error: function(request, msg, error) {
                        // Handle failure
                        alert('Unable to delete comment.');
                    }
                });
            }
        }

        function deleteFeedback(id) {
            // Confirmation dialog
            if(confirm('Are you sure you want to delete this feedback?')) {
                // AJAX request
                jQuery.ajax({
                    url: '/feedback/delete-feedback/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') // <-- And here as well
                    },
                    success: function(result) {
                        // On success, remove the feedback from the DOM or reload
                        window.location.reload();
                    },
                    error: function(request, msg, error) {
                        // Handle failure
                        alert('Unable to delete feedback.');
                    }
                });
            }
        }

        function deleteUser(id) {
            // Confirmation dialog
            if(confirm('Are you sure you want to delete this user?')) {
                // AJAX request
                jQuery.ajax({
                    url: '/delete-user/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') // <-- And here as well
                    },
                    success: function(result) {
                        // On success, remove the user from the DOM or reload
                        window.location.reload();
                    },
                    error: function(request, msg, error) {
                        // Handle failure
                        alert('Unable to delete user.');
                    }
                });
            }
        }

    </script>

    @endsection