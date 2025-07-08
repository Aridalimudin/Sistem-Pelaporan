@extends('layouts.main_ds')
@section('title', 'Profile Pengguna')

@section('content')
<div class="main-content">
    @if(false) {{-- Set ke true untuk melihat pesan sukses dummy --}}
        <div class="alert alert-success">
            Profil berhasil diperbarui!
        </div>
    @endif

    {{-- Data dummy untuk profile --}}
    @php
        use Carbon\Carbon;
        $user = (object) [
            'id' => 1,
            'name' => 'John Doe',
            'username' => 'johndoe_id',
            'email' => 'john.doe@example.com',
            'phone' => '0812-3456-7890',
            'avatar' => null, // Atur ke 'avatar.jpg' jika Anda punya dummy image di public/storage/avatars/
            'status' => 'active', // atau 'inactive'
            'created_at' => Carbon::now()->subMonths(6),
            'last_login_at' => Carbon::now()->subHours(2),
            'last_login_ip' => '192.168.1.100',
            'last_user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
            'roles' => collect([(object)[
                'name' => 'Administrator',
                'permissions' => collect([
                    (object)['name' => 'view dashboard'],
                    (object)['name' => 'manage users'],
                    (object)['name' => 'edit profiles'],
                    (object)['name' => 'create reports'],
                    (object)['name' => 'delete data'],
                ]),
            ]]),
        ];
    @endphp

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                @if($user->avatar)
                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                @else
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                @endif
            </div>
            <h2 class="profile-name">{{ $user->name }}</h2>
            <span class="profile-role">
                {{ $user->roles->first()->name ?? 'User' }}
            </span>
        </div>

        <div class="profile-body">
            <div class="profile-section">
                <h3 class="section-title">
                    ℹ️ Informasi Dasar
                    <a href="#" class="edit-btn" style="margin-left: auto; text-decoration: none;">
                        ✏️ Edit Profile
                    </a>
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Username</div>
                        <div class="info-value">{{ $user->username ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Nomor HP</div>
                        <div class="info-value">{{ $user->phone ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Role</div>
                        <div class="info-value">{{ $user->roles->first()->name ?? '-' }}</div>
                    </div>
                </div>
            </div>

            @if($user->roles->first() && $user->roles->first()->permissions->count() > 0)
            <div class="profile-section">
                <h3 class="section-title">🔑 Permissions</h3>
                <div class="permissions-list">
                    @foreach($user->roles->first()->permissions as $permission)
                        <span class="permission-tag">{{ $permission->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="profile-section">
                <div class="action-buttons">
                    <a href="#" class="btn btn-warning">
                        🔒 Ganti Password
                    </a>
                    <a href="#" class="btn btn-primary">
                        ✏️ Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS Anda yang sudah ada */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: 500;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 500;
}

.status-badge.active {
    background-color: #d1ecf1;
    color: #0c5460;
}

.status-badge.inactive {
    background-color: #f8d7da;
    color: #721c24;
}

.action-buttons {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-primary:hover {
    background: #5a6fd8;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-warning {
    background: #ffc107;
    color: #212529;
}

.btn-warning:hover {
    background: #e0a800;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
}

/* CSS tambahan untuk tampilan profil yang lebih baik (jika belum ada di layout utama Anda) */
body {
    font-family: 'Inter', sans-serif; /* Pastikan font Inter atau font lain tersedia */
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
}

.main-content {
    width: 100%;
    max-width: 900px;
    padding: 20px;
    box-sizing: border-box;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    background-color: #fff;
    padding: 20px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    color: #555;
    font-weight: 500;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #667eea;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: 600;
    font-size: 18px;
}

.profile-container {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    padding: 30px;
}

.profile-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background-color: #667eea;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 48px;
    font-weight: 700;
    margin: 0 auto 15px auto;
    border: 4px solid #fff;
    box-shadow: 0 0 0 4px #667eea;
    overflow: hidden;
}

.profile-name {
    font-size: 28px;
    font-weight: 700;
    color: #333;
    margin-bottom: 5px;
}

.profile-role {
    font-size: 16px;
    color: #777;
    font-weight: 500;
}

.profile-section {
    margin-bottom: 30px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    border: 1px solid #eee;
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    color: #444;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.info-item {
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #e9e9e9;
}

.info-label {
    font-size: 14px;
    color: #777;
    margin-bottom: 5px;
    font-weight: 500;
}

.info-value {
    font-size: 16px;
    color: #333;
    font-weight: 600;
    word-wrap: break-word; /* Untuk mencegah overflow teks panjang */
}

.permissions-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.permission-tag {
    background-color: #e6e9f0;
    color: #667eea;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    border: 1px solid #d1d9e2;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    text-align: center;
}

.stat-card {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid #eee;
}

.stat-number {
    font-size: 32px;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 15px;
    color: #555;
    font-weight: 500;
}

/* Edit button inside section title */
.edit-btn {
    font-size: 14px;
    font-weight: 500;
    color: #667eea;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: color 0.2s ease;
}

.edit-btn:hover {
    color: #5a6fd8;
}

/* Responsiveness */
@media (max-width: 768px) {
    .top-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .page-title {
        font-size: 24px;
    }

    .info-grid, .stats-grid {
        grid-template-columns: 1fr;
    }
}

</style>
@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
@endpush
@endsection