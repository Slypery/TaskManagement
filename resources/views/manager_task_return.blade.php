{{-- @php
    dd($manager_task_return)
@endphp --}}
<table border="1">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Attachment</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($manager_task_return as $item)
            <tr>
                <td>{{ $item->mtask->title }}</td>
                <td>{{ $item->description }}</td>
                <td>
                    @foreach ($item->attachment as $array)
                        {{ $array }}
                    @endforeach
                </td>
                <td>{{ $item->return_date }}</td>
                <td>{{ $item->mtask->status }}</td>
                <td>
                    <form action="{{ route('director.manager_task_return.destroy', $item->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: red">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>