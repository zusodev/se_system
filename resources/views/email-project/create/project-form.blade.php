@csrf
<div class="form-group row">
    <label for="name" class="col-sm-4">* 專案名稱</label>
    <div class="col-sm-8">
        <input id="name" name="name"
               class="form-control @error('name') is-invalid @enderror"
               placeholder="" value="{{ old("name") }}"
               maxlength="50" required>
        @error('name')

        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group row">
    <label for="description" class="col-sm-4">專案描述</label>
    <div class="col-sm-8">
        <textarea class="form-control @error('description') is-invalid @enderror"
                  id="description" name="description"
                  rows="3" maxlength="50">{{ old("description") }}</textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<?php
        /* @var App\Models\EmailTemplate[]|Illuminate\Support\Collection $emailTemplates */
?>
<div class="form-group row">
    <label for="email_template_id" class="col-sm-4">* 信件樣式</label>
    <div class="col-sm-8">
        <select id="email_template_id" name="email_template_id"
                class="form-control @error('email_template_id') is-invalid @enderror">
            @if($emailTemplates->count() == 0)
            <option value="0">At least create one template</option>
            @endif
            @foreach($emailTemplates as $emailTemplate)
                <option value="{{ $emailTemplate->id }}"
                        @if(old("email_template_id") == $emailTemplate->id) selected @endif>
                    {{ $emailTemplate->name }}
                </option>
            @endforeach
        </select>
        @error('email_template_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="groups" class="col-sm-4">* 寄送部門</label>
    <div class="col-sm-8">
        <select id="groups" name="groups[]"
                class="form-control @error('groups') is-invalid @enderror"
            multiple>
            <option @if(!old("groups")) selected @endif value="">全選</option>
            <?php
                $isArray = is_array(old("groups"));
            ?>
            @foreach($groups as $group)
                <?php
                    $isSelected = $isArray;
                    if($isSelected){
                        $isSelected = $isSelected && in_array($group->id, old("groups"));
                    }
                ?>
                <option @if($isSelected) selected @endif value="{{ $group->id }}">
                    {{ $group->name }} (人數：{{ $group->user_count }})
                </option>
            @endforeach
        </select>
        @error('group')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
