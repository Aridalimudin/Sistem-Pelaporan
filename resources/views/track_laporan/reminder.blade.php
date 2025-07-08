{{-- Reminder Popup --}}
<div id="reminderPopup" class="popup">
    <div class="reminder-popup-content shadow-lg rounded">
        <span class="close" onclick="trackReportModule.closeReminderPopup()">&times;</span>
        <div class="reminder-header">
            <div class="reminder-icon-container">
                <div class="reminder-icon-circle">
                    <i class="fas fa-bell"></i>
                </div>
            </div>
            <h5 class="fw-bold text-center">KIRIM PENGINGAT</h5>
            <p class="text-center text-muted">Kirim pemberitahuan untuk mempercepat proses laporan Anda</p>
        </div>

        <div class="reminder-body">
            <form id="reminderForm" action="{{ route('send-reminder') }}" method="POST"> {{-- Assuming a route for sending reminders --}}
                @csrf {{-- Add CSRF token for Laravel --}}
                <input type="hidden" name="report_code" value="{{$reporter ? $reporter->code : ''}}">

                <div class="mb-3">
                    <label for="reminderMessage" class="form-label fw-semibold">
                        <i class="fas fa-edit me-2"></i>Pesan Pengingat (Opsional)
                    </label>
                    <textarea class="form-control shadow-sm" id="reminderMessage" name="message" rows="4"
                                placeholder="Tuliskan alasan mengapa laporan ini perlu diprioritaskan... (Opsional)"></textarea>
                    <div class="form-text">
                        <small class="text-muted">Maksimal 500 karakter. Kosongkan jika tidak ada pesan khusus.</small>
                    </div>
                </div>

                <div class="reminder-info-box">
                    <div class="info-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="info-content">
                        <strong>Catatan:</strong>
                        <ul class="mb-0 mt-1">
                            <li>Pengingat hanya bisa dikirim 1 kali dalam 24 jam</li>
                            <li>Admin akan mendapat notifikasi tentang laporan Anda</li>
                            <li>Gunakan dengan bijak dan hanya untuk kasus mendesak</li>
                        </ul>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="button" class="btn btn-outline-secondary me-2" onclick="trackReportModule.closeReminderPopup()">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-bell me-2"></i>Kirim Pengingat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Success Reminder Popup --}}
<div id="reminderSuccessPopup" class="popup">
    <div class="success-popup-content">
        <div class="success-icon-container">
            <div class="success-circle">
                <i class="fas fa-check"></i>
            </div>
        </div>
        <h5 class="success-title">PENGINGAT TERKIRIM!</h5>
        <p class="success-message">Admin telah menerima pemberitahuan tentang laporan Anda. Terima kasih atas kesabaran Anda.</p>
        <button class="success-btn" onclick="trackReportModule.closeReminderSuccessPopup()">
            Mengerti
        </button>
    </div>
</div>