<div id="create-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route("users.store") }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">建立用戶</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">用戶名稱：</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="" value="{{ old("name") }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">電子郵件：</label>
                        <div class="col-sm-9">
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="" value="{{ old("email") }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">密碼：</label>
                        <div class="col-sm-9">
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"  placeholder="" value="{{ old("password") }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">確認密碼：</label>
                        <div class="col-sm-9">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">建立</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>






