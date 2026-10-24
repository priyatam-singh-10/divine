@extends('layouts.default')
@push('title', get_phrase('Coming Soon'))
@push('meta')@endpush
@push('css')
<style>
    .coming-soon-wrapper {
        padding:4rem 0;
        background: var(--cream);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .coming-soon-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse-bg 4s ease-in-out infinite;
    }
    
    @keyframes pulse-bg {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 0.6; }
    }
    
    .coming-soon-content {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 80px 60px;
        text-align: center;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.2);
        max-width: 600px;
        position: relative;
        z-index: 2;
    }
    
    .icon-container {
        width: 100px;
        height: 100px;
        background: var(--teal);
        border-radius: 50%;
        margin: 0 auto 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .coming-soon-title {
        font-size: 3rem;
        font-weight: 800;
        color: var(--teal);
        margin-bottom: 20px;
        line-height: 1.2;
    }
    
    .coming-soon-subtitle {
        font-size: 1.2rem;
        color: #6b7280;
        margin-bottom: 50px;
        line-height: 1.6;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .coming-soon-content {
            padding: 60px 40px;
            margin: 20px;
        }
        
        .coming-soon-title {
            font-size: 2.2rem;
        }
        
        .coming-soon-subtitle {
            font-size: 1.1rem;
        }
        
        .icon-container {
            width: 80px;
            height: 80px;
            margin-bottom: 30px;
        }
    }
</style>
@endpush

@section('content')
<div class="coming-soon-wrapper">
    <div class="coming-soon-content">
        <!-- Icon -->
        <div class="icon-container">
            <svg width="50" height="50" fill="white" viewBox="0 0 24 24">
                <path d="M12 2L13.09 8.26L22 9L13.09 9.74L12 16L10.91 9.74L2 9L10.91 8.26L12 2Z"/>
            </svg>
        </div>
        
        <!-- Main Content -->
        <h1 class="coming-soon-title">{{ get_phrase('We are launching soon!') }}</h1>
        <p class="coming-soon-subtitle">{{ get_phrase('Stay tuned for something amazing!') }}</p>
        
        <!-- Back to Home Button -->
        <a href="{{ route('home') }}" class="btn eBtn btn-style1">
            {{ get_phrase('Back to Home') }}
        </a>
    </div>
</div>
@endsection

@push('js')@endpush