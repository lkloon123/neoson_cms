<span class="post-meta small text-muted">
    <span class="mr-3"><i class="fas fa-user-edit"></i> {{ $author }}</span>
    <span class="mr-3"><i class="far fa-calendar-alt"></i> {{ $posted_on->format('F j, Y') }}</span>
    <span class="mr-3">
        <i class="fas fa-tag"></i>
        @foreach($tags as $tag)
            <a href="{{ $tag->link }}" class="text-muted post-tag-item"> {{ $tag->name }}</a>{{$loop->last ? '' : ','}}
        @endforeach
    </span>
</span>

{!! $content !!}
