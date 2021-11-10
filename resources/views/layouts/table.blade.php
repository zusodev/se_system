<?php /* @var Illuminate\Contracts\Pagination\LengthAwarePaginator|Illuminate\Pagination\AbstractPaginator $paginator */
    /**
     * int $emptyColspan
     * string $title HTML
     * string $row HTML
     */
?>
@include("layouts.table-header", ["isHeader" => true])
<hr>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr style="font-size: .875rem !important;">
            {{ $trTitles }}
        </tr>
        </thead>
        <tbody>
        @if($paginator->count())
            {{ $slot }}
        @else
            @include("layouts.table-empty-row")
        @endif

        </tbody>
        @if(empty($hidden_footer))
            <tfoot>
            <tr style="font-size: .875rem !important;">
                {{ $trTitles }}
            </tr>
            </tfoot>
        @endif
    </table>
</div>
<hr>
@include("layouts.table-header")


