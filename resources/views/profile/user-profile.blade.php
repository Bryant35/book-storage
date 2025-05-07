<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Profile</title>

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="flex bg-gray-100 text-gray-900 min-h-screen">
        @include('sidebar')
        <div class="ms-3 my-3 flex-1 bg-white rounded-lg shadow-lg p-4">
            <h1 class="text-2xl font-bold mb-4">Profile</h1>
            <div class="flex items-center">
                {{-- <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="w-24 h-24 rounded-full mr-4"> --}}
                <div>
                    <form action="profile/update" method="POST">
                        @csrf
                        <label for="name">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}"
                            class="border rounded p-2 mb-2 w-full bg-gray-300 text-gray-500" placeholder="Your Name"
                            disabled>
                        <label for="username">Username</label>
                        <input type="text" name="username" value="{{ $user->username }}"
                            class="border rounded p-2 mb-2 w-full" placeholder="Enter Your Username...">
                        <label for="email">Email</label>
                        <div class="inline-flex w-full items-center">
                            <input type="email" id="email" name="email" value="{{ $user->email }}"
                                data-email="{{ $user->email }}" class="border rounded p-2 mb-2 w-full"
                                placeholder="Enter Email...">

                            <span id="email-status" class="text-sm ms-2 flex">
                                @if ($user->email_verified_at)
                                    <div id="verified-label"
                                        class="text-white text-center bg-green-500 rounded p-1 ms-1 mb-2">
                                        Email Verified
                                    </div>
                                    {{-- @unless (Auth::user()->hasVerifiedEmail()) --}}
                                    <button type="button" id="resend-verification"
                                        class="bg-yellow-500 rounded p-1 ms-1 mb-2 hidden">Resend Verification
                                        Email</button>
                                    {{-- @endunless --}}

                                    <div id="verification-message"></div>
                                @else
                                    <button type="button" id="resend-verification"
                                        class="bg-yellow-500 rounded p-1 ms-1 mb-2 hidden">Send Verification Email</button>

                                    <div id="verification-message"></div>
                                @endif

                            </span>
                        </div>




                        <label for="role">Role</label>
                        <input type="text" name="role"
                            value="{{ optional($user->roles)->pluck('name')->join(', ') }}"
                            class="border rounded p-2 mb-2 w-full bg-gray-300 text-gray-500" placeholder="Role"
                            disabled>
                        <button type="submit" id="submitBtn" class="bg-blue-500 text-white rounded p-2">Update
                            Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Check if the user email is verified --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const originalEmail = emailInput.dataset.email;
            const verifiedLabel = document.getElementById('verified-label');
            const verifyBtn = document.getElementById('verify-email-btn');
            const resendBtn = document.getElementById('resend-verification');

            function updateVerificationDisplay() {
                if (emailInput.value.trim() !== originalEmail.trim()) {
                    // Email changed → hide verified label, show verify button
                    if (verifiedLabel) verifiedLabel.classList.add('hidden');
                    if (verifyBtn) verifyBtn.classList.remove('hidden');
                    if (resendBtn) resendBtn.classList.remove('hidden');
                } else {
                    // Email unchanged → show verified label, hide verify button
                    if (verifiedLabel) verifiedLabel.classList.remove('hidden');
                    if (verifyBtn && "{{ $user->email_verified_at }}") {
                        verifyBtn.classList.add('hidden');
                    }
                    if (resendBtn) resendBtn.classList.add('hidden');
                }
            }

            emailInput.addEventListener('input', updateVerificationDisplay);
        });
    </script>

    {{-- Resend Verification Email --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '#resend-verification', function() {
            // Get the email value from the input field
            var email = $('#email').val();

            // Disable the button to prevent multiple clicks while waiting for response
            $('#resend-verification').prop('disabled', true);
            $('#verification-message').text('Sending verification email...');

            // Send the email using AJAX
            $.ajax({
                url: '/email/verification-notification', // Adjust this URL to match your route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF Token for security
                    email: email // Send the email to the backend
                },
                success: function(res) {
                    // Show success message
                    $('#verification-message').text(res.message);
                },
                error: function(xhr) {
                    // Show error message
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        $('#verification-message').text(xhr.responseJSON.message);
                    } else {
                        $('#verification-message').text('Failed to send verification email.');
                    }
                },
                complete: function() {
                    // Re-enable the button after the response is received
                    setTimeout(function() {
                        $('#resend-verification').prop('disabled', false);
                    }, 30000); // Prevent clicking the button again for 30 seconds
                }
            });
        });
    </script>
</body>

</html>
