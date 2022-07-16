<div class="sidebar px-4 py-4 py-md-5 me-0">
  <div class="d-flex flex-column h-100">
    <a href="{{ route('crawling') }}" class="mb-0 brand-icon">
      <span class="logo-icon">
        <i class="fal fa-fork-knife fa-2xl"></i>
      </span>
      <span class="logo-text">Analisis Kuliner</span>
    </a>
    <ul class="menu-list flex-grow-1 mt-3">
      <li>
        <a class="m-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('crawling') }}">
          <i class="icofont-download"></i>
          <span>Crawling Data</span>
        </a>
      </li>
      <li>
        <a class="m-link {{ Request::is('preprocessing') ? 'active' : '' }}" href="{{ route('preprocessing') }}">
          <i class="icofont-gears"></i>
          <span>Pre-Processing</span>
        </a>
      </li>
      <li>
        <a class="m-link {{ Request::is('aaaaaaaaa') ? 'active' : '' }}" href="{{ route('crawling') }}">
          <i class="icofont-gear"></i>
          <span>Processing</span>
        </a>
      </li>
      <li>
        <a class="m-link {{ Request::is('aaaaaaaaa') ? 'active' : '' }}" href="{{ route('crawling') }}">
          <i class="icofont-paper"></i>
          <span>Validation</span>
        </a>
      </li>
    </ul>

    {{-- <ul class="list-unstyled mb-0">
      <li class="d-flex align-items-center justify-content-center">
        <div class="form-check form-switch theme-switch">
          <input class="form-check-input" type="checkbox" id="theme-switch">
          <label class="form-check-label" for="theme-switch">Enable Dark Mode!</label>
        </div>
      </li>
    </ul> --}}
    <button type="button" class="btn btn-link sidebar-mini-btn text-light">
      <span class="ms-2">
        <i class="icofont-bubble-right"></i>
      </span>
    </button>
  </div>
</div>