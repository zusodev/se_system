<div id="search-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">搜尋用戶</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">用戶名稱：</label>
                        <div class="col-sm-9">
                            <input id="name" name="name" class="form-control" placeholder="name" value="{{ request("name") }}" maxlength="20">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">電子信箱：</label>
                        <div class="col-sm-9">
                            <input id="email" name="email" class="form-control"
                                   placeholder="email" value="{{ request("email") }}"
                                   maxlength="20">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">搜尋部門：</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="department_id" name="department_id">
                                <?php /* @var App\Models\TargetDepartment[] $departments */ ?>
                                <option value="" @if(!request("department_id")) selected @endif>
                                    全選
                                </option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}"
                                            @if(request("department_id") == $department->id) selected @endif>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">搜尋</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>
