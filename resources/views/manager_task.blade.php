<table border="1">
    <thead>
        <tr>
            <th>Title</th>
            <th>Created By</th>
            <th>Assigned To</th>
            <th>Description</th>
            <th>Attachment</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($manager_task as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->created_user->username }}</td>
                <td>{{ $item->assigned_user->username }}</td>
                <td>{{ $item->description }}</td>
                <td>
                    @foreach ($item->attachment as $array)
                        {{ $array }}
                    @endforeach
                </td>
                <td>{{ $item->due_date }}</td>
                <td>{{ $item->status }}</td>
                <td>
                    <a href="{{ route('director.manager_task.edit', $item->id) }}" style="color: yellow">Edit</a>
                    <form action="{{ route('director.manager_task.destroy', $item->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: red">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<button style="background-color: red"><a href="{{ route('director.manager_task.create') }}">Add</a></button>
