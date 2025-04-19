@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

<div class="container">
    <div class="header">
        <h1>Contact Us</h1>
        <div class="auth-links">
            <a href="{{ route('court-listing') }}">Home</a>
            <a href="{{ route('account') }}">Account</a>
            <a href="{{ route('logout') }}">Log Out</a>
        </div>
    </div>

    <div class="contact-us">
        <h2>Contact us if you need our assistance!</h2>
        <h3>Phone Number: Whatsapp 012-3358492</h3>
        <h3>Email: courtease@gmail.com</h3>
    </div>

    <div class="footer-buttons">
            <a href="{{ route('contact') }}" class="btn btn-contact">Contact Us</a>
    </div>
</div>
@endsection

<style>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .btn-contact {
        padding: 10px 20px;
        background: #2196F3;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>