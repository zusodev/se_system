<div id="detail-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="detail-name" class="modal-title">
                    名稱：
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>開啟信件時間</td>
                        <td id="open_datetime"></td>
                    </tr>
                    <tr>
                        <td>開啟信件IP</td>
                        <td id="open_ip"></td>
                    </tr>
                    <tr>
                        <td>開啟信件Agent</td>
                        <td id="open_agent"></td>
                    </tr>

                    <tr>
                        <td>點擊連結時間</td>
                        <td id="open_link_datetime"></td>
                    </tr>
                    <tr>
                        <td>點擊連結IP</td>
                        <td id="open_link_ip"></td>
                    </tr>
                    <tr>
                        <td>點擊連結Agent</td>
                        <td id="open_link_agent"></td>
                    </tr>

                    <tr>
                        <td>開啟附件時間</td>
                        <td id="open_attachment_datetime"></td>
                    </tr>
                    <tr>
                        <td>開啟附件IP</td>
                        <td id="open_attachment_ip"></td>
                    </tr>
                    <tr>
                        <td>開啟附件Agent</td>
                        <td id="open_attachment_agent"></td>
                    </tr>
                </table>
            </div>
            <button onclick="cancelModal()" class="btn btn-secondary">取消</button>
        </div>
    </div>
</div>
