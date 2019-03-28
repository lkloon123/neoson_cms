{!! PageContent::layout('header') !!}

  <!-- Navigation -->
  {!! PageContent::menu('Main Menu') !!}

  <!-- Page Header -->
  <header class="masthead" style="background-image: url('img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>Clean Blog</h1>
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
    </div>
  </div>

  <hr>

{!! PageContent::layout('footer') !!}
