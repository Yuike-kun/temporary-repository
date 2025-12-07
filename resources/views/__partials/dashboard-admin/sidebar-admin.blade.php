{{-- Dashboard --}}
<x-nav-title title="Dashboard" />
<x-nav-item
    href="{{ route('admin.dashboard') }}"
    title="Dashboard"
    icon="layout-dashboard"
/>

{{-- Laporan --}}
<x-nav-title title="Laporan" />
<x-nav-item
    {{-- href="{{ route('laporan.darurat') }}" --}}
    title="Laporan Darurat"
    icon="alert-triangle"
/>

{{-- Bengkel --}}
<x-nav-title title="Bengkel" />
<x-nav-item
    href="{{ route('bengkel.list.index') }}"
    title="List Bengkel"
    icon="list"
/>
<x-nav-item
    href="{{ route('bengkel.map.index') }}"
    title="Map Lokasi"
    icon="map-pin"
/>
<x-nav-item
    href="{{ route('bengkel.list.create') }}"
    title="Tambah Bengkel"
    icon="wrench"
/>
<x-nav-item
    href="{{ route('bengkel.service.index') }}"
    title="Service Bengkel"
    icon="hammer"
/>
<x-nav-item
    href="{{ route('service.index') }}"
    title="List Service"
    icon="hammer"
/>

{{-- Akun --}}
<x-nav-title title="Akun" />
<x-nav-item
    href="{{ route('admin.akun') }}"
    title="Admin"
    icon="shield"
/>
<x-nav-item
    href="{{ route('admin-bengkel.index') }}"
    title="Admin Bengkel"
    icon="user-cog"
/>
<x-nav-item
    href="{{ route('pengguna.index') }}"
    title="Pengguna"
    icon="users"
/>

{{-- Settings --}}
<x-nav-title title="Settings" />
<x-nav-item
    {{-- href="{{ route('settings.index') }}" --}}
    title="Setting"
    icon="settings"
/>
