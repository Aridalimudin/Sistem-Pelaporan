<div class="modal-overlay" id="completeDocumentsModal">
    <div class="modal">
        <button class="close-btn" onclick="closeCompleteDocumentsForm()">&times;</button>
        <input type="hidden" id="data-siswa" value='{{$students}}'>
        <input type="hidden" id="reporter_id" value="{{ $reporter->id ?? '' }}">
        <div class="modal-header">
            <div class="header-icon">📋</div>
            <h2 class="modal-title">Lengkapi Laporan Kejadian</h2>
        </div>

        <div class="progress-stepper">
            <div class="progress-line">
                <div class="progress-line-fill" id="progressFill"></div>
            </div>

            <div class="step active" id="step1">
                <div class="step-indicator">1</div>
                <div class="step-label">Waktu Kejadian</div>
            </div>

            <div class="step" id="step2">
                <div class="step-indicator">2</div>
                <div class="step-label">Pihak Terlibat</div>
            </div>

            <div class="step" id="step3">
                <div class="step-indicator">3</div>
                <div class="step-label">Tindakan</div>
            </div>
        </div>

        <div class="step-content active">
            <div class="step-content-title" id="contentTitle">Waktu Kejadian</div>
            <div id="contentForm">
                </div>
        </div>

        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="previousStep()" id="prevBtn">Kembali</button>
            <button class="btn btn-primary" onclick="nextStep()" id="nextBtn">Lanjutkan</button>
        </div>
    </div>
</div>

