<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - PayPlay</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/reglog.css') }}">
</head>
<body>
<a class="logo" href="{{ url('/') }}">PayPlay</a>

<a href="{{ route('register') }}" class="button-sign">Sign Up</a>

<div class="container">
    <h2>Sign In to PayPlay</h2>
    <p>"Unlock New Worlds – The Best Games, All in One Place!"</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

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

        <button type="submit">Sign In</button>
    </form>
</div>
</body>
</html>
