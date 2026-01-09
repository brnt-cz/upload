<div class="card">
    <form enctype="multipart/form-data" id="uploadForm" action="" method="post">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= MAX_FILE_SIZE ?>">
        <input type="hidden" name="upload" value="1">

        <div class="dropzone" id="dropzone">
            <input type="file" name="file" id="fileInput">
            <div class="dropzone-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
            </div>
            <p class="dropzone-text"><?= t('dropzone_text') ?></p>
            <p class="dropzone-hint"><?= t('dropzone_hint', (int) round(MAX_FILE_SIZE / 1024 / 1024)) ?></p>
        </div>

        <div class="selected-file" id="selectedFile">
            <div class="selected-file-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <div class="selected-file-info">
                <div class="selected-file-name" id="fileName"></div>
                <div class="selected-file-size" id="fileSize"></div>
            </div>
            <button type="button" class="selected-file-remove" id="removeFile" title="<?= t('remove_file') ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <div class="upload-actions">
            <button type="submit" class="btn btn-primary" id="uploadBtn" disabled>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                <?= t('upload_btn') ?>
            </button>
        </div>
    </form>
</div>
