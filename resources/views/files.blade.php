@foreach($items as $item)
    {{$item->id}}
@endforeach
<div>
    {!! $items->links() !!}
</div>
