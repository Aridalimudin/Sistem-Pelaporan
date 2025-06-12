<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin Sekolah</title>
    <link rel="Icon" type="png" href="{{asset('images/logoMts.png')}}"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .main-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            display: flex;
            max-width: 1100px;
            width: 100%;
            height: 90vh;
            max-height: 700px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        /* ILLUSTRATION SECTION (tidak ada perubahan signifikan yang mempengaruhi masalah mata) */
        .illustration-section {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .illustration-content {
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .bg-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .circle-1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -50px;
            right: -50px;
            animation: float 6s ease-in-out infinite;
        }

        .circle-2 {
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -30px;
            left: -30px;
            animation: float 8s ease-in-out infinite reverse;
        }

        .circle-3 {
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: 30%;
            left: 20%;
            animation: float 10s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.02); }
        }

        .admin-dashboard {
            width: 280px;
            height: 280px;
            margin: 0 auto;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .monitor {
            width: 180px;
            height: 120px;
            background: #2c3e50;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            animation: glow 4s ease-in-out infinite alternate;
        }

        .monitor::before {
            content: '';
            position: absolute;
            top: 8px;
            left: 8px;
            right: 8px;
            bottom: 20px;
            background: linear-gradient(135deg, #3498db, #2ecc71);
            border-radius: 8px;
            animation: screenGlow 3s ease-in-out infinite;
        }

        .monitor::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 15px;
            background: #34495e;
            border-radius: 0 0 8px 8px;
        }

        @keyframes glow {
            0% { box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3); }
            100% { box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4); }
        }

        @keyframes screenGlow {
            0%, 100% { background: linear-gradient(135deg, #3498db, #2ecc71); }
            50% { background: linear-gradient(135deg, #667eea, #764ba2); }
        }

        .admin-avatar {
            position: absolute;
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #ff6b6b, #feca57);
            border-radius: 50%;
            top: -22px;
            left: 20px;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: bounce 2s ease-in-out infinite;
        }

        .admin-avatar::before {
            content: '👨‍💼';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-8px); }
            60% { transform: translateY(-4px); }
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 5;
        }

        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            animation: floatElements 6s ease-in-out infinite;
        }

        .student-card {
            top: 15%;
            left: 8%;
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            animation-delay: 0s;
        }

        .student-card::before {
            content: '👥';
            font-size: 24px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .grade-card {
            top: 25%;
            right: 12%;
            width: 70px;
            height: 55px;
            background: linear-gradient(135deg, #fa709a, #fee140);
            animation-delay: -1s;
        }

        .grade-card::before {
            content: '📊';
            font-size: 20px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .schedule-card {
            bottom: 35%;
            left: 12%;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            animation-delay: -2s;
        }

        .schedule-card::before {
            content: '📅';
            font-size: 22px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .report-card {
            bottom: 20%;
            right: 8%;
            width: 75px;
            height: 50px;
            background: linear-gradient(135deg, #ffecd2, #fcb69f);
            animation-delay: -3s;
        }

        .report-card::before {
            content: '📈';
            font-size: 18px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .settings-card {
            top: 50%;
            right: 25%;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #c3cfe2, #c3cfe2);
            animation-delay: -4s;
        }

        .settings-card::before {
            content: '⚙️';
            font-size: 16px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .counseling-card {
            top: 40%;
            left: 25%;
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            animation-delay: -5s;
        }

        .counseling-card::before {
            content: '🧠';
            font-size: 18px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        @keyframes floatElements {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg) scale(1);
                opacity: 0.9;
            }
            25% { 
                transform: translateY(-15px) rotate(2deg) scale(1.05);
                opacity: 1;
            }
            50% { 
                transform: translateY(-10px) rotate(-1deg) scale(1.02);
                opacity: 0.95;
            }
            75% { 
                transform: translateY(-20px) rotate(1deg) scale(1.03);
                opacity: 1;
            }
        }

        .data-flow {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        .data-line {
            position: absolute;
            width: 2px;
            height: 60px;
            background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: dataFlow 4s linear infinite;
        }

        .data-line-1 {
            top: 20%;
            left: 30%;
            animation-delay: 0s;
        }

        .data-line-2 {
            top: 50%;
            right: 35%;
            animation-delay: -1s;
        }

        .data-line-3 {
            bottom: 30%;
            left: 60%;
            animation-delay: -2s;
        }

        @keyframes dataFlow {
            0% { 
                opacity: 0;
                transform: translateY(-20px);
            }
            50% { 
                opacity: 1;
                transform: translateY(0px);
            }
            100% { 
                opacity: 0;
                transform: translateY(20px);
            }
        }

        /* LOGIN SECTION */
        .login-section {
            flex: 0 0 420px;
            padding: 40px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        /* IMPROVED LOGO SECTION */
        .school-branding {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #f8fcff 0%, #e8f4fd 100%);
            border-radius: 16px;
            border: 1px solid rgba(74, 144, 226, 0.1);
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .logo-container img {
            width: 65px;
            height: 65px;
            margin-right: 15px;
            border-radius: 50%;
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.2);
            border: 3px solid white;
        }

        .school-name {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .school-title {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.1;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .school-subtitle {
            color: #4a90e2;
            font-size: 13px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 2px 0 0 0;
            opacity: 0.8;
        }

        .school-tagline {
            color: #7f8c8d;
            font-size: 12px;
            font-weight: 400;
            text-align: center;
            margin: 8px 0 0 0;
            font-style: italic;
            max-width: 280px;
            line-height: 1.3;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            color: #7f8c8d;
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 0;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
        }

        /* FORM STYLES */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-control.error {
            border-color: #e74c3c;
            background: #fdf2f2;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        }

        .password-field {
            position: relative;
            display: flex; /* ADDED */
            align-items: center; /* ADDED */
        }

        .password-field input.form-control { /* ADDED/MODIFIED */
            flex-grow: 1; 
            padding-right: 45px; /* Adjust if icon size changes */
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            /* Removed top: 50%; and transform: translateY(-50%); */
            background: none;
            border: none;
            color: #7f8c8d;
            cursor: pointer;
            font-size: 18px;
            height: 100%; /* Ensures it aligns with the input's height */
            display: flex; /* For centering the icon within its own space */
            align-items: center; /* For centering the icon within its own space */
            justify-content: center; /* For centering the icon within its own space */
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: none;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        /* ERROR HANDLING */
        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .error-message i {
            margin-right: 8px;
            font-size: 15px;
        }

        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
            padding: 15px 20px;
            border: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .alert .btn-close {
            background: none;
            border: none;
            color: white;
            opacity: 0.8;
            font-size: 18px;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .alert .btn-close:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        /* ERROR MODAL */
        .error-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .error-modal.show {
            display: flex;
        }

        .error-modal-content {
            background: white;
            border-radius: 15px;
            padding: 35px 30px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-icon {
            width: 75px;
            height: 75px;
            background: #fff5f5;
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #e74c3c;
        }

        .error-icon i {
            font-size: 32px;
            color: #e74c3c;
        }

        .error-message-modal {
            color: #666;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 30px;
            font-weight: 400;
        }

        .error-ok-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .error-ok-btn:hover {
            background: #5a6fd8;
            transform: translateY(-1px);
        }

        /* RESPONSIVE DESIGN (tidak ada perubahan signifikan yang mempengaruhi masalah mata) */
        @media (max-width: 992px) {
            .login-wrapper {
                max-width: 900px;
            }
            
            .login-section {
                flex: 0 0 380px;
                padding: 35px 40px;
            }
            
            .logo-container img {
                width: 60px;
                height: 60px;
            }
            
            .school-title {
                font-size: 22px;
            }
            
            .login-title {
                font-size: 26px;
            }
        }

        @media (max-width: 768px) {
            body {
                overflow: auto;
            }
            
            .main-container {
                height: auto;
                min-height: 100vh;
                padding: 15px;
            }
            
            .login-wrapper {
                flex-direction: column;
                height: auto;
                max-height: none;
                margin: 0;
            }
            
            .illustration-section {
                padding: 30px 20px;
                min-height: 250px;
            }
            
            .admin-dashboard {
                width: 200px;
                height: 200px;
            }
            
            .monitor {
                width: 140px;
                height: 90px;
            }
            
            .floating-element {
                padding: 8px;
            }
            
            .student-card {
                width: 45px;
                height: 45px;
            }
            
            .student-card::before {
                font-size: 16px;
            }
            
            .grade-card {
                width: 50px;
                height: 40px;
            }
            
            .grade-card::before {
                font-size: 14px;
            }
            
            .schedule-card {
                width: 45px;
                height: 45px;
            }
            
            .schedule-card::before {
                font-size: 16px;
            }
            
            .report-card {
                width: 55px;
                height: 35px;
            }
            
            .report-card::before {
                font-size: 12px;
            }
            
            .settings-card {
                width: 35px;
                height: 35px;
            }
            
            .settings-card::before {
                font-size: 12px;
            }
            
            .counseling-card {
                width: 40px;
                height: 40px;
            }
            
            .counseling-card::before {
                font-size: 14px;
            }
            
            .login-section {
                flex: none;
                padding: 30px 25px;
            }
            
            .school-branding {
                margin-bottom: 25px;
                padding: 18px;
            }
            
            .logo-container img {
                width: 50px;
                height: 50px;
                margin-right: 12px;
            }
            
            .school-title {
                font-size: 20px;
            }
            
            .school-subtitle {
                font-size: 12px;
            }
            
            .school-tagline {
                font-size: 11px;
                margin-top: 6px;
            }
            
            .login-title {
                font-size: 24px;
            }
            
            .login-subtitle {
                font-size: 14px;
            }
            
            .form-control {
                padding: 12px 16px;
                font-size: 14px;
            }
            
            .btn-login {
                padding: 13px;
                font-size: 15px;
            }
            
            .error-modal-content {
                padding: 30px 25px;
                max-width: 350px;
            }
            
            .error-icon {
                width: 65px;
                height: 65px;
                margin-bottom: 20px;
            }
            
            .error-icon i {
                font-size: 28px;
            }
            
            .error-message-modal {
                font-size: 15px;
                margin-bottom: 25px;
            }
            
            .error-ok-btn {
                padding: 10px 30px;
                font-size: 15px;
            }
        }

        @media (max-height: 750px) {
            .login-wrapper {
                height: 95vh;
                max-height: 650px;
            }
            
            .login-section {
                padding: 30px 40px;
            }
            
            .login-header {
                margin-bottom: 25px;
            }
            
            .school-branding {
                margin-bottom: 20px;
                padding: 15px;
            }
            
            .form-group {
                margin-bottom: 18px;
            }
        }

        @media (max-height: 650px) {
            .login-wrapper {
                height: 98vh;
                max-height: 600px;
            }
            
            .login-section {
                padding: 25px 35px;
            }
            
            .login-header {
                margin-bottom: 20px;
            }
            
            .school-branding {
                margin-bottom: 15px;
                padding: 12px;
            }
            
            .logo-container img {
                width: 55px;
                height: 55px;
            }
            
            .school-title {
                font-size: 20px;
            }
            
            .login-title {
                font-size: 26px;
                margin-bottom: 8px;
            }
            
            .form-group {
                margin-bottom: 15px;
            }
            
            .form-control {
                padding: 12px 16px;
            }
            
            .btn-login {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="login-wrapper">
            <div class="illustration-section">
                <div class="bg-pattern">
                    <div class="circle-1"></div>
                    <div class="circle-2"></div>
                    <div class="circle-3"></div>
                </div>

                <div class="data-flow">
                    <div class="data-line data-line-1"></div>
                    <div class="data-line data-line-2"></div>
                    <div class="data-line data-line-3"></div>
                </div>

                <div class="illustration-content">
                    <div class="admin-dashboard">
                        <div class="monitor">
                            <div class="admin-avatar"></div>
                        </div>
                    </div>
                </div>

                <div class="floating-elements">
                    <div class="floating-element student-card"></div>
                    <div class="floating-element grade-card"></div>
                    <div class="floating-element schedule-card"></div>
                    <div class="floating-element report-card"></div>
                    <div class="floating-element settings-card"></div>
                    <div class="floating-element counseling-card"></div>
                </div>
            </div>

            <div class="login-section">
                <div class="login-header">
                    <div class="school-branding">
                        <div class="logo-container">
                            <img src="{{asset('images/logoMts.png')}}" alt="MTS Logo">
                            <div class="school-name">
                                <h3 class="school-title">MTS AR-RIYADL</h3>
                                <span class="school-subtitle">Madrasah Tsanawiyah</span>
                            </div>
                        </div>
                        <p class="school-tagline">Membentuk Generasi Islami yang Berilmu dan Berakhlak Mulia</p>
                    </div>

                    <h1 class="login-title">Selamat Datang!</h1>
                    <p class="login-subtitle">Silahkan login ke akun Anda untuk mengakses sistem administrasi sekolah</p>
                </div>

                <form action="{{route('login.authenticate')}}" method="POST" id="loginForm">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" autocomplete="off" class="form-control" placeholder="Masukan username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-field">
                            <input type="password" name="password" id="password" autocomplete="off" class="form-control" placeholder="Masukan password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="far fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-login">Masuk</button>
                </form>
            </div>
        </div>
    </div>

    @if ($message = Session::get('error'))
    <div class="error-modal show" id="errorModal">
        <div class="error-modal-content">
            <div class="error-icon">
                <i class="fas fa-times"></i>
            </div>
            <div class="error-message-modal">
                Sepertinya ada masalah dengan informasi yang Anda masukkan. Silakan periksa kembali dan coba lagi.
            </div>
            <button class="error-ok-btn" onclick="closeErrorModal()">OK</button>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function closeErrorModal() {
            document.getElementById('errorModal').classList.remove('show');
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        $(document).ready(function() {
            // Configure Toastr options
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            // Check if there's an error and highlight the input fields
            @if (Session::get('error'))
            $('#username, #password').addClass('error');
            @endif

            $("#loginForm").validate({
                rules: {
                    username: {
                        required: true,
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    username: {
                        required: "Username wajib diisi.",
                    },
                    password: {
                        required: "Password wajib diisi.",
                    }
                },
                errorElement: 'div',
                errorClass: 'error-message',
                errorPlacement: function(error, element) {
                    error.html('<i class="fas fa-exclamation-circle"></i>' + error.text());
                    // Check if the element is the password input, and if it's inside a .password-field
                    if (element.attr("id") === "password" && element.parent().hasClass("password-field")) {
                        error.insertAfter(element.parent()); // Insert after the password-field div
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element) {
                    $(element).addClass('error');
                },
                unhighlight: function(element) {
                    $(element).removeClass('error');
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>