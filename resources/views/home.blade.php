@extends('layouts.app')

@section('title', 'Inicio | Cotizador Ortomolecular')

@section('content')
  <section class="home-hero">
    <div><span class="hero-kicker"><i class="bi bi-stars"></i> Panel de trabajo</span><h1>Hola, {{ Auth::user()->nombre }}.</h1><p>Bienvenido a Cotizador Ortomolecular. Gestiona fórmulas, recetas y pedidos desde un solo lugar.</p></div>
    <div class="hero-emblem"><i class="bi bi-capsule-pill"></i></div>
  </section>
  <style>
    .home-hero{min-height:290px;padding:clamp(2rem,5vw,4rem);border-radius:28px;display:flex;align-items:center;justify-content:space-between;gap:2rem;color:#fff;background:radial-gradient(circle at 85% 20%,rgba(201,168,76,.28),transparent 35%),linear-gradient(135deg,#252217,#413923);box-shadow:0 24px 60px rgba(55,44,15,.18);overflow:hidden}.home-hero h1{font-size:clamp(2.2rem,5vw,4.2rem);margin:.8rem 0 1rem}.home-hero p{max-width:650px;color:rgba(255,255,255,.72);font-size:1.12rem;margin:0}.hero-kicker{display:inline-flex;gap:.5rem;align-items:center;color:#C9A84C;text-transform:uppercase;letter-spacing:.13em;font-size:.75rem;font-weight:800}.hero-emblem{width:150px;height:150px;flex:0 0 150px;border-radius:38px;display:grid;place-items:center;background:#C9A84C;color:#252217;font-size:4.2rem;transform:rotate(6deg);box-shadow:0 20px 50px rgba(0,0,0,.24)}@media(max-width:767px){.hero-emblem{display:none}.home-hero{min-height:250px}}
  </style>
@endsection
