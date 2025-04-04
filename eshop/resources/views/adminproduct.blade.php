<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>

    <nav class="navbar sticky-top navbar-expand-md bg-body-tertiary shadow-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PayPlay</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('admin') }}">Admin</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('game.store.default') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link active" aria-current="page" style="background: none; border: none;">
                                Add+
                            </button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="register.html">Account</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<main>
    <div class="container mt-5 px-lg-5 admin-product-box">
        <div class="row">
            <div class="col-lg-7">
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <!-- Logo indicator -->
                        @if ($game->logo)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Logo"></button>
                        @endif

                        <!-- Image indicators -->
                        @foreach ($game->images as $index => $image)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index + 1 }}" class="" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach

                        <!-- Video indicators -->
                        @foreach ($game->videos as $index => $video)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index + 1 + count($game->images) }}" class="" aria-label="Video {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner">
                        <!-- Logo -->
                        @if ($game->logo)
                            <div class="carousel-item active position-relative">
                                <form action="{{ route('game.logo.update', $game->id) }}" method="POST" enctype="multipart/form-data" class="position-absolute top-0 start-50 translate-middle-x mt-2 btn-on-top">
                                    @csrf
                                    @method('POST')
                                    <label class="btn btn-dark text-white mb-0">
                                        <i class="bi bi-arrow-clockwise"></i>
                                        <input type="file" name="logo" accept="image/*" onchange="this.form.submit()" hidden>
                                    </label>
                                </form>
                                <div class="aspect-ratio-box">
                                    <img src="{{ asset($game->logo) }}" class="logo-img" alt="Game Logo">
                                </div>
                            </div>
                        @endif

                        <!-- Images -->
                        @foreach ($game->images as $index => $image)
                            <div class="carousel-item position-relative">
                                <form action="{{ route('game.image.delete', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-dark text-white position-absolute top-0 start-50 translate-middle-x mt-2 btn-on-top">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <img src="{{ asset($image->image_url) }}" class="d-block w-100 rounded-3" alt="Image {{ $index + 1 }}">
                            </div>
                        @endforeach

                        <!-- Videos -->
                        @foreach ($game->videos as $index => $video)
                            <div class="carousel-item position-relative">
                                <form action="{{ route('game.video.delete', $video->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this video?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-dark text-white position-absolute top-0 start-50 translate-middle-x mt-2 btn-on-top">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <div class="ratio ratio-16x9">
                                    <iframe class="rounded-3" src="{{ $video->video_url }}" title="Video {{ $index + 1 }}" allowfullscreen></iframe>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <!-- Upload YouTube Video Link -->
                <form action="{{ route('game.video.upload', ['id' => $game->id]) }}" method="POST" class="mb-3 mt-4">
                    @csrf
                    <div class="input-group">
                        <span class="input-group-text bg-dark text-light">YouTube video link</span>
                        <input type="text" name="video_link" class="form-control" placeholder="youtube video link..." required>
                        <button class="btn btn-outline-light" type="submit">Upload Video Link</button>
                    </div>
                </form>

                <!-- Upload Picture -->
                <form action="{{ route('game.image.upload', ['id' => $game->id]) }}" method="POST" enctype="multipart/form-data" class="pb-3">
                    @csrf
                    <div class="input-group d-flex flex-row align-items-center gap-0">
                        <input type="file" name="image" class="form-control no-display" id="uploadPicture" required style="display: none; border-radius: 0;">
                        <button class="btn btn-outline-light" type="button" onclick="document.getElementById('uploadPicture').click()">Upload Picture +</button>
                    </div>
                </form>
            </div>

            <div class="col-lg-5 d-flex flex-column justify-content-center">
                <form action="{{ route('game.update', ['id' => $game->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Game Name -->
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-dark text-light">Game Name</span>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $game->title) }}" aria-label="Game Name">
                    </div>

                    <!-- Game Publisher -->
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-dark text-light">Game Publisher</span>
                        <input type="text" name="publisher" class="form-control" value="{{ old('publisher', $game->publisher) }}" aria-label="Game Publisher">
                    </div>

                    <div class="row">
                        <!-- Game Price -->
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-dark text-light">Price</span>
                                <input type="text" name="price" class="form-control" value="{{ old('price', $game->price) }}" aria-label="Price">
                                <span class="input-group-text bg-dark text-light">€</span>
                            </div>
                        </div>

                        <!-- Platform Selection -->
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <label class="input-group-text bg-dark text-light" for="platform">Platform</label>
                                <select class="form-select" id="platform" name="platform">
                                    @php
                                        $platforms = ['PC', 'Play Station', 'Nintendo', 'Wii', 'Xbox'];
                                    @endphp
                                    @foreach ($platforms as $platform)
                                        <option value="{{ $platform }}" {{ old('platform', $game->platform) === $platform ? 'selected' : '' }}>
                                            {{ $platform }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    @php
                        $genres = \App\Models\Genre::all();
                    @endphp

                    <div class="row">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <label class="input-group-text bg-dark text-light" for="genre{{ $i }}">Genre</label>
                                    <select class="form-select" id="genre{{ $i }}" name="genres[]">
                                        <option value="">-</option>
                                        @foreach ($genres as $genre)
                                            <option value="{{ $genre->id }}" {{ old('genres.' . $i, optional($game->genres[$i] ?? null)->id) == $genre->id ? 'selected' : '' }}>
                                                {{ $genre->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <!-- Game Description -->
                    <textarea class="form-control mb-3" name="description" placeholder="Game Description">{{ old('description', $game->description) }}</textarea>

                    <!-- Buttons Row (Save Changes & Delete) -->
                    <div class="d-flex justify-content-between gap-3 mt-4">
                        <!-- Save Changes Button -->
                        <button type="submit" class="btn btn-light btn-md text-black px-4 py-2 rounded-pill">
                            Save Changes
                        </button>
                    </div>
                </form>
                <form action="{{ route('game.delete', $game->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this game?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-dark btn-md text-white px-4 py-2 rounded-pill">
                        Delete Game
                    </button>
                </form>

            </div>

        </div>
    </div>
</main>


<footer class="py-0 my-4 mb-0">
    <div class="bg-dark">
        <div class="container">
            <footer class="py-4 bg-dark">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-light">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-light">Features</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-light">Pricing</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-light">FAQs</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-light">About</a></li>
                </ul>
                <p class="text-center text-light">© 2025 PayPlay</p>
            </footer>
        </div>
    </div>
</footer>


</body>
</html>

<script>
    document.getElementById('uploadPicture').addEventListener('change', function () {
        if (this.files.length > 0) {
            this.form.submit();
        }
    });
</script>
