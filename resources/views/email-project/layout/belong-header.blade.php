@php /** @var App\Models\EmailProject $project */ @endphp

<div class="d-flex justify-content-between bd-highlight">
    {{ $slot }}
    <div class="p-2">
        @if($project)
            <p>
                寄件專案： <span class="badge badge-pill badge-primary"
                            style="font-size: 0.8rem">{{ $project->name }}  </span>
                所屬公司：<span class="badge badge-pill badge-primary"
                           style="font-size: 0.8rem">{{ $project->company->name }}  </span>
            </p>
        @endif
    </div>
</div>
