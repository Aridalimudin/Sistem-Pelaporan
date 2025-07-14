@extends('layouts.main')
@section('title', 'Laporan Kejadian - MTS AR-RIYADL')
@section('content')
    <input type="hidden" value="{{csrf_token()}}" id="token_laravel">
    <!-- Form Laporan -->
    <div class="container">
        <div class="card p-4 mt-4 shadow-sm">
            <h2 class="mb-3 text-center text-dark">Formulir Laporan</h2>
            <p class="text-center text-muted small">Laporkan kejadian yang Anda alami atau saksikan dengan aman.</p>
           
            <form id="laporanForm" method="POST" enctype="multipart/form-data">
                <!-- Identitas Pelapor -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIS (Nomor Induk Siswa) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control number-only" name="nis" id="nis" placeholder="Masukkan NIS Anda">
                        <div class="invalid-feedback">NIS wajib diisi</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email Anda">
                        <div class="invalid-feedback">Email wajib diisi dengan format yang benar</div>
                    </div>
                </div>
                <!-- Input field with autocomplete -->
                <div class="mb-3 autocomplete-container">
                    <label class="form-label">Uraian Kejadian <span class="text-danger">*</span></label>
                    <div class="position-relative">
                        <textarea class="form-control" rows="6" id="uraian" name="uraian" placeholder="Jelaskan kejadian..." required></textarea>
                        <div class="invalid-feedback">Uraian kejadian wajib diisi</div>
                        <div id="suggestions-container" class="suggestions-container"></div>
                    </div>
                    <!-- Tag preview will be inserted here by the script -->
                </div>

                <!-- Hidden input for tags -->
                <input type="hidden" name="tags" id="tags" value="[]" />

                <div class="mb-3">
                    <label class="form-label">Upload Bukti (Foto/Video)</label>
                    <div id="dropzone" class="dropzone">
                        <div class="dz-message">Seret dan lepaskan file di sini untuk meng-upload</div>
                    </div>
                    <small class="text-muted">Format yang didukung: JPG, PNG, MP4 (Maks. 5MB)</small>
                </div>
                <button type="submit" class="btn btn-primary w-100" id="btn-submit" disabled>KIRIM LAPORAN</button>
            </form>
        </div>
    </div>
   
    <!-- Popup Status Laporan -->
    <div id="popup" class="popup">
        <div class="popup-content shadow-lg rounded p-4">
            <span class="close" onclick="closePopup()">&times;</span>
            <div class="icon">✔</div>
            <h5>DATA BERHASIL DISIMPAN</h5>
            <p>KODE TICKET LAPORAN ANDA</p>
            <h3 id="ticketCode"></h3>
            <button class="btn btn-primary" onclick="closePopup()">OK</button>
        </div>
    </div>

    <!-- Error Alert -->
    <div id="errorAlert" class="alert alert-danger alert-dismissible fade" role="alert" style="display:none; position:fixed; top:20px; right:20px; z-index:9999;">
        <strong>Kesalahan!</strong> <span id="errorMessage"></span>
        <button type="button" class="btn-close" onclick="closeErrorAlert()"></button>
    </div>
        
