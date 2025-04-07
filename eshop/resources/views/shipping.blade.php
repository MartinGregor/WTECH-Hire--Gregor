@php use App\Models\Game;use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shipping</title>
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
                            <li class="breadcrumb-item"><a href="{{ route('payment.details') }}" class="text-decoration-none">Details</a></li>
                            <li class="breadcrumb-item active fw-bold text-black" aria-current="page">Shipping</li>
                            <li class="breadcrumb-item text-secondary">Payment</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <div class="previous-info">
                        <div class="d-flex my-2">
                            <span class="ms-2 fs-6 fw-bold blue">Contact</span>
                            <span class="ms-5 fs-6">{{session()->get('contact')}}</span>
                        </div>
                        <div class="d-flex my-2">
                            <span class="ms-2 fs-6 fw-bold blue">Ship to&nbsp&nbsp</span>
                            <span class="ms-5 fs-6">{{session()->get('city')}}, {{session()->get('postal_code')}}, {{session()->get('address')}}, {{session()->get('country')}}</span>
                        </div>
                    </div>
                    <div>
                        <div class="mt-4">
                            <span class="ms-4 fs-6 fw-bold">Shipping Method</span>
                        </div>
                        <form method="POST" action="{{ route('payment.payment') }}">
                            @csrf
                        <div class="px-4">
                            <div class="form-check d-flex justify-content-between align-items-center radio-choice">
                                <div>
                                    <input class="ms-1 form-check-input" type="radio" name="shipping_type" id="standard_shipping" value="standard" checked>
                                    <label class="form-check-label ms-2" for="standard_shipping">Standard Shipping</label>
                                        Standard Shipping
                                    </label>
                                </div>
                                <span class="me-2 fs-6 fw-bold">FREE</span>
                            </div>

                            <div class="form-check d-flex justify-content-between align-items-center radio-choice">
                                <div>
                                    <input class="ms-1 form-check-input" type="radio" name="shipping_type" id="fragile_shipping" value="fragile">
                                    <label class="form-check-label ms-2" for="fragile_shipping">Fragile Shipping</label>
                                        Fragile Shipping
                                    </label>
                                </div>
                                <span class="me-2 fs-6 fw-bold">9.99 €</span>
                            </div>

                            <div class="form-check d-flex justify-content-between align-items-center radio-choice">
                                <div>
                                    <input class="ms-1 form-check-input" type="radio" name="shipping_type" id="express_shipping" value="express">
                                    <label class="form-check-label ms-2" for="express_shipping">Express Shipping</label>
                                        Express Shipping
                                    </label>
                                </div>
                                <span class="me-2 fs-6 fw-bold">19.99 €</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3 gap-4">
                            <a href="{{ route('payment.details') }}" class="btn btn-light btn-md text-black double-button">
                                Back to Details
                            </a>
                            <button type="submit" class="btn btn-light btn-md text-black double-button">
                                Go to Payment
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
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
