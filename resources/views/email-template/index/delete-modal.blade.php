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
                    是否確認要刪除 @{{ itemName }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button class="btn btn-danger" @click="deleteItem()">刪除</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>
