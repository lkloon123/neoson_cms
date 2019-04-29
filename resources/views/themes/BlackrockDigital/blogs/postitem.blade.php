<div class="post-preview">
    <a href="{{ $url }}">
        <h2 class="post-title">
            {{ $title }}
        </h2>
        <h3 class="post-subtitle">
            {{ $description }}
        </h3>
    </a>
    <p class="post-meta">Posted by
        <a href="#">{{ $author }}</a>
        on {{ $posted_at->format('F j, Y g:ia') }}</p>
</div>
<hr/>
