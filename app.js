(function() {
    // DOM Elements
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const selectedFile = document.getElementById('selectedFile');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFile = document.getElementById('removeFile');
    const uploadBtn = document.getElementById('uploadBtn');

    // Sidebar elements
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    // Modal elements
    const fileModal = document.getElementById('fileModal');
    const modalFileName = document.getElementById('modalFileName');
    const modalOpen = document.getElementById('modalOpen');
    const modalDownload = document.getElementById('modalDownload');
    const modalClose = document.getElementById('modalClose');

    // File types that should be opened directly (viewable in browser)
    const viewableTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico', 'pdf', 'txt', 'html', 'htm', 'xml', 'json', 'mp4', 'webm', 'mp3', 'wav', 'ogg'];

    // ==========================================================================
    // Helper Functions
    // ==========================================================================

    function formatSize(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    function getFileExtension(filename) {
        return filename.split('.').pop().toLowerCase();
    }

    function isViewable(filename) {
        return viewableTypes.includes(getFileExtension(filename));
    }

    // ==========================================================================
    // File Upload / Dropzone
    // ==========================================================================

    function updateFileDisplay(file) {
        if (file) {
            fileName.textContent = file.name;
            fileSize.textContent = formatSize(file.size);
            selectedFile.classList.add('show');
            uploadBtn.disabled = false;
        } else {
            selectedFile.classList.remove('show');
            uploadBtn.disabled = true;
        }
    }

    // Click on dropzone to open file dialog
    dropzone.addEventListener('click', () => {
        fileInput.click();
    });

    // File input change
    fileInput.addEventListener('change', (e) => {
        updateFileDisplay(e.target.files[0]);
    });

    // Remove selected file
    removeFile.addEventListener('click', (e) => {
        e.stopPropagation();
        fileInput.value = '';
        updateFileDisplay(null);
    });

    // Drag and drop events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.remove('dragover');
        });
    });

    // Handle dropped files
    dropzone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            updateFileDisplay(files[0]);
        }
    });

    // Prevent default drag behavior on window
    ['dragover', 'drop'].forEach(eventName => {
        window.addEventListener(eventName, (e) => {
            e.preventDefault();
        });
    });

    // ==========================================================================
    // Sidebar (mobile)
    // ==========================================================================

    function openSidebar() {
        sidebar.classList.add('open');
        sidebarOverlay.classList.add('visible');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        sidebarOverlay.classList.remove('visible');
        document.body.style.overflow = '';
    }

    sidebarToggle.addEventListener('click', openSidebar);
    sidebarClose.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);

    // ==========================================================================
    // File Modal
    // ==========================================================================

    function openFileModal(filePath) {
        const filename = filePath.split('/').pop();
        modalFileName.textContent = filename;
        modalOpen.href = filePath;
        modalDownload.href = filePath;
        modalDownload.download = filename;

        // Highlight recommended action based on file type
        if (isViewable(filename)) {
            modalOpen.classList.add('modal-btn-primary');
            modalDownload.classList.remove('modal-btn-primary');
        } else {
            modalDownload.classList.add('modal-btn-primary');
            modalOpen.classList.remove('modal-btn-primary');
        }

        fileModal.classList.add('visible');
        document.body.style.overflow = 'hidden';
    }

    function closeFileModal() {
        fileModal.classList.remove('visible');
        document.body.style.overflow = '';
    }

    // File item click handlers
    document.querySelectorAll('.file-item-link').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openFileModal(btn.dataset.file);
        });
    });

    modalClose.addEventListener('click', closeFileModal);
    fileModal.addEventListener('click', (e) => {
        if (e.target === fileModal) closeFileModal();
    });

    // Close modal after action
    modalOpen.addEventListener('click', () => setTimeout(closeFileModal, 100));
    modalDownload.addEventListener('click', () => setTimeout(closeFileModal, 100));

    // ESC key closes modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && fileModal.classList.contains('visible')) {
            closeFileModal();
        }
    });
})();