<form action="{{ route('director.manager_task.update', $task->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="created_by" value="{{ $task->created_by }}">
    <label for="">assign to:</label>
    <select name="assigned_to" id="">
        <option value="" selected disabled>--assign to--</option>
        @foreach ($manager as $array)
            <option value="{{ $array->id }}" {{ $array->id == $task->assigned_to ? 'selected' : '' }}>{{ $array->username }}</option>
        @endforeach
    </select>
    <input type="text" name="title" id="" placeholder="title" value="{{ $task->title }}">
    <input type="text" name="description" id="" placeholder="description" value="{{ $task->description }}">
    <label for="">file:</label>
    <input type="file" name="attachment[]" id="" multiple>
    <label for="">due date:</label>
    <input type="date" name="due_date" id="" value="{{ $task->due_date }}">

    <button type="submit">save</button>
</form>
