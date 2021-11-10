<div id="set-attachment-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="create-form" method="post" >
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        設置 EXE 附件
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-9 col-sm-12">
                            <label for="create-name" class="col-sm-3 col-form-label">EXE 檔案名稱</label>
                            <div class="col-sm-9">
                                <input type="text" id="modal_file_name" class="form-control" name="modal_file_name" value=""
                                       maxlength="35" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="submitAttachmentModal()">儲存</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>
