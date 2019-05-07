
@foreach($permissions as $permission)
<div class="checkbox">
    <label>
      <input type="checkbox" value="{{$permission->id}}" id="permission"  name="permission[]"<?php if (in_array($permission->id, $datas)) {
			echo "checked";
			}?>>{{$permission->name}}
    </label>
</div>
@endforeach