<div class="setting_dl_maintabs full_width">
    <div class="full_width">
        <h2>Personalization</h2>
        <div class="form-group uplosdfdfd">
            <label>Company Logo</label>
            <div class="upload_logo_UI">
                <a href="javascript:void(0);" class="upload-logo">
                    @if(isset($organization->logo_image) && ($organization->logo_image != NULL )) 
                        <img src="{{ $organization->logo_image }}" id="organization-logo-image" width="99%" height="97%" style="filter: none;">
                    @else
                        <img src="{{ asset('images/icon-upload.svg') }}" id="organization-logo-image"><span>Upload your own logo</span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>