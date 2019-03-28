@foreach($dataItems as $dataItem)
    @foreach($dataItem['parent'] as $item)
        {!! $item !!}
    @endforeach
@endforeach
