@php use App\Models\Game;use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pds.css') }}">
</head>

<body>
<main>
    <div>
        <a class="navbar-brand payPlay-logo" href="{{ url('/') }}">PayPlay</a>
        <div class="container my-5 d-flex justify-content-center flex-column flex-lg-row">
            <div class="tab-left col-12 col-lg-6">
                <div class="d-flex justify-content-center">
                    <nav class="bread-crumbs" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('cart') }}" class="text-decoration-none">Cart</a></li>
                            <li class="breadcrumb-item active fw-bold text-black" aria-current="page">Details</li>
                            <li class="breadcrumb-item text-secondary">Shipping</li>
                            <li class="breadcrumb-item text-secondary">Payment</li>
                        </ol>
                    </nav>
                </div>
                <form method="POST" action="{{ route('payment.shipping') }}">
                    @csrf
                <div>
                    <div class="mt-4">
                        <span class="ms-4 fs-6 fw-bold">Contact</span>
                        <div class="px-4">
                            <input class="p-2 mb-3 single-info form-control me-2" id="contact" name="contact" type="email" placeholder="Email" aria-label="Code" value="{{session()->get('contact')}}" required>
                            <div class="d-flex align-items-center">
                                <input class="p-2 mb-3 double-info form-control me-2" id="name" name="name" type="text" placeholder="Name" aria-label="Code" value="{{session()->get('name')}}" required>
                                <input class="p-2 mb-3 double-info form-control me-2" id="last_name" name="last_name" type="text" placeholder="Last Name" aria-label="Code" value="{{session()->get('last_name')}}" required>
                            </div>
                            <div class="d-flex align-items-center">
                                <input class="p-2 mb-3 form-control me-2" id="phone_number" name="phone_number" type="tel" placeholder="Phone Number" aria-label="Code" value="{{session()->get('phone_number')}}" required>
                            </div>
                            <div class="d-flex align-items-center">
                                <input class="p-2 mb-3 form-control me-2" id="shipping_note" name="shipping_note" type="search" placeholder="Shipping Note" aria-label="Code" value="{{session()->get('shipping_note')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mt-4">
                        <span class="ms-4 fs-6 fw-bold">Shipping Address</span>
                    </div>
                    <div class="px-4">
                        <div class="d-flex align-items-center">
                            <input class="p-2 mb-3 triple-info form-control me-2" id="city" name="city" type="text" placeholder="City" aria-label="Code" value="{{session()->get('city')}}" required>
                            <input class="p-2 mb-3 triple-info form-control me-2" id="postal_code" name="postal_code" type="number" placeholder="PostalCode" aria-label="Code" value="{{session()->get('postal_code')}}" required>
                            <input class="p-2 mb-3 triple-info form-control me-2" id="address" name="address" type="text" placeholder="Address" aria-label="Code" value="{{session()->get('address')}}" required>
                        </div>
                        <div class="d-flex align-items-center">
                            <input class="p-2 mb-3 form-control me-2" id="country" name="country" type="text" placeholder="Country" aria-label="Code" value="{{session()->get('country')}}" required>
                        </div>
                        <div class="d-flex justify-content-center mt-2 gap-4">
                            <a href="{{ route('cart') }}" class="btn btn-light btn-md text-black double-button">
                                Back to Cart
                            </a>
                            <button type="submit" class="btn btn-light btn-md text-black double-button">
                                Go to Shipping
                            </button>
                        </div>
                    </div>
                </div>
                </form>
            </div>

            <div class="tab-right col-12 col-lg-6">
                <div class="mb-3 d-flex" style="flex-wrap: nowrap; overflow: visible;">
                    @auth
                        @foreach(Auth::user()->cart->games as $item)
                            <div class="card">
                                <img src="{{ $item->logo }}" class="card-img-top" alt="...">
                            </div>
                        @endforeach
                    @else
                        @foreach(session()->get('cart', []) as $item)
                            <div class="card">
                                <img src="{{ Game::find($item['game_id'])->logo }}" class="card-img-top" alt="...">
                            </div>
                        @endforeach
                    @endauth
                </div>


                <div class="shelf px-4">
                    <div class="d-flex justify-content-between">
                        <span class="ms-4 fs-6 fw-bold">Subtotal</span>
                        <span class=" fs-6 fw-bold">{{$total}} €</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="ms-4 fs-6 fw-bold">Shipping</span>
                        <span class="ms-4 fs-6">Calculated at the Payment</span>
                    </div>
                </div>
                <div class="shelf d-flex justify-content-between">
                    <span class="ms-3 fs-4 fw-bold">Total</span>
                    <span class="fs-4 fw-bold">{{$total}} €</span>
                </div>
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
