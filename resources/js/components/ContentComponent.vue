<template>
    <div class="col-md-6" id="content">
        <div class="row">
            <div class="clear-fix"></div>
            <div class="col-md-12 poster-information">
                <p class="poster-name">Người nổi tiếng</p>
                <span class="txt-follow">Theo dõi</span>
                <i class="fa fa-heart-circle-plus text-danger" id="icon-like"></i>
                <a href="#" data-toggle="modal" data-target="#report-modal">
                    <img src="../../../public/assets/images/ic_report.png" width="18px" height="18px" alt="" id="icon-report">
                </a>
            </div>
            <div class="col-md-12" id="video-section">
                <div class="show-video" id="show-video">
                    <iframe src="https://drive.google.com/file/d/1ef2x-XxwAtV9EBotpFguoOJoRdjhPHvk/preview" allow="autoplay"></iframe>
                    <p id="video-caption">Lorem ipsum dolor sit amet consectetur adipisicing elit. Est sit quas quae voluptatibus, ea ex.</p>
                </div>
                <div class="col-md-12" id="btn-control">
                    <button class="btn btn-danger">
                        &#60;
                    </button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#upload-videos-modal"> <strong>+</strong> </button>
                    <button class="btn btn-danger">
                        &#62;
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>