@push('styles')
<link rel="stylesheet" href="{{asset('css/style_form.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.6/tagify.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.css" />
<style>
    #keyword-error {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: none;
        font-weight: 500;
        padding: 8px 12px;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 4px;
        animation: errorFadeIn 0.3s ease-out;
    }

    @keyframes errorFadeIn {
        from { 
            opacity: 0; 
            transform: translateY(-5px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    .popup {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
    }
    
    .popup-content {
        background-color: white;
        max-width: 400px;
        width: 90%;
        text-align: center;
        animation: popupFade 0.3s;
    }
    
    .hidden {
        display: none;
    }
    
    .error-text {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .is-invalid {
        border-color: #dc3545;
    }
    
    .section-divider {
        border-top: 1px solid #dee2e6;
    }
    
    .icon {
        font-size: 48px;
        color: #28a745;
        margin-bottom: 15px;
    }
    
    .error-highlight {
        background-color: #fff8f8;
        border: 1px solid #dc3545;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    
    /* Tanda bintang wajib diisi */
    .required-field::after {
        content: " *";
        color: #dc3545;
        font-weight: bold;
    }
    
    /* Efek animasi untuk highlight field yang error */
    @keyframes errorShake {
        0%, 100% {transform: translateX(0);}
        10%, 30%, 50%, 70%, 90% {transform: translateX(-5px);}
        20%, 40%, 60%, 80% {transform: translateX(5px);}
    }
    
    .error-shake {
        animation: errorShake 0.6s;
    }
    
    @keyframes popupFade {
        from {opacity: 0; transform: scale(0.9);}
        to {opacity: 1; transform: scale(1);}
    }
    
    /* Responsif untuk mobile */
    @media (max-width: 576px) {
        .popup-content {
            width: 95%;
            padding: 15px !important;
        }
        
        h2 {
            font-size: 1.5rem;
        }
        
        h3 {
            font-size: 1.25rem;
        }
    }
    /*uraian*/
    .search-wrapper {
        position: relative;
        width: 100%;
        }
        
        .suggestions-container {
            position: absolute;
            width: 100%;
            max-height: 240px;
            overflow-y: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.12);
            z-index: 1000;
            display: none;
            border: 1px solid #e0e0e0;
            scrollbar-width: thin;
            margin-top: 5px;
            }

            .suggestion-item {
            padding: 10px 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.15s ease;
            }

            .suggestion-item:last-child {
            border-bottom: none;
            }

            .suggestion-item:hover, .suggestion-item.active {
            background-color: #f5f9ff;
            }

            .suggestion-item.active {
            background-color: #edf4ff;
            border-left: 3px solid #1a73e8;
            }

            .suggestion-content {
            display: flex;
            flex: 1;
            align-items: center;
            }

            .suggestion-text {
            flex-grow: 1;
            }

            .highlight {
            font-weight: 600;
            color: #1a73e8;
            }

            /* Animation for suggestions appearing */
            @keyframes smoothFadeIn {
            from { opacity: 0; transform: translateY(-3px); }
            to { opacity: 1; transform: translateY(0); }
            }

            .suggestions-container {
            animation: smoothFadeIn 0.15s ease-out;
            }

            /* Make scrollbar more attractive */
            .suggestions-container::-webkit-scrollbar {
            width: 5px;
            }

            .suggestions-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 8px;
            }

            .suggestions-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 8px;
            }

            .suggestions-container::-webkit-scrollbar-thumb:hover {
            background: #a0a0a0;
            }

            /* Keyboard navigation hint */
            .keyboard-hint {
            display: flex;
            justify-content: center;
            padding: 5px;
            background-color: #f8f9fa;
            font-size: 11px;
            color: #70757a;
            border-top: 1px solid #e0e0e0;
            }

            .key {
            display: inline-block;
            margin: 0 3px;
            padding: 1px 4px;
            background-color: #e8eaed;
            border-radius: 3px;
            border: 1px solid #dadce0;
            }

            /* Responsive adjustments */
            @media (max-width: 576px) {
            .suggestions-container {
                max-height: 180px;
            }
            
            .suggestion-item {
                padding: 8px 12px;
                }
            }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
<script>
   Dropzone.options.dropzone = {
        url: '{{ route("lapor.upload") }}',  // Ganti dengan URL untuk menangani upload
        paramName: "file", // Nama parameter untuk file
        maxFilesize: 20,  // Ukuran file maksimal (dalam MB)
        uploadMultiple: true,
        addRemoveLinks: true,
        parallelUploads: 10,
        maxFiles:3,
        acceptedFiles: '.jpg,.jpeg,.png,.mp4', // Format file yang diterima
        dictDefaultMessage: "Seret dan lepaskan file di sini untuk meng-upload", // Pesan default
        dictFallbackMessage: "Browser Anda tidak mendukung drag-and-drop", // Pesan fallback
        dictInvalidFileType: "Jenis file ini tidak diizinkan", // Pesan jika file tidak sesuai
        dictFileTooBig: "File terlalu besar. Maksimal 5 MB", // Pesan jika file terlalu besar
        dictResponseError: "Server tidak merespons dengan benar", // Pesan jika ada error server
        dictCancelUpload: "Batalkan Upload", // Pesan untuk membatalkan upload
        dictUploadCanceled: "Upload dibatalkan", // Pesan jika upload dibatalkan
        dictCancelUploadConfirmation: "Apakah Anda yakin ingin membatalkan upload?", // Konfirmasi batalkan upload
        autoProcessQueue: true,  // Aktifkan proses otomatis saat file ditambahkan
        dictFileTooBig: "File terlalu besar. Maksimal 20 MB",
        headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
        },
        init: function() {
             this.on("sending", function() {
             
            });
        },
        successmultiple : function(file, response){
            $.each(response.data, function( key, value ) {
                $('form#laporanForm').append('<input type="hidden" name="file[]" class="files" value="'+value+'">')
            });
        }
    };

   // Fungsi untuk validasi form
   function validateForm() {
       let isValid = true;
       
       // Validasi NIS
       const nis = $("#nis").val().trim();
       if (nis === "") {
           $("#nis").addClass("is-invalid error-shake");
           isValid = false;
       } else {
           $("#nis").removeClass("is-invalid error-shake");
       }
       
       // Validasi Email
       const email = $("#email").val().trim();
       const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
       if (email === "" || !emailRegex.test(email)) {
           $("#email").addClass("is-invalid error-shake");
           isValid = false;
       } else {
           $("#email").removeClass("is-invalid error-shake");
       }
       
       // Validasi Uraian
       const uraian = $("#uraian").val().trim();
       if (uraian === "") {
           $("#uraian").addClass("is-invalid error-shake");
           isValid = false;
       } else {
           $("#uraian").removeClass("is-invalid error-shake");
       }
       
       return isValid;
   }

   $("#laporanForm").validate({
        rules: {
            nis: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            uraian: {
                required: true,
            }
        },
        messages: {
            nis: {
                required: function() {
                    toastr.error('NIS harus diisi.');
                },
            },
            email: {
                required: function() {
                    toastr.error('Email harus diisi.');
                },
                email: function() {
                    toastr.error('Masukan Alamat Email Yang Valid.');
                },
            },
            uraian: {
                required: function() {
                    toastr.error('Uraian Kejadian harus diisi.');
                },
            }
        },
        submitHandler: function(form) {
            // Validasi tambahan
           
            
            // Meminta konfirmasi menggunakan SweetAlert
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan mengirimkan laporan ini!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Memproses upload file sebelum mengirim form
                   
                    // Jika tidak ada file, langsung kirim data ke backend
                    var nis = $("#nis").val();
                    var email = $("#email").val();
                    var uraian = $("#uraian").val();
                    var tags = $("#tags").val();

                    // Membuat FormData baru
                    var formData = new FormData();
                    formData.append("_token", "{{ csrf_token() }}");
                    formData.append("nis", nis);
                    formData.append("email", email);
                    formData.append("uraian", uraian);
                    formData.append("tags", tags);

                    // Menambahkan file yang di-upload ke FormData
                    var files = $(".files");  // Ambil file dari input file (multiple)

                    files.each(function() {
                        var fileInput = $(this)[0];  // Ambil elemen input file
                        var fileList = $(fileInput).val(); 
                        // Ambil daftar file dari input file

                        // Menambahkan setiap file ke dalam FormData
                    
                        formData.append("image[]", fileList);
                    
                    });
                    // Tambahkan visual loading indicator
                    $("#btn-submit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...');
                    $("#btn-submit").prop('disabled', true);

                    // Kirim data form tanpa file
                    $.ajax({
                        url: '{{route("lapor.store")}}',  // Ganti dengan URL yang sesuai untuk memproses upload
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Reset button
                            $("#btn-submit").html('KIRIM LAPORAN');
                            $("#btn-submit").prop('disabled', false);
                            
                            if(!response.status){
                                toastr.error(response.message);
                                return false;
                            }
                            
                            // Tampilkan popup dengan kode tiket
                            $("#ticketCode").text(response.data.code || "TICKET-000");
                            $("#popup").css("display", "flex");
                            
                            // Reset formulir setelah berhasil
                            $("#laporanForm")[0].reset();
                            var dropzone = Dropzone.forElement("#dropzone");
                            if (dropzone) {
                                dropzone.removeAllFiles(true);
                            }
                            
                            toastr.success('Laporan berhasil dikirim!');
                            setTimeout(function() {
                                window.location.href = `/track?code=${response.data.code}`;
                                }, 2000);
                        },
                        error: function(xhr, status, error) {
                            // Reset button
                            $("#btn-submit").html('KIRIM LAPORAN');
                            $("#btn-submit").prop('disabled', false);
                            
                            toastr.error('Terjadi kesalahan, silakan coba lagi.');
                        }
                    });
                }
            });
        }
    });
    
    // Fungsi untuk menutup popup
    function closePopup() {
        $("#popup").css("display", "none");
    }
    
    // Fungsi untuk menutup error alert
    function closeErrorAlert() {
        $("#errorAlert").hide();
    }
    
    // Tambahan event listener untuk menghapus highlight error ketika user mulai mengetik
    $("input, textarea").on("input", function() {
        $(this).removeClass("is-invalid error-shake");
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.6/tagify.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('uraian');
        const suggestionsContainer = document.getElementById('suggestions-container');
        const hiddenTagInput = document.getElementById('tags');
        
        let selectedTags = [];
        
        // Initialize hidden input with empty array
        hiddenTagInput.value = JSON.stringify(selectedTags);
        
        async function getSuggestionsFromAPI() {
    // Temukan elemen yang akan digunakan untuk menampilkan pesan error
    const errorMessageElement = document.getElementById('error-message');
    // Jika elemen tidak ditemukan, coba buat elemen baru
    if (!errorMessageElement) {
        const newErrorElement = document.createElement('div');
        newErrorElement.id = 'error-message';
        newErrorElement.className = 'text-red-500 mt-2';
        // Tambahkan ke form atau container yang sesuai
        const container = document.querySelector('form') || document.body;
        container.appendChild(newErrorElement);
    }
    
        try {
            // Reset pesan error sebelum melakukan request baru
            if (document.getElementById('error-message')) {
                document.getElementById('error-message').textContent = '';
            }
            
            // Mengambil data dari API
            const response = await fetch('/api/crimes');
            
            // Mengecek apakah response berhasil
            if (!response.ok) {
                throw new Error('API response error: ' + response.status);
            }

            // Parse response JSON
            const crimes = await response.json();

            // Pastikan data valid
            if (!Array.isArray(crimes) || crimes.length === 0) {
                throw new Error('Data dari API tidak valid atau kosong');
            }

            // Mengambil dan mengembalikan nama-nama kejahatan dari API
            return crimes.map(crime => crime.name);
            
        } catch (error) {
            // Menangani kesalahan dan menampilkan log error
            console.error('Error fetching suggestions:', error);

            // Tampilkan pesan error di UI dengan tulisan, bukan popup alert
            if (document.getElementById('error-message')) {
                document.getElementById('error-message').textContent = 'Gagal mengambil data kejahatan dari server, coba lagi nanti.';
            }
            
            return []; // Kembalikan array kosong jika ada kesalahan
        }
    }

        
        function addTag(tag) {
        if (!selectedTags.includes(tag)) {
            selectedTags.push(tag);
            hiddenTagInput.value = JSON.stringify(selectedTags);
            
            // Add visual feedback that tag was added
            showTagsPreview();
            
            // Sembunyikan error jika ada tag yang dipilih
            hideKeywordError();
        }
    }
        
        // Function to show selected tags preview
        function showTagsPreview() {
            const tagsPreview = document.getElementById('tags-preview');
            if (tagsPreview) {
                tagsPreview.innerHTML = '';
                
                if (selectedTags.length > 0) {
                    // Tambahkan label "Kata kunci terpilih:"
                    const labelElement = document.createElement('small');
                    labelElement.classList.add('text-muted', 'd-block', 'mb-2');
                    labelElement.textContent = 'Kata kunci terpilih:';
                    tagsPreview.appendChild(labelElement);
                }
                
                selectedTags.forEach((tag, index) => {
                   
                    const tagElement = document.createElement('span');
                    tagElement.classList.add('badge', 'bg-primary', 'me-2', 'mb-1');
                    tagElement.innerHTML = `${tag} <i class="bi bi-x" data-index="${index}" style="cursor: pointer; margin-left: 5px;"></i>`;
                    tagsPreview.appendChild(tagElement);

                    //add input hidden
                    
                    // Add click event to remove tag
                    tagElement.querySelector('i').addEventListener('click', function() {
                        const idx = parseInt(this.getAttribute('data-index'));
                        selectedTags.splice(idx, 1);
                        hiddenTagInput.value = JSON.stringify(selectedTags);
                        showTagsPreview();
                        
                        // Tampilkan error lagi jika tidak ada kata kunci yang dipilih
                        if (selectedTags.length === 0) {
                            $("#btn-submit").attr('disabled', true);
                            showKeywordError("Kata kunci wajib dipilih minimal 1!");
                        }
                    });
                });
            }
        }

        function getLastWord(text) {
            const words = text.split(' ');
            return words[words.length - 1].toLowerCase();
        }

        async function showSuggestions(inputText) {
            const lastWord = getLastWord(inputText);
            
            if (lastWord.length < 1) {
                suggestionsContainer.style.display = 'none';
                return;
            }

            const suggestions = await getSuggestionsFromAPI();
            
            if (!suggestions || suggestions.length === 0) {
                suggestionsContainer.style.display = 'none';
                return;
            }

            const filteredSuggestions = suggestions.filter(suggestion => 
                suggestion.toLowerCase().includes(lastWord)
            );
            
            if (filteredSuggestions.length === 0) {
                suggestionsContainer.style.display = 'none';
                return;
            }

            let suggestionsHTML = '';
            
            filteredSuggestions.forEach((suggestion, index) => {
                const regex = new RegExp(`(${lastWord})`, 'gi');
                const highlightedSuggestion = suggestion.replace(
                    regex, 
                    '<span class="highlight">$1</span>'
                );
                
                suggestionsHTML += `
                    <div class="suggestion-item" data-value="${suggestion}" data-index="${index}">
                        <div class="suggestion-content">
                            <span class="suggestion-text">${highlightedSuggestion}</span>
                        </div>
                    </div>
                `;
            });
            
            suggestionsHTML += `
                <div class="keyboard-hint">
                    Gunakan <span class="key">↑</span><span class="key">↓</span> untuk navigasi dan <span class="key">Enter</span> untuk memilih
                </div>
            `;
            
            suggestionsContainer.innerHTML = suggestionsHTML;
            suggestionsContainer.style.display = 'block';
            
            const suggestionItems = document.querySelectorAll('.suggestion-item');
            suggestionItems.forEach(item => {
                item.addEventListener('click', function() {
                    selectSuggestion(this);
                });
                
                item.addEventListener('mouseenter', function() {
                    document.querySelectorAll('.suggestion-item').forEach(i => {
                        i.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });
        }

        
        function validateForm() {
            if (selectedTags.length === 0) {
                // Tampilkan pesan error di bawah textarea
                showKeywordError("Kata kunci wajib dipilih minimal 1!");
                return false;
            }
            // Sembunyikan pesan error jika validasi berhasil
            hideKeywordError();
            return true;
        }
        
                // Fungsi untuk menampilkan error kata kunci
        function showKeywordError(message) {
            let errorElement = document.getElementById('keyword-error');
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.id = 'keyword-error';
                errorElement.className = 'error-text mt-2';
                // Masukkan setelah suggestions container
                const suggestionsContainer = document.getElementById('suggestions-container');
                suggestionsContainer.parentNode.insertBefore(errorElement, suggestionsContainer.nextSibling);
            }
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            
            // Tambahkan efek shake pada textarea
            const textarea = document.getElementById('uraian');
            textarea.classList.add('error-shake');
            setTimeout(() => {
                textarea.classList.remove('error-shake');
            }, 600);
        }

        // Fungsi untuk menyembunyikan error kata kunci
        function hideKeywordError() {
            const errorElement = document.getElementById('keyword-error');
            if (errorElement) {
                errorElement.style.display = 'none';
            }
        }

        const laporanForm = document.getElementById('laporanForm');
        if (laporanForm) {
            laporanForm.addEventListener('submit', function(event) {
                if (!validateForm()) {
                    event.preventDefault(); // Prevent form submission if validation fails
                    // Scroll ke area error untuk memudahkan user melihat pesan error
                    const errorElement = document.getElementById('keyword-error');
                    if (errorElement) {
                        errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        }

        function selectSuggestion(item) {
            const value = item.getAttribute('data-value');
            addTag(value);

            $("#btn-submit").attr('disabled', false);
            const cursorPosition = textarea.selectionStart;
            const textBeforeCursor = textarea.value.substring(0, cursorPosition);
            const lastSpaceIndex = textBeforeCursor.lastIndexOf(' ');
            const textAfterCursor = textarea.value.substring(cursorPosition);
            
            if (lastSpaceIndex === -1) {
                textarea.value = value + ' ' + textAfterCursor;
            } else {
                textarea.value = textBeforeCursor.substring(0, lastSpaceIndex + 1) + 
                                value + ' ' + textAfterCursor;
            }
            
            textarea.focus();
            const newPosition = lastSpaceIndex === -1 ? 
                                value.length + 1 : 
                                lastSpaceIndex + 1 + value.length + 1;
            textarea.selectionStart = textarea.selectionEnd = newPosition;
            
            suggestionsContainer.style.display = 'none';
            
            textarea.classList.add('suggestion-selected');
            setTimeout(() => {
                textarea.classList.remove('suggestion-selected');
            }, 300);
        }
        
        let timeout = null;
        textarea.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const cursorPosition = this.selectionStart;
                const textBeforeCursor = this.value.substring(0, cursorPosition);
                showSuggestions(textBeforeCursor);
            }, 100);
        });
        
        textarea.addEventListener('click', function() {
            const cursorPosition = this.selectionStart;
            const textBeforeCursor = this.value.substring(0, cursorPosition);
            
            showSuggestions(textBeforeCursor);
        });
        
        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target !== textarea && !suggestionsContainer.contains(e.target)) {
                suggestionsContainer.style.display = 'none';
            }
        });
        
        textarea.addEventListener('keydown', function(e) {
            const items = document.querySelectorAll('.suggestion-item');
            
            if (items.length === 0 || suggestionsContainer.style.display === 'none') {
                return;
            }
            
            const activeItem = document.querySelector('.suggestion-item.active');
            let activeIndex = -1;
            
            if (activeItem) {
                activeIndex = parseInt(activeItem.getAttribute('data-index'));
            }
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                
                if (!activeItem) {
                    items[0].classList.add('active');
                    items[0].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                    return;
                }
                
                if (activeIndex < items.length - 1) {
                    activeItem.classList.remove('active');
                    items[activeIndex + 1].classList.add('active');
                    items[activeIndex + 1].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                
                if (!activeItem) {
                    items[items.length - 1].classList.add('active');
                    items[items.length - 1].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                    return;
                }
                
                if (activeIndex > 0) {
                    activeItem.classList.remove('active');
                    items[activeIndex - 1].classList.add('active');
                    items[activeIndex - 1].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                }
            } else if (e.key === 'Enter' && activeItem) {
                e.preventDefault();
                selectSuggestion(activeItem);
            } else if (e.key === 'Escape') {
                suggestionsContainer.style.display = 'none';
            } else if (e.key === 'Tab' && activeItem) {
                e.preventDefault();
                selectSuggestion(activeItem);
            }
        });
        
        // Add styles for the suggestion container and items
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                @keyframes suggestionGlow {
                    0% { box-shadow: 0 0 0 rgba(26, 115, 232, 0); }
                    50% { box-shadow: 0 0 8px rgba(26, 115, 232, 0.3); }
                    100% { box-shadow: 0 0 0 rgba(26, 115, 232, 0); }
                }
                
                .suggestion-selected {
                    animation: suggestionGlow 0.3s ease-out;
                }
                
                .autocomplete-container {
                    position: relative;
                }
                
                .suggestions-container {
                    position: absolute;
                    width: 100%;
                    max-height: 200px;
                    overflow-y: auto;
                    background: white;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                    z-index: 1000;
                    display: none;
                }
                
                .suggestion-item {
                    padding: 8px 12px;
                    cursor: pointer;
                }
                
                .suggestion-item:hover,
                .suggestion-item.active {
                    background-color: #f1f7ff;
                }
                
                .suggestion-text .highlight {
                    font-weight: bold;
                    color: #1a73e8;
                }
                
                .keyboard-hint {
                    padding: 8px 12px;
                    font-size: 12px;
                    color: #555;
                    background-color: #f5f5f5;
                    border-top: 1px solid #ddd;
                }
                
                .keyboard-hint .key {
                    display: inline-block;
                    padding: 2px 6px;
                    background: #e2e2e2;
                    border-radius: 3px;
                    margin: 0 2px;
                    font-weight: bold;
                }
                
                #tags-preview {
                    margin-top: 8px;
                }
                
                #tags-preview .badge i {
                    cursor: pointer;
                    margin-left: 5px;
                }
            </style>
        `);
        
        // Create a preview area for selected tags
        const tagPreviewDiv = document.createElement('div');
        tagPreviewDiv.id = 'tags-preview';
        tagPreviewDiv.classList.add('d-flex', 'flex-wrap');
        
        // Insert the tag preview after the suggestions container
        textarea.parentNode.insertAdjacentElement('afterend', tagPreviewDiv);
    });
    </script>

    @endpush
    @endsection


