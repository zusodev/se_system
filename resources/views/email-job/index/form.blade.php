<div class="form-row">
    <div class="form-group col-md-4 ">
        <label for="name">Name</label>
        <input id="name" name="name" class="form-control"
               placeholder="name" value="{{ request("name") }}"
               maxlength="20">
    </div>
    <div class="form-group col-md-4 ">
        <label for="group">Group</label>
        <select id="group" name="group"
                class="form-control">
            <option value="">全選</option>
            <?php /* @var App\Models\TargetDepartment $group */ ?>
            @foreach($groups as $group)
                <option value="{{ $group->id }}"
                        @if(request("group_id")==$group->id) selected @endif>{{ $group->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<button type="submit" class="btn btn-primary">搜尋</button>


