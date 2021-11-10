<ul class="nav nav-pills">
    @if(!empty($indexUrl))
        <li class="nav-item">
            <a onclick="location.href=`{{ $indexUrl }}`" href="#"
               class="nav-link @if($isIn == "index") active @endif"
               aria-controls="profile-pills" data-toggle="tab" role="tab">
                <em class="fa fa-search"></em> 搜尋頁面
            </a>
        </li>
    @endif
    @if(!empty($createUrl))
        <li class="nav-item">
            <a onclick="location.href=`{{ $createUrl }}`" href="#"
               class="nav-link @if($isIn == "create") active @endif"
               aria-controls="home-pills" data-toggle="tab" role="tab">
                <em class="fa fa-plus"></em> 新增頁面
            </a>
        </li>
    @endif
    @if(!empty($showUrl))
        <li class="nav-item">
            <a onclick="location.href=`{{ $showUrl }}`" href="#" class="nav-link @if($isIn == "show") active @endif"
               aria-controls="home-pills" data-toggle="tab" role="tab">
                <em class="fa fa-file-text-o"></em> 詳細資料頁面
            </a>
        </li>
    @endif
    @if(!empty($editUrl))
        <li class="nav-item">
            <a onclick="location.href=`{{ $editUrl }}`" href="#" class="nav-link @if($isIn == "edit") active @endif"
               aria-controls="home-pills" data-toggle="tab" role="tab">
                <em class="fa fa-edit"></em> 編輯頁面
            </a>
        </li>
    @endif
</ul>
