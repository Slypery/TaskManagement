<form action="{{ route('director.manager_task.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="created_by" value="1">
    <label for="">assign to:</label>
    <select name="assigned_to" id="">
        <option value="" selected disabled>--assign to--</option>
        @foreach($manager as $array)
        <option value="{{ $array->id }}">{{ $array->username }}</option>
        @endforeach
    </select>
    <input type="text" name="title" id="" placeholder="title">
    <input type="text" name="description" id="" placeholder="description">
    <label for="">file:</label>
    <input type="file" name="attachment[]" id="" multiple>
    <label for="">due date:</label>
    <input type="date" name="due_date" id="">

    <button type="submit">save</button>
</form>