<div class="d-flex justify-content-between align-items-center border-bottom pb-3">
    <h1 class="fs-4 fw-bold text-primary">MTS AR-RIYADL</h1>
    <nav class="d-flex gap-3">
        <a href="{{ route('home') }}" class="nav-link {{ (request()->is('/')) ? 'active' : '' }}">Home</a>
        <a href="{{ route('lapor.index') }}" class="nav-link {{ (request()->is('lapor')) ? 'active' : '' }}">Lapor</a>
        <a href="{{ route('track') }}" class="nav-link {{ (request()->is('track')) ? 'active' : '' }}">Track Laporan</a>
        {{-- <a href="{{ route('login'), }}" class="nav-link {{ (request()->is('login')) ? 'active' : 'collapsed' }}">Login Admin/BK</a> --}}
    </nav>
</div>