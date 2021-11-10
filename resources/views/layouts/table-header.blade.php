<div class="d-flex justify-content-between bd-highlight">
    @isset($isHeader)
        <div class="p-2 ">
            總計：
            <span class="badge badge-primary badge-pill m-1" style="font-size: 0.8rem !important;">
                {{ $paginator->total() }}
            </span>
            筆資料
            @if($paginator->isNotEmpty())
                ，每頁顯示 <span class="badge badge-primary badge-pill m-1 " style="font-size: 0.8rem !important;">
                {{ $paginator->perPage() }}
            </span>筆資料
            @endif
        </div>

        <div>
            {{ $paginator->links() }}
        </div>
    @else
        @if($paginator->count() > 5)
            <div>
                {{ $paginator->links() }}
            </div>

            <div class="p-2 ">
                總計：
                <span class="badge badge-primary badge-pill m-1" style="font-size: 0.8rem !important;">
                {{ $paginator->total() }}
            </span>
                筆資料
                @if($paginator->isNotEmpty())
                    ，每頁顯示 <span class="badge badge-primary badge-pill m-1 " style="font-size: 0.8rem !important;">
                {{ $paginator->perPage() }}
            </span>筆資料
                @endif
            </div>
        @endif
    @endisset
</div>
