<form>
    <div class="form-group row">
        <label for="job_name" class="col-sm-3 col-form-label">目標統計排程：</label>
        <div class="col-sm-9">
            <select id="job_name" name="job_name" class="form-control">
                @php /* @var string[] $jobNames */ @endphp
                @foreach($jobNames as $jobName)
                    <option value="{{ $jobName }}"
                            @if(request("job_name") == $jobName) selected @endif>{{ $jobName }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="filter_groups" class="col-sm-3 col-form-label">過濾部門(不列出統計範圍)</label>
        <div class="col-sm-9">
            <select id="filter_groups" name="filter_groups[]" class="form-control" multiple>
                <option value="">
                    無
                </option>
                @php
                    /* @var App\Models\TargetDepartment[] $groups */
                    $filterGroups = is_array(request("filter_groups")) ? request("filter_groups") : [];
                @endphp
                @foreach($groups as $group)
                    <option value="{{ $group->id }}"
                            @if(in_array($group->id, $filterGroups)) selected @endif>{{ $group->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <button class="btn btn-primary">搜尋</button>
    </div>
</form>
