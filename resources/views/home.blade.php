@extends('master')
@section('content')
<div id="main" class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-3" id="left-sidebar">
                <div class="clear-fix"></div>
                <div class="avatar">
                    <img src="{{ $user->avatar }}" alt="">
                    <h3 class="my-name">{{ $user->name }}</h3>
                </div>
                <div class="follow-section">
                    <h4>Số người đang follow: <span class="follow-section-txt-following">{{ $user->total_following }}</span></h4>
                    <br/>
                    <h4>Số người follow: <span class="follow-section-txt-follower">{{ $user->total_followers }}</span></h4>
                    <br>
                    <h4>Số lượng video: <span class="follow-section-txt-videos">{{ $user->total_video }}</span></h4>
                </div>
                <div class="btn-logout">
                    <a href="{{ url('/logout') }}" class="btn btn-danger">Đăng xuất</a>
                </div>
            </div>
            <!-- Begin content & Chat -->
            <div id="app"></div>
            <!-- End content & Chat -->
        </div>
    </div>
</div>
<!-- Modal upload video -->
<div class="modal fade" id="upload-videos-modal" tabindex="-1" role="dialog" aria-labelledby="upload-videos-modal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="upload">Đăng tải video</h5>
            </div>
            <div class="modal-body">
                <label class="btn btn-danger" for="choose-video">Chọn video</label>
                <input type="file" accept=".mp4" value="" id="choose-video" class="hidden">
                <p id="txt-name-video">Videoname.mp4</p>
                <textarea name="caption" maxlength="255" class="form-control" id=""></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger">Đăng tải</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal report -->
<div class="modal fade" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="report-modal">Báo cáo vi phạm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="report-content">Nội dung báo cáo (<span class="text-danger">*</span>) </label>
                <textarea name="report" class="form-control" id="report-content"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger">Gửi báo cáo</button>
            </div>
        </div>
    </div>
</div>

@vite('resources/js/app.js')
@endsection