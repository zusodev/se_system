<div class="form-row">
    <div class="form-group col-md-4 ">
        <label for="name">name</label>
        <input id="name" name="name" class="form-control"
               placeholder="name" value="{{ request("name") }}"
               maxlength="20">
    </div>
    <div class="form-group offset-md-2 col-md-4 ">
        <label for="email">email</label>
        <input id="email" name="email" class="form-control"
               placeholder="email" value="{{ request("email") }}"
               maxlength="20">
    </div>
</div>
<button type="submit" class="btn btn-primary">搜尋</button>


