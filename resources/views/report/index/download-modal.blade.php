<div id="download-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    選擇下載資料類型
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Word：</h6>
                <div class="form-group row">
                    <button type="button" class="m-1 btn btn-outline-info"
                            onclick="startDownload('word')">Word 報告書
                    </button>
                </div>
                <hr>
                <h6>CSV：</h6>
                <div class="form-group row">
                    <button type="button" class="m-1 btn btn-outline-warning"
                            onclick="startDownload('open_mail_users_csv')">開啟信件名單
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>
