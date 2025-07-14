@extends('layouts.main_ds')

@section('content')

@section('content')
<div class="main-content">
    @if(false) {{-- Set ke true untuk melihat pesan sukses dummy --}}
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
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
            'avatar' => null,
            'status' => 'active',
            'created_at' => Carbon::now()->subMonths(6),
            'last_login_at' => Carbon::now()->subHours(2),
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
        <!-- Header Profile -->
        <div class="profile-header">
            <div class="profile-avatar">
                @if($user->avatar)
                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar">
                @else
                    <div class="avatar-placeholder">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                @endif
            </div>
            <div class="profile-info">
                <h2 class="profile-name">{{ $user->name }}</h2>
                <p class="profile-role">{{ $user->roles->first()->name ?? 'User' }}</p>
                <span class="status-badge {{ $user->status }}">
                    <i class="fas fa-circle"></i>
                    {{ ucfirst($user->status) }}
                </span>
            </div>
        </div>

        <!-- Informasi Dasar -->
        <div class="profile-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Informasi Dasar
                </h3>
                <a href="#" class="btn-edit">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-user-circle"></i>
                        Nama Lengkap
                    </div>
                    <div class="info-value">{{ $user->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-at"></i>
                        Username
                    </div>
                    <div class="info-value">{{ $user->username ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-envelope"></i>
                        Email
                    </div>
                    <div class="info-value">{{ $user->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-phone"></i>
                        Nomor HP
                    </div>
                    <div class="info-value">{{ $user->phone ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        @if($user->roles->first() && $user->roles->first()->permissions->count() > 0)
        <div class="profile-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-key"></i>
                    Permissions
                </h3>
            </div>
            <div class="permissions-list">
                @foreach($user->roles->first()->permissions as $permission)
                    <span class="permission-tag">
                        <i class="fas fa-check"></i>
                        {{ $permission->name }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Activity Info -->
        <div class="profile-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-clock"></i>
                    Aktivitas
                </h3>
            </div>
            <div class="activity-grid">
                <div class="activity-item">
                    <div class="activity-label">Bergabung Sejak</div>
                    <div class="activity-value">{{ $user->created_at->format('d F Y') }}</div>
                </div>
                <div class="activity-item">
                    <div class="activity-label">Login Terakhir</div>
                    <div class="activity-value">{{ $user->last_login_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-section">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Profile
            </a>
            <a href="#" class="btn btn-warning">
                <i class="fas fa-lock"></i>
                Ganti Password
            </a>
        </div>
    </div>
</div>

<style>
/* Global Styles */
.main-content {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

/* Alert Styles */
.alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 20px;
    margin-bottom: 20px;
    border-radius: 10px;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    border: 1px solid #28a745;
    color: #155724;
}

/* Profile Container */
.profile-container {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

/* Profile Header */
.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 40px 30px;
    text-align: center;
    position: relative;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    margin: 0 auto 20px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    font-weight: 700;
}

.profile-name {
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 8px 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.profile-role {
    font-size: 16px;
    margin: 0 0 15px 0;
    opacity: 0.9;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.active {
    background: rgba(40, 167, 69, 0.2);
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.status-badge.inactive {
    background: rgba(220, 53, 69, 0.2);
    color: #dc3545;
    border: 1px solid rgba(220, 53, 69, 0.3);
}

/* Profile Sections */
.profile-section {
    padding: 30px;
    border-bottom: 1px solid #eee;
}

.profile-section:last-child {
    border-bottom: none;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.btn-edit {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: #f8f9fa;
    color: #667eea;
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    border: 1px solid #e9ecef;
}

.btn-edit:hover {
    background: #667eea;
    color: white;
    transform: translateY(-1px);
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.info-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #e9ecef;
    transition: transform 0.2s ease;
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.info-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 8px;
    font-weight: 500;
}

.info-value {
    font-size: 16px;
    color: #333;
    font-weight: 600;
    word-break: break-word;
}

/* Permissions */
.permissions-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.permission-tag {
    display: flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    color: #1976d2;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    border: 1px solid #90caf9;
    transition: transform 0.2s ease;
}

.permission-tag:hover {
    transform: translateY(-1px);
}

/* Activity Grid */
.activity-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.activity-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    border: 1px solid #e9ecef;
}

.activity-label {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 8px;
    font-weight: 500;
}

.activity-value {
    font-size: 16px;
    color: #333;
    font-weight: 600;
}

/* Action Section */
.action-section {
    padding: 30px;
    background: #f8f9fa;
    display: flex;
    gap: 15px;
    justify-content: center;
}

.btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107, #ff8f00);
    color: #212529;
}

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(255, 193, 7, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .main-content {
        padding: 15px;
    }
    
    .profile-header {
        padding: 30px 20px;
    }
    
    .profile-section {
        padding: 20px;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .action-section {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 100%;
        max-width: 250px;
        justify-content: center;
    }
}
</style>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/ds_admin.css') }}">
@endpush
@endsection