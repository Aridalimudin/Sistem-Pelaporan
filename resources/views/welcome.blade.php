@extends('layouts.main')
@section('title', 'Website Laporan - MTS AR-RIYADL')
@section('content')

<div class="welcome-container">
    <div class="welcome-content">
        <div class="text-section">
            <h1 class="main-title">
                <span class="stop-text">STOP</span> 
                <span class="bullying-text">Bullying</span>
            </h1>
            <h2 class="subtitle">
                <span class="lawan-text">LAWAN</span> 
                <span class="pelecehan-text">Pelecehan</span>
            </h2>
            
            <p class="description">
                Setiap siswa berhak merasa aman dan nyaman di lingkungan 
                sekolah. Berani bersuara adalah langkah pertama untuk menciptakan 
                lingkungan yang bebas dari bullying dan pelecehan.
            </p>
            
            <div class="highlight-box">
                <p class="highlight-text">
                    Mari bersama ciptakan madrasah yang aman
                </p>
                <div class="hashtags">
                    <span class="hashtag">#BicarakanKeberanian</span>
                    <span class="hashtag">#MadrasahAman</span>
                </div>
            </div>
            
            <div class="contact-section">
                <p class="contact-title">Butuh bantuan? Hubungi kami:</p>
                <div class="contact-links">
                    <a href="https://wa.me/6281234567890" target="_blank" class="contact-link whatsapp">
                        <img src="{{asset('images/whatsapp.png')}}" alt="WhatsApp">
                        <span>WhatsApp</span>
                    </a>
                    <a href="mailto:admin@mtsarriyadl.com" class="contact-link email">
                        <img src="{{asset('images/email.png')}}" alt="Email">
                        <span>Email</span>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="contact-link instagram">
                        <img src="{{asset('images/instagram.png')}}" alt="Instagram">
                        <span>Instagram</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="logo-section">
            <div class="logo-wrapper">
                <img src="{{asset('images/logoMts.png')}}" class="main-logo" alt="Logo MTS AR-RIYADL">
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{asset('css/style.css')}}">
@endsection
