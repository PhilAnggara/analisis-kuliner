<div class="sidebar px-4 py-4 py-md-5 me-0">
  <div class="d-flex flex-column h-100">
    <a href="{{ route('data-training') }}" class="mb-0 brand-icon">
      <span class="logo-icon">
        <i class="fal fa-fork-knife fa-2xl"></i>
      </span>
      <span class="logo-text text-center">Analisis Sentimen Restoran</span>
    </a>
    <ul class="menu-list flex-grow-1 mt-3">

      <li>
        <a class="m-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('data-training') }}">
          <i class="icofont-binary"></i>
          <span>Data Training</span>
        </a>
      </li>
      <li class="collapsed">
        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menuTesting" href="#">
          <i class="icofont-beaker"></i>
          <span>Data Testing</span>
          <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
        </a>
        <ul class="sub-menu collapse show" id="menuTesting">
          <li class="collapsed">
            <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menuSingle" href="#">
              <i class="icofont-page"></i>
              <span>Single</span>
              <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
            </a>
            <ul class="sub-menu collapse {{ Request::is('single*') ? 'show' : '' }}" id="menuSingle">
              <li><a class="ms-link {{ Request::is('single/manual') ? 'active' : '' }}" href="{{ route('manual') }}"><span>Manual</span></a></li>
              <li><a class="ms-link {{ Request::is('single/otomatis') ? 'active' : '' }}" href="{{ route('otomatis') }}"><span>Otomatis</span></a></li>
            </ul>
          </li>
          <li>
            <a class="m-link {{ Request::is('multiple') ? 'active' : '' }}" href="{{ route('multiple') }}">
              <i class="icofont-papers"></i>
              <span>Multiple</span>
            </a>
          </li>
        </ul>
      </li>

    </ul>

    {{-- <ul class="list-unstyled mb-0">
      <li class="d-flex align-items-center justify-content-center">
        <div class="form-check form-switch theme-switch">
          <input class="form-check-input" type="checkbox" id="theme-switch">
          <label class="form-check-label" for="theme-switch">Enable Dark Mode!</label>
        </div>
      </li>
    </ul>
    <button type="button" class="btn btn-link sidebar-mini-btn text-light">
      <span class="ms-2">
        <i class="icofont-bubble-right"></i>
      </span>
    </button> --}}
  </div>
</div>