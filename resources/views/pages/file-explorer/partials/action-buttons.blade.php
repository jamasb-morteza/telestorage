<div class="relative" x-data="{ showUploadBox: false }">
    <button @click="showUploadBox = true" class="upload-button">Upload Files</button>
    <div x-show="showUploadBox" @click.away="showUploadBox = false">
        <form id="file-upload-form" hx-post="{{ route('telegram.upload.file') }}" hx-target="#upload-progress" enctype="multipart/form-data">
            <input type="file" name="files[]" multiple class="file-input" />
            <button type="submit" class="upload-button">Submit</button>
        </form>
        <div id="upload-progress" class="progress-bar"></div>
    </div>
</div>
