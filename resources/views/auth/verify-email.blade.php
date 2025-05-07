@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                {{ __('click here to request another') }}
                            </button>.
                        </form>

                        <!-- Add the status message area here -->
                        <span id="email-status" class="text-sm text-red-500 ms-2"></span>

                        <!-- Add a button for AJAX action -->
                        <button id="verify-email-btn" class="btn btn-primary mt-3">Send Verification Email</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.getElementById('verify-email-btn')?.addEventListener('click', function() {
            const statusSpan = document.getElementById('email-status');
            statusSpan.textContent = 'Sending...';

            // Send the POST request
            fetch('/email/verification-notification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json()) // Expecting a JSON response
                .then(data => {
                    // Check if the response contains a success message
                    if (data.message) {
                        statusSpan.textContent = data.message;
                        statusSpan.classList.remove('text-red-500');
                        statusSpan.classList.add('text-green-500');
                    } else {
                        statusSpan.textContent = 'Something went wrong.';
                        statusSpan.classList.remove('text-green-500');
                        statusSpan.classList.add('text-red-500');
                    }
                })
                .catch(error => {
                    statusSpan.textContent = 'An error occurred.';
                    statusSpan.classList.remove('text-green-500');
                    statusSpan.classList.add('text-red-500');
                    console.error(error);
                });
        });
    </script>
@endsection
