@php
    use App\Models\Game;
    use Illuminate\Support\Facades\Auth;
@endphp
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
                            <li class="breadcrumb-item"><a href="{{ route('payment.details') }}" class="text-decoration-none">Details</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('payment.shipping') }}" class="text-decoration-none">Shipping</a></li>
                            <li class="breadcrumb-item active fw-bold text-black" aria-current="page">Payment</li>
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
                        <div class="d-flex my-2">
                            <span class="ms-2 fs-6 fw-bold blue">Method</span>
                            <span class="ms-5 fs-6">{{session()->get('shipping_type')}}</span>
                        </div>
                    </div>

                    <form id="paymentForm" method="POST" action="{{ route('payment.complete') }}" class="needs-validation" novalidate>
                        @csrf
                        <div>
                            <div class="mt-4">
                                <span class="ms-4 fs-6 fw-bold">Payment Method</span>
                            </div>

                            <div class="px-4 my-4">
                                <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
                                    <li class="m-0 w-50 nav-item" role="presentation">
                                        <button class="m-0 w-50 nav-link active payment-tab-link w-100" id="card-tab" data-bs-toggle="tab" data-bs-target="#card" type="button" role="tab" aria-controls="card" aria-selected="true" value="card">Credit Card</button>
                                    </li>
                                    <li class="m-0 w-50 nav-item" role="presentation">
                                        <button class="m-0 w-50 nav-link payment-tab-link w-100" id="cash-tab" data-bs-toggle="tab" data-bs-target="#cash" type="button" role="tab" aria-controls="cash" aria-selected="false" value="cash">Cash</button>
                                    </li>
                                </ul>

                                <div class="tab-content mt-2" id="myTabContent">
                                    <div class="tab-pane fade show active" id="card" role="tabpanel" aria-labelledby="card-tab">
                                        <div class="d-flex align-items-center mb-2">
                                            <input class="form-info form-control me-2" type="tel" placeholder="Card Number" aria-label="Card Number" required data-validation="card">
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <input class="form-info form-control me-2" type="text" placeholder="Holder's Name" aria-label="Holder's Name" required data-validation="card">
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <input class="form-info form-control me-2 double-info" type="text" placeholder="Expiration (MM/YY)" aria-label="Expiration" required data-validation="card">
                                            <input class="form-info form-control me-2 double-info" type="tel" placeholder="CVV" aria-label="CVV" required data-validation="card">
                                        </div>
                                    </div>
                                    <div class="tab-pane fade p-4" id="cash" role="tabpanel" aria-labelledby="cash-tab">
                                        <span>You have selected to pay in cash. Please have the exact amount ready upon delivery or at the counter. Thank you!</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-3 gap-4">
                                <a href="{{'shipping'}}" class="btn btn-light btn-md text-black double-button">
                                    Back to Shipping
                                </a>
                                <button type="submit" class="btn btn-light btn-md text-black double-button">
                                    Pay Now
                                </button>
                            </div>
                        </div>
                    </form>
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
                        <span class="fs-6 fw-bold">{{$total}} €</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="ms-4 fs-6 fw-bold">Shipping</span>
                        <span class="ms-4 fs-6 fw-bold">{{session()->get('shipping_price')}} €</span>
                    </div>
                </div>
                <div class="shelf d-flex justify-content-between">
                    <span class="ms-3 fs-4 fw-bold">Total</span>
                    <span class="fs-4 fw-bold">{{$total + session()->get('shipping_price')}} €</span>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment Successful</h5>
            </div>
            <div class="modal-body">
                <p>Your payment has been successfully completed! Thank you for your purchase. You will receive a confirmation email shortly.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmPaymentButton">Return to Home Page</button>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation');
        const paymentForm = document.getElementById('paymentForm');
        const confirmPaymentButton = document.getElementById('confirmPaymentButton');
        const modalElement = document.getElementById('paymentModal');
        const modal = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });
        const cardTab = document.getElementById('card-tab');
        const cashTab = document.getElementById('cash-tab');
        const cardFields = paymentForm.querySelectorAll('[data-validation="card"]');
        function shouldValidateCardFields() {
            return cardTab.classList.contains('active');
        }
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (shouldValidateCardFields() && !form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else if (!shouldValidateCardFields()) {
                    event.preventDefault();
                    modal.show();
                } else {
                    event.preventDefault();
                    modal.show();
                }
                form.classList.add('was-validated');
            }, false);
        });
        confirmPaymentButton.addEventListener('click', function() {
            paymentForm.submit();
        });
    })()
</script>
