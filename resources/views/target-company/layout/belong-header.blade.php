@php /** @var App\Models\TargetCompany $company */ @endphp

<div class="d-flex justify-content-between bd-highlight">
    <p class="p-2">
        {{ $slot }}
    </p>
    <div class="p-2">
        <p>
            @if($company)
                目前為 ：<span class="badge badge-pill badge-primary"
                           style="font-size: 0.8rem">
                {{ $company->name }}  </span> 公司所屬部門
            @endif
            @if(!empty($department) && $department)
                <span class="badge badge-pill badge-primary" style="font-size: 0.8rem">
                    {{ $department->name }}
                </span>
            @endif
        </p>
    </div>
</div>
