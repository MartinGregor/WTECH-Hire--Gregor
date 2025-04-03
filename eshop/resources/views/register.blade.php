<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - PayPlay</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/reglog.css') }}">
</head>
<body>
<a class="logo" href="{{ url('/') }}">PayPlay</a>

<a href="{{ route('login') }}" class="button-sign">Sign In</a>

<div class="container">
    <h2>Sign up to PayPlay</h2>
    <p>"Unlock New Worlds – The Best Games, All in One Place!"</p>

    <form action="{{ url('/register') }}" method="POST">
        @csrf

        <div class="input-container">
            <label for="username">User Name</label>
            <input type="text" id="username" name="username" placeholder="User Name" value="{{ old('username') }}" required>
            @error('username')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-container">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
            @error('email')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-container">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            @error('password')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-container">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="terms"> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
            </label>
        </div>

        <button type="submit">Sign Up</button>
    </form>
</div>
</body>
</html>
