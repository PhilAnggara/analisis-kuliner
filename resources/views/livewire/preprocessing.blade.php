<div>

  @if (!$success)
      
    <div class="row">
      <div class="col-12">
        <div class="card text-center py-5 mb-4 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Lanjutkan <strong><em>preprocessing</em></strong></h5>
            <p class="card-text">Pada <strong><em>preprocessing</em></strong> akan dilakukan tahapan-tahapan yang terdiri dari case folding, tokenizing, filtering dan stemming.</p>
            <button wire:click="process" class="btn btn-primary" type="button">
              <i class="fa-solid fa-play"></i>
              Lanjutkan
            </button>
          </div>
        </div>
      </div>
    </div>

  @else

    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Case Folding</h5>
          <div class="card-body">
            <table class="table table-hover align-middle text-center" id="caseFolding">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Rating</th>
                  <th>Restaurant</th>
                  <th>Ulasan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($case_folding as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $item['name'] }}</td>
                    <td>
                      <i class="fa-solid fa-star text-warning"></i>
                      {{ $item['rating'] }}
                    </td>
                    <td>{{ $item['restaurant'] }}</td>
                    <td class="text-start">{{ $item['review'] }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Tokenizing</h5>
          <div class="card-body">
            <table class="table table-hover align-middle text-center" id="tokenizing">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Rating</th>
                  <th>Restaurant</th>
                  <th>Ulasan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tokenizing as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $item['name'] }}</td>
                    <td>
                      <i class="fa-solid fa-star text-warning"></i>
                      {{ $item['rating'] }}
                    </td>
                    <td>{{ $item['restaurant'] }}</td>
                    <td class="text-start">
                      @foreach ($item['review'] as $ir)
                        @if ($loop->first)
                          ['{{ $ir }}',
                        @elseif ($loop->last)
                          '{{ $ir }}']
                        @else
                          '{{ $ir }}',
                        @endif
                      @endforeach
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Filtering</h5>
          <div class="card-body">
            <table class="table table-hover align-middle text-center" id="filtering">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Rating</th>
                  <th>Restaurant</th>
                  <th>Ulasan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($filtering as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $item['name'] }}</td>
                    <td>
                      <i class="fa-solid fa-star text-warning"></i>
                      {{ $item['rating'] }}
                    </td>
                    <td>{{ $item['restaurant'] }}</td>
                    <td class="text-start">
                      @foreach ($item['review'] as $ir)
                        @if ($loop->first)
                          ['{{ $ir }}',
                        @elseif ($loop->last)
                          '{{ $ir }}']
                        @else
                          '{{ $ir }}',
                        @endif
                      @endforeach
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Stemming</h5>
          <div class="card-body">
            <table class="table table-hover align-middle text-center" id="stemming">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Rating</th>
                  <th>Restaurant</th>
                  <th>Ulasan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($stemming as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $item['name'] }}</td>
                    <td>
                      <i class="fa-solid fa-star text-warning"></i>
                      {{ $item['rating'] }}
                    </td>
                    <td>{{ $item['restaurant'] }}</td>
                    <td class="text-start">
                      @foreach ($item['review'] as $ir)
                        @if ($loop->first)
                          ['{{ $ir }}',
                        @elseif ($loop->last)
                          '{{ $ir }}']
                        @else
                          '{{ $ir }}',
                        @endif
                      @endforeach
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
  @endif

  <div wire:loading>
    <div class="load-awesome">
      <div class="la-ball-atom la-3x">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>
    </div>
  </div>

  
  {{-- <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm">
        <div class="card-body">

          <nav>
            <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
              <button class="nav-link active" id="Case-folding-tab" data-bs-toggle="tab" data-bs-target="#Case-folding" type="button">
                Case Folding
              </button>
              <button class="nav-link" id="Tokenizing-tab" data-bs-toggle="tab" data-bs-target="#Tokenizing" type="button">
                Tokenizing
              </button>
              <button class="nav-link" id="Filtering-tab" data-bs-toggle="tab" data-bs-target="#Filtering" type="button">
                Filtering
              </button>
              <button class="nav-link" id="Stemming-tab" data-bs-toggle="tab" data-bs-target="#Stemming" type="button">
                Stemming
              </button>
            </div>
          </nav>

          <div class="tab-content mt-4" id="nav-tabContent">
            <div class="tab-pane fade show active" id="Case-folding">
              ini satu
            </div>
            <div class="tab-pane fade" id="Tokenizing">
              ini dua
            </div>
            <div class="tab-pane fade" id="Filtering">
              ini tiga
            </div>
            <div class="tab-pane fade" id="Stemming">
              ini empat
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div> --}}


  <script>
    $(document).ready(function() {
      $('#caseFolding').DataTable(tableConfiguration);
      $('#tokenizing').DataTable(tableConfiguration);
      $('#filtering').DataTable(tableConfiguration);
      $('#stemming').DataTable(tableConfiguration);
    });
  </script>

</div>