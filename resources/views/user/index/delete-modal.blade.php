<div id="delete-modal" class="modal" tabindex="-1" role="dialog">
    <form id="delete-form" method="post" style="display: none">
        @csrf
        @method("DELETE")
        <input type="text" id="id" name="id">
    </form>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    警告！
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                您確定要刪除管理者「 @{{ itemName }}」?
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" @click="deleteUser()">刪除</button>
                <button class="btn btn-secondary" @click="cancelUser()">取消</button>
            </div>
        </div>
    </div>
</div>
