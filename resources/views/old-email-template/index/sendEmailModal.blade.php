<div id="send-email-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="send-email-form" method="post" action="{{ route(send.mail", ["r_e_p_l_a_c_e__m_e"]) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        發送測試 Email
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" id="email" class="form-control" name="email" value=""
                                   maxlength="50">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">寄送</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>
