@if($meta['type'] === 'language')
    <li class="nav-item dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img
                class="custom-flag-icon"
                src="/images/flags/{!! $title !!}.svg"
                alt="locale"
            /> <b class="caret" data-toggle="dropdown"></b>
        </a>
        <ul class="dropdown-menu">
            @foreach($languages as $language)
                <li class="nav-item">
                    <form id="{{ $language->code }}" action="/api/locale/{{ $language->code }}" method="POST">
                        @csrf
                        @method('PUT')
                        <a class="nav-link" href="#" onclick="languageSubmit('{{ $language->code }}')">
                            {{ $language->title }}
                        </a>
                    </form>
                </li>
            @endforeach
        </ul>
    </li>
@else
    <li class="nav-item">
        <a class="nav-link" href="{{ $url }}">{{ $title }}</a>
    </li>
@endif
