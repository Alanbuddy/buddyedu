<table>
    <thead>
    <tr>
        <td>id</td>
        <td>api</td>
        <td>time cost</td>
        <td>file</td>
        <td>time</td>
        <td>user id</td>
        <td>merchant id</td>
    </tr>
    </thead>
    @foreach($items as $item)
        <tr>
            <td>
                {{$item->id}}
            </td>
            <td>
                {{$item->api}}
            </td>
            <td>
                {{$item->time_cost}}
            </td>
            <td>
               <img style="width:100px;height:100px" src=" {{$item->file}}">
            </td>
            <td>
                {{$item->created_at}}
            </td>
            <td>
                {{$item->user_id}}
            </td>
            <td>
                {{$item->merchant_id}}
            </td>
            <td>
                {{substr($item->result,0,10)}}
            </td>
        </tr>
    @endforeach
</table>
