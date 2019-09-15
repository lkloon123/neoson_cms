{!! PageContent::section('header') !!}

  <!-- Navigation -->
  {!! PageContent::menu('Main Menu') !!}

  <!-- Page Header -->
@if(PageContent::block('FeaturedImage', ['urlOnly' => true]))
  <header class="masthead" style="background-image: url('{{ PageContent::block('FeaturedImage', ['urlOnly' => true]) }}')">
@else
  <header class="masthead">
@endif
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>{{ PageContent::block('title') }}</h1>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        {!! PageContent::block('content') !!}
      </div>
      @if(PageContent::is(PageType::Homepage))
        {!! PageContent::block('tags') !!}
      @endif
    </div>
  </div>

  <hr>

{!! PageContent::section('footer') !!}