<style>
    /* Variabel CSS Dasar */
    :root {
        --primary-color: #4361EE;
        --secondary-color: #f3f4f6;
        --success-color: #22c55e;
        --text-dark: #1f2937;
        --text-gray: #6b7280;
        --border-light: #e5e7eb;
        --bg-light: #f9fafb;
        --bg-active: #eff6ff;
        --bg-checkbox-success: #f0fdf4;
        --border-checkbox-success: #bbf7d0;
        --error-color: #ef4444; /* Warna merah untuk error */
        --border-error: #f87171; /* Warna border merah untuk error */
    }

    /* Modal Overlay */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
        opacity: 1;
        transition: opacity 0.3s ease;
        z-index: 1000;
    }

    /* Animasi Modal */
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes modalSlideOut {
        from {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        to {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
    }

    .modal {
        background: white;
        border-radius: 20px;
        padding: 0 40px 40px 40px;
        width: 100%;
        max-width: 700px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 35px;
    }

    /* Close Button - Diperbaiki positioning */
    .close-btn {
        position: absolute;
        top: 20px;
        right: 25px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        font-size: 20px;
        color: white;
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        transition: all 0.2s ease;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
        z-index: 10;
    }

    .close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    /* Modal Header - Diperbaiki alignment dan padding */
    .modal-header {
        text-align: left;
        padding: 30px 40px 25px 40px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        border-radius: 20px 20px 0 0;
        margin: 0 -40px 0 -40px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        color: white;
    }

    .header-icon {
        font-size: 24px;
        background: rgba(255, 255, 255, 0.2);
        padding: 8px;
        border-radius: 8px;
        backdrop-filter: blur(10px);
    }

    .modal-title {
        font-size: 24px;
        font-weight: 700;
        color: white;
        margin: 0;
        letter-spacing: -0.5px;
        line-height: 1.2;
        text-align: center;
    }

    .modal-subtitle {
        display: none;
    }

    /* Progress Stepper */
    .progress-stepper {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin: 0 20px;
        position: relative;
        padding: 20px 0;
    }

    .progress-line {
        position: absolute;
        top: 45px;
        left: 50px;
        right: 50px;
        height: 4px;
        background: var(--border-light);
        z-index: 1;
        border-radius: 2px;
    }

    .progress-line-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-color), var(--success-color));
        transition: width 0.5s ease;
        width: 0%;
        border-radius: 2px;
    }

    .step {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        min-width: 100px;
        max-width: 140px;
    }

    .step-indicator {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        background: white;
        border: 3px solid var(--border-light);
        color: var(--text-gray);
    }

    /* State untuk Step */
    .step.pending .step-indicator {
        background: white;
        color: var(--text-gray);
        border-color: var(--border-light);
    }

    .step.active .step-indicator {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.2);
        transform: scale(1.05);
    }

    .step.completed .step-indicator {
        background: var(--success-color);
        color: white;
        border-color: var(--success-color);
    }

    .step-label {
        text-align: center;
        font-size: 14px;
        font-weight: 500;
        color: var(--text-gray);
        transition: color 0.3s ease;
        line-height: 1.3;
        padding: 0 5px;
        word-wrap: break-word;
    }

    .step.active .step-label {
        color: var(--primary-color);
        font-weight: 600;
    }

    .step.completed .step-label {
        color: var(--success-color);
        font-weight: 600;
    }

    /* Icon centang untuk langkah yang selesai */
    .step.completed .step-indicator::before {
        content: "✓";
        font-size: 20px;
        font-weight: bold;
        line-height: 1;
    }

    .step.completed .step-indicator {
        font-size: 0;
    }

    /* Step Content Area */
    .step-content {
        background: var(--bg-light);
        border-radius: 16px;
        padding: 30px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        display: none;
        flex-direction: column;
        gap: 20px;
    }

    .step-content.active {
        background: var(--bg-active);
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.15);
        display: flex;
    }

    .step-content-title {
        font-size: 22px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 20px;
        text-align: center;
    }

    /* Form Elements - Diperbaiki spacing dan layout */
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        flex: 1;
        margin-bottom: 0;
        position: relative; /* Tambahkan ini untuk positioning pesan error */
    }

    /* Khusus untuk lokasi kejadian - diperbaiki spacing */
    .location-group {
        margin-top: 10px;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border-light);
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        font-family: inherit;
        color: var(--text-dark);
        box-sizing: border-box;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #9ca3af;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    .form-group input[type="file"] {
        padding: 8px;
        background: white;
    }

    .file-info {
        color: var(--text-gray);
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }

    /* Checkbox Group */
    .checkbox-group {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-top: 24px;
        padding: 20px;
        background: var(--bg-checkbox-success);
        border-radius: 8px;
        border: 1px solid var(--border-checkbox-success);
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin: 0;
        flex-shrink: 0;
        margin-top: 2px;
        accent-color: var(--primary-color);
    }

    .checkbox-label {
        font-size: 14px;
        color: var(--text-dark);
        line-height: 1.5;
        margin: 0 !important;
    }

    /* Modal Actions */
    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        padding-top: 10px;
    }

    .btn {
        padding: 14px 28px;
        border-radius: 10px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        font-size: 16px;
        min-width: 120px;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background: #3751db;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--secondary-color);
        color: var(--text-gray);
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn:disabled:hover {
        transform: none;
    }

    /* --- New Error Styling --- */
    .form-group.error input,
    .form-group.error textarea,
    .checkbox-group.error {
        border-color: var(--border-error) !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    }

    .error-message {
        color: var(--error-color);
        font-size: 12px;
        margin-top: 6px;
        display: none; /* Hidden by default */
    }

    .form-group.error .error-message {
        display: block; /* Show when error is active */
    }

    /* Specific adjustment for checkbox error message to align better */
    .checkbox-group.error .error-message {
        margin-left: 30px; /* Adjust as needed to align with text */
    }


    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .modal {
            padding: 0 20px 20px 20px;
            gap: 25px;
        }

        .modal-header {
            margin: 0 -20px 0 -20px;
            padding: 25px 25px 20px 25px;
            gap: 12px;
        }

        .header-icon {
            font-size: 20px;
            padding: 6px;
        }

        .modal-title {
            font-size: 20px;
        }

        .close-btn {
            top: 18px;
            right: 20px;
            width: 32px;
            height: 32px;
            font-size: 18px;
        }

        .progress-stepper {
            margin: 0 10px;
            padding: 15px 0;
        }

        .step {
            min-width: 70px;
            max-width: 90px;
        }

        .step-indicator {
            width: 45px;
            height: 45px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .step-label {
            font-size: 12px;
            padding: 0 2px;
        }

        .progress-line {
            top: 37px;
            left: 35px;
            right: 35px;
        }

        .step-content {
            padding: 20px;
            gap: 15px;
        }

        .step-content-title {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .location-group {
            margin-top: 0;
        }

        .modal-actions {
            flex-direction: column;
            gap: 10px;
            padding-top: 0;
        }

        .btn {
            width: 100%;
            padding: 12px 20px;
            font-size: 15px;
        }
    }

    @media (max-width: 480px) {
        .modal {
            padding: 0 15px 15px 15px;
            gap: 20px;
        }

        .modal-header {
            margin: 0 -15px 0 -15px;
            padding: 20px 20px 18px 20px;
            gap: 10px;
        }

        .header-icon {
            font-size: 18px;
            padding: 5px;
        }

        .modal-title {
            font-size: 18px;
        }

        .close-btn {
            top: 15px;
            right: 18px;
            width: 30px;
            height: 30px;
            font-size: 16px;
        }

        .step {
            min-width: 60px;
            max-width: 80px;
        }

        .step-indicator {
            width: 40px;
            height: 40px;
            font-size: 14px;
        }

        .step-label {
            font-size: 11px;
        }

        .progress-line {
            top: 32px;
            left: 30px;
            right: 30px;
        }
    }
</style>

@push('scripts')
    <script>
        let currentStepWizard = 1;
        const totalStepsWizard = 3;

        // Objek untuk menyimpan data form sementara dari setiap langkah
        const formDataWizard = {};

        // Ini akan tetap menjadi sumber data siswa Anda
        let studentDatabase = JSON.parse($("#data-siswa").val());

        const stepData = {
            1: {
                title: "Waktu Kejadian",
                content: `
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tanggal">Tanggal & Jam Kejadian</label>
                            <input type="datetime-local" id="tanggal" name="tanggal" required>
                            <div class="error-message" id="error-tanggal"></div>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi Kejadian</label>
                            <input type="text" id="lokasi" name="lokasi" placeholder="Masukkan lokasi kejadian" required>
                            <div class="error-message" id="error-lokasi"></div>
                        </div>
                    </div>
                `
            },
            2: {
                title: "Pihak Terlibat",
                content: `
                    <div class="form-row">
                        <div class="form-group">
                            <label for="id_korban">Nama Korban</label>
                            <select id="id_korban" name="id_korban[]" class="form-control select2-multiple" multiple="multiple" required style="width: 100%;">
                            </select>
                            <div class="error-message" id="error-id_korban"></div>
                        </div>
                        <div class="form-group">
                            <label for="id_pelaku">Nama Pelaku</label>
                            <select id="id_pelaku" name="id_pelaku[]" class="form-control select2-multiple" multiple="multiple" required style="width: 100%;">
                            </select>
                            <div class="error-message" id="error-id_pelaku"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_saksi">Saksi (Jika Ada)</label>
                        <select id="id_saksi" name="id_saksi[]" class="form-control select2-multiple" multiple="multiple" style="width: 100%;">
                        </select>
                        <div class="error-message" id="error-id_saksi"></div>
                    </div>
                `
            },
            3: {
                title: "Tindakan",
                content: `
                    <div class="form-group">
                        <label for="tindakan">Tindakan yang Diharapkan</label>
                        <textarea id="tindakan" name="tindakan" placeholder="Deskripsikan tindakan yang diharapkan untuk menyelesaikan masalah ini" rows="5" required></textarea>
                        <div class="error-message" id="error-tindakan"></div>
                    </div>
                    <div class="form-group">
                        <label for="info_tambahan">Informasi Tambahan</label>
                        <textarea id="info_tambahan" name="info_tambahan" placeholder="Masukkan informasi tambahan yang relevan" rows="4"></textarea>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="pernyataan" name="pernyataan" required>
                        <label for="pernyataan" class="checkbox-label">
                            Saya menyatakan bahwa semua informasi yang diberikan adalah benar dan dapat dipertanggungjawabkan
                        </label>
                        <div class="error-message" id="error-pernyataan"></div>
                    </div>
                `
            },
        };

        function updateWizardSteps() {
            // Destroy existing Select2 instances before replacing content to prevent memory leaks
            $('.select2-multiple').select2('destroy');

            for (let i = 1; i <= totalStepsWizard; i++) {
                const step = document.getElementById(`step${i}`);
                step.classList.remove('pending', 'active', 'completed');

                if (i < currentStepWizard) {
                    step.classList.add('completed');
                } else if (i === currentStepWizard) {
                    step.classList.add('active');
                } else {
                    step.classList.add('pending');
                }
            }

            let progressPercentage = 0;
            if (totalStepsWizard > 1) {
                progressPercentage = ((currentStepWizard - 1) / (totalStepsWizard - 1)) * 100;
            }
            document.getElementById('progressFill').style.width = progressPercentage + '%';

            const contentData = stepData[currentStepWizard];
            document.getElementById('contentTitle').textContent = contentData.title;
            document.getElementById('contentForm').innerHTML = contentData.content;

            // --- LOAD SAVED DATA & INITIALIZE SELECT2 ---
            loadFormDataForCurrentStep();

            // If it's step 2, initialize Select2
            if (currentStepWizard === 2) {
                initializeSelect2();
            }
            // --- END LOAD SAVED DATA & INITIALIZE SELECT2 ---

            attachValidationListeners();

            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            prevBtn.disabled = currentStepWizard === 1;

            if (currentStepWizard === totalStepsWizard) {
                nextBtn.textContent = 'Kirim Laporan';
            } else {
                nextBtn.textContent = 'Lanjutkan';
            }
        }

        // Function to save current step's data before moving
        function saveFormDataFromCurrentStep() {
            const currentContentForm = document.getElementById('contentForm');
            const inputs = currentContentForm.querySelectorAll('input, textarea, select');

            inputs.forEach(input => {
                const name = input.name;
                if (name) { // Only process elements with a name attribute
                    if (input.type === 'checkbox') {
                        formDataWizard[name] = input.checked;
                    } else if (input.hasAttribute('multiple') && input.tagName === 'SELECT') {
                        // For multiple select, get all selected values (array of strings)
                        formDataWizard[name] = Array.from(input.options)
                                                    .filter(option => option.selected)
                                                    .map(option => option.value);
                    } else {
                        formDataWizard[name] = input.value;
                    }
                }
            });
            console.log("Saved formDataWizard:", formDataWizard);
        }

        // Function to load data into current step's fields
        function loadFormDataForCurrentStep() {
            const currentContentForm = document.getElementById('contentForm');
            const inputs = currentContentForm.querySelectorAll('input, textarea, select');

            inputs.forEach(input => {
                const name = input.name;
                if (name && formDataWizard.hasOwnProperty(name)) {
                    const savedValue = formDataWizard[name];

                    if (input.type === 'checkbox') {
                        input.checked = savedValue;
                    } else if (input.hasAttribute('multiple') && input.tagName === 'SELECT') {
                        // For multiple select, Select2 will handle setting values after initialization
                        // We just make sure the values are in formDataWizard
                        // The updateSelect2Options will use these values to pre-select
                    } else {
                        input.value = savedValue;
                    }
                }
            });
        }

        function showValidationError(field, message) {
            const formGroup = field.closest('.form-group') || field.closest('.checkbox-group');
            if (formGroup) {
                formGroup.classList.add('error');
                const errorMessageDiv = formGroup.querySelector('.error-message');
                if (errorMessageDiv) {
                    errorMessageDiv.textContent = message;
                    errorMessageDiv.style.display = 'block';
                }
            }
        }

        function hideValidationError(field) {
            const formGroup = field.closest('.form-group') || field.closest('.checkbox-group');
            if (formGroup) {
                formGroup.classList.remove('error');
                const errorMessageDiv = formGroup.querySelector('.error-message');
                if (errorMessageDiv) {
                    errorMessageDiv.textContent = '';
                    errorMessageDiv.style.display = 'none';
                }
            }
        }

        function validateField(field) {
            if (field.hasAttribute('required')) {
                if (field.type === 'checkbox') {
                    if (!field.checked) {
                        showValidationError(field, `Mohon centang pernyataan ini.`);
                        return false;
                    }
                } else if (field.tagName === 'SELECT' && field.hasAttribute('multiple')) {
                    // For multiple Select2, check if at least one option is selected
                    if ($(field).val() === null || $(field).val().length === 0) { // Check for null or empty array
                        const labelText = field.previousElementSibling && field.previousElementSibling.tagName === 'LABEL' ? field.previousElementSibling.textContent : '';
                        showValidationError(field, `${labelText ? labelText + ' ' : ''}harus dipilih setidaknya satu.`);
                        return false;
                    }
                } else if (!field.value.trim()) {
                    const labelText = field.previousElementSibling && field.previousElementSibling.tagName === 'LABEL' ? field.previousElementSibling.textContent : field.placeholder;
                    showValidationError(field, `${labelText ? labelText + ' ' : ''}harus diisi.`);
                    return false;
                }
            }
            hideValidationError(field);
            return true;
        }

        function attachValidationListeners() {
            const currentContentForm = document.getElementById('contentForm');
            const fields = currentContentForm.querySelectorAll('input[required], textarea[required], input[type="checkbox"][required], select[required]');

            fields.forEach(field => {
                if (field.classList.contains('select2-multiple')) {
                    // Select2 uses its own events for changes
                    $(field).on('change', function() {
                        validateField(this);
                        // Also save data on change for Select2 fields
                        saveFormDataFromCurrentStep();
                    });
                } else {
                    field.addEventListener('input', () => {
                        validateField(field);
                    });
                    field.addEventListener('change', () => {
                        validateField(field);
                    });
                    // Save data on change for regular inputs
                    field.addEventListener('blur', () => { // Using blur to save when user leaves the field
                        saveFormDataFromCurrentStep();
                    });
                }
            });
        }

        function validateCurrentStep() {
            const currentContentForm = document.getElementById('contentForm');
            const requiredFields = currentContentForm.querySelectorAll('input[required], textarea[required], input[type="checkbox"][required], select[required]');
            let isValid = true;
            let firstInvalidField = null;

            // Clear all previous errors for the current step before re-validating
            requiredFields.forEach(field => hideValidationError(field));

            for (let field of requiredFields) {
                if (field.classList.contains('select2-multiple')) {
                    // Specific validation for Select2 multiple required
                    if (field.hasAttribute('required') && ($(field).val() === null || $(field).val().length === 0)) {
                        isValid = false;
                        showValidationError(field, `Mohon pilih setidaknya satu ${field.previousElementSibling.textContent.toLowerCase().replace(':', '')}.`);
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    }
                } else if (!validateField(field)) {
                    isValid = false;
                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                }
            }

            if (!isValid && firstInvalidField) {
                // Attempt to focus on the first invalid field
                if (firstInvalidField.classList.contains('select2-multiple')) {
                    // For Select2, opening it is the closest to "focusing"
                    $(firstInvalidField).select2('open');
                } else if (firstInvalidField.type !== 'checkbox') {
                    firstInvalidField.focus();
                }
            }
            return isValid;
        }

        function nextStep() {
            if (validateCurrentStep()) {
                saveFormDataFromCurrentStep(); // Save data before moving to the next step
                if (currentStepWizard < totalStepsWizard) {
                    currentStepWizard++;
                    updateWizardSteps();
                } else {
                    submitReportToLaravel(); // Submit the report when all steps are completed and valid
                }
            }
        }

        function previousStep() {
            // We still save data when going back, just in case user comes back later
            saveFormDataFromCurrentStep();
            // Clear errors when navigating back
            const currentContentForm = document.getElementById('contentForm');
            const fields = currentContentForm.querySelectorAll('input[required], textarea[required], input[type="checkbox"][required], select[required]');
            fields.forEach(field => hideValidationError(field));

            if (currentStepWizard > 1) {
                currentStepWizard--;
                updateWizardSteps();
            }
        }

        function openCompleteDocumentsForm(initialStep = 1) {
            const modalOverlay = document.getElementById('completeDocumentsModal');
            if (modalOverlay) {
                const actualModal = modalOverlay.querySelector('.modal');

                // Reset formDataWizard when opening the form for a fresh start
                for (const key in formDataWizard) {
                    delete formDataWizard[key];
                }
                currentStepWizard = initialStep;
                updateWizardSteps();

                modalOverlay.style.display = 'flex';
                if (actualModal) {
                    actualModal.style.display = 'block';
                }

                setTimeout(() => {
                    modalOverlay.style.opacity = '1';
                    if (actualModal) {
                        actualModal.style.animation = 'modalSlideIn 0.3s ease-out forwards';
                    }
                }, 10);
            }
        }

        function closeCompleteDocumentsForm() {
            const modalOverlay = document.getElementById('completeDocumentsModal');
            const actualModal = modalOverlay.querySelector('.modal');
            if (modalOverlay && actualModal) {
                actualModal.style.animation = 'modalSlideOut 0.3s ease-in forwards';
                modalOverlay.style.opacity = '0';

                setTimeout(() => {
                    modalOverlay.style.display = 'none';
                    actualModal.style.animation = '';
                    const allErrorMessages = document.querySelectorAll('.error-message');
                    allErrorMessages.forEach(msg => {
                        msg.style.display = 'none';
                        const parentGroup = msg.closest('.form-group') || msg.closest('.checkbox-group');
                        if (parentGroup) {
                            parentGroup.classList.remove('error');
                        }
                    });
                    // Destroy Select2 instances when closing the modal
                    $('.select2-multiple').select2('destroy');
                    // Clear saved data when closing the form
                    for (const key in formDataWizard) {
                        delete formDataWizard[key];
                    }
                }, 300);
            }
        }

        window.openCompleteDocumentsForm = openCompleteDocumentsForm;
        window.closeCompleteDocumentsForm = closeCompleteDocumentsForm;

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('completeDocumentsModal');
            if (modal) {
                modal.style.display = 'none';
                modal.style.opacity = '0';
            }
        });

        // --- Select2 Specific Functions ---

        function initializeSelect2() {
            // Initialize all select2 multiple fields
            // Pass initial data from formDataWizard if available
            const initialKorban = formDataWizard['id_korban[]'] || [];
            const initialPelaku = formDataWizard['id_pelaku[]'] || [];
            const initialSaksi = formDataWizard['id_saksi[]'] || [];

            $('#id_korban, #id_pelaku, #id_saksi').select2({
                placeholder: 'Pilih Student',
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $('#completeDocumentsModal')
            });

            // Attach event listeners for selection changes
            $('#id_korban, #id_pelaku, #id_saksi').on('change', function() {
                // Re-run the option update only after Select2 has registered the change
                updateSelect2Options();
                validateField(this); // Validate the changed field
                saveFormDataFromCurrentStep(); // Save data after a Select2 change
            });

            // Call once to set initial options and pre-select based on saved data
            // This needs to happen AFTER Select2 is initialized
            updateSelect2Options(initialKorban, initialPelaku, initialSaksi);
        }

        function updateSelect2Options(initialKorban = [], initialPelaku = [], initialSaksi = []) {
            // Get currently selected values from Select2s, or use initial values if provided (on load)
            const selectedKorban = initialKorban.length > 0 ? initialKorban : ($('#id_korban').val() || []);
            const selectedPelaku = initialPelaku.length > 0 ? initialPelaku : ($('#id_pelaku').val() || []);
            const selectedSaksi = initialSaksi.length > 0 ? initialSaksi : ($('#id_saksi').val() || []);

            const allSelectedIds = new Set();
            selectedKorban.forEach(id => allSelectedIds.add(parseInt(id)));
            selectedPelaku.forEach(id => allSelectedIds.add(parseInt(id)));
            selectedSaksi.forEach(id => allSelectedIds.add(parseInt(id)));

            const updateSelect2Field = (fieldId, currentSelectedValues) => {
                const availableOptions = studentDatabase.filter(student => {
                    return !allSelectedIds.has(student.id) || currentSelectedValues.includes(student.id.toString());
                });

                // Destroy and re-initialize to force update of options
                $(fieldId).select2('destroy');
                $(fieldId).empty().select2({
                    data: availableOptions,
                    placeholder: 'Pilih Student',
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownParent: $('#completeDocumentsModal')
                });
                // Set the previously selected values
                $(fieldId).val(currentSelectedValues).trigger('change.select2');
            };

            updateSelect2Field('#id_korban', selectedKorban);
            updateSelect2Field('#id_pelaku', selectedPelaku);
            updateSelect2Field('#id_saksi', selectedSaksi);
        }


        async function submitReportToLaravel() {
            const reporterId = $("#reporter_id").val(); // **Ganti dengan ID reporter yang sebenarnya (dari sesi login/konteks aplikasi Anda)**

            const formData = {
                reporter_id: reporterId,
                report_date: formDataWizard['tanggal'],
                location: formDataWizard['lokasi'],
                description: formDataWizard['info_tambahan'],
                notes_by_student: formDataWizard['tindakan'], // Make sure this matches the 'name' attribute
                victims: formDataWizard['id_korban[]'],
                perpetrators: formDataWizard['id_pelaku[]'],
                witnesses: formDataWizard['id_saksi[]']
            };

            console.log("Submitting form data:", formData);

            try {
                const response = await fetch('/lapor-detail', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    console.error('Error submitting report:', errorData);
                    alert('Gagal mengirim laporan: ' + (errorData.message || 'Terjadi kesalahan.'));
                    return;
                }

                const result = await response.json();
                console.log('Report submitted successfully:', result);

                if (typeof trackReportModule !== 'undefined' && typeof trackReportModule.showSuccessMessage === 'function') {
                    trackReportModule.showSuccessMessage();
                } else {
                    alert('Laporan berhasil dikirim! Terima kasih atas laporan Anda.');
                }
                closeCompleteDocumentsForm();

            } catch (error) {
                alert('Terjadi kesalahan jaringan atau tak terduga. Mohon coba lagi.');
            }
        }

        // Function to simulate fetching student data from Laravel API

    </script>
@endpush
