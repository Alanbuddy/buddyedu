<table>

    <thead>
    <tr>
        <th>id</th>
        <th>path</th>
        <th>user_id</th>
        <th>student_id</th>
        <th>created_at</th>
        <th>del</th>
    </tr>
    </thead>
    @foreach($items as $item)
        <tr>
            <td> {{$item->id}} </td>
            <td> <a href=" {{$item->path}} ">{{$item->path}}</a></td>
            <td> {{$item->user_id}} </td>
            <td> {{$item->student_id}} </td>
            <td> {{$item->created_at}} </td>
            <td>
                <form method="post" action="{{route('files.destroy',$item->id)}}">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button type="submit">del</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
<div>
    {!! $items->links() !!}
</div>
