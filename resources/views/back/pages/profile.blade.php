@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle)? $pageTitle:'pageTitle Here')
    
@section('content')
    
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Profile</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Profile
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@livewire('admin.profile')
@endsection

@push('scripts')
<script>
    $('input[type="file"][id="profilePictureFile"]').kropify({
        preview: 'img#profilePicturePreview', // Correct preview selector
        viewMode: 1,
        aspectRatio: 1, // 1:1 for square crop
        cancelButtonText: 'Cancel',
        resetButtonText: 'Reset',
        cropButtonText: 'Crop & update',
        processURL: '{{route('admin.update_profile_picture')}}', // Replace with your API endpoint
        maxSize: 2097152, // 2MB file size limit
        showLoader: true,
        animationClass: 'headShake', // Animation effect
        fileName: 'avatar',
        success: function (data) {
            if(data.status==1){
                $().notifa({
                    vers:2,
                    cssClass:'success',
                    html:data.message,
                    delay:2500,
                    
                });
            }else{
                $().notifa({
                    vers:2,
                    cssClass:'error',
                    html:data.message,
                    delay:2500,
                    
                });
            }
        },
        errors: function (error, text) {
            console.log('Error:', text);
        },
    });
</script>

@endpush