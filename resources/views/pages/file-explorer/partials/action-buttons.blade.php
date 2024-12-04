<div class="relative">
    <form id="file-upload-form" hx-post="{{ route('telegram.upload.file') }}" hx-target="#upload-progress" enctype="multipart/form-data">
        <input type="file" name="files[]" multiple class="file-input" />
        <button type="submit" class="upload-button">Upload</button>
    </form>
    <div id="upload-progress" class="progress-bar"></div>
</div>
