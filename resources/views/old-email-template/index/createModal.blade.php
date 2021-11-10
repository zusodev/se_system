<div id="create-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="create-form" method="post" action="{{ route("email_templates.store") }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        新增電子郵件樣式
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="create-name" class="col-sm-3 col-form-label">樣式名稱</label>
                        <div class="col-sm-9">
                            <input type="text" id="create-name" class="form-control" name="name" value=""
                                   maxlength="50" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">新增</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>
