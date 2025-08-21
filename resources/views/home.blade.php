@extends('layouts.app') 

@section('content')
<div class="flex justify-center items-center h-screen">
    <div class="text-center">
        <!-- Sua imagem aqui - ajuste o caminho e o alt text -->
        <img src="{{ asset('images/logo.png') }}" class="mx-auto max-w-full h-auto">
        
       
    </div>
   <div id="Inicio" style="position: fixed; top: 0; left: 0; right: 0; height: 60px; 
     background: linear-gradient(135deg, 
         rgba(115, 118, 126, 0.05) 0%, 
         rgba(115, 118, 126, 0.2) 30%,
         rgba(115, 118, 126, 0.6) 70%, 
         rgba(115, 118, 126, 0.98) 100%), 
         radial-gradient(circle at 85% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
     display: flex; align-items: center; justify-content: flex-end; padding: 0 25px; 
     z-index: 999; color: white; font-weight: 700; 
     text-shadow: 0 0 10px rgba(255,255,255,0.3), 2px 2px 6px rgba(0,0,0,0.8);
     font-size: clamp(13px, 2.8vw, 18px); backdrop-filter: blur(12px) saturate(1.5); 
     border-bottom: 2px solid rgba(255,255,255,0.2);
     box-shadow: 
         0 8px 32px rgba(0,0,0,0.2), 
         0 0 0 1px rgba(255,255,255,0.1),
         inset 0 2px 0 rgba(255,255,255,0.15),
         inset 0 -1px 0 rgba(0,0,0,0.1);
     animation: slideInBounce 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55), 
                shimmer 4s ease-in-out infinite;
     overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; 
                background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.1) 50%, transparent 100%);
                animation: shine 3s ease-in-out infinite;"></div>
    ⚡ Bem vindo(a) ao Sistema ✨
</div>
</div>
@endsection