<div class="row">
  <div class="col-12">
    <div class="card mb-4 shadow-sm">
      <h5 class="card-header text-white bg-primary text-center">Pre Processing</h5>
      <nav>
        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
          <button class="nav-link fw-bold active" data-bs-toggle="tab" data-bs-target="#tab-1" type="button">Case Folding</button>
          <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-2" type="button">Tokenizing</button>
          <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-3" type="button">Filteringg</button>
          <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-4" type="button">Stemming</button>
        </div>
      </nav>
      <div class="card-body">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="tab-1">
            <table class="table table-hover align-middle text-center" id="caseFolding">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Waktu</th>
                  <th>Nama</th>
                  <th>Restaurant</th>
                  <th>Ulasan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($case_folding as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td class="text-nowrap">{{ $item['date'] }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['restaurant'] }}</td>
                    <td class="text-start">{{ $item['review'] }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="tab-2">
            <table class="table table-hover align-middle text-center" id="tokenizing">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Waktu</th>
                  <th>Nama</th>
                  <th>Restaurant</th>
                  <th>Ulasan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tokenizing as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td class="text-nowrap">{{ $item['date'] }}</td>
                    <td>{{ $item['name'] }}</td>
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
          <div class="tab-pane fade" id="tab-3">
            <table class="table table-hover align-middle text-center" id="filtering">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Waktu</th>
                  <th>Nama</th>
                  <th>Restaurant</th>
                  <th>Ulasan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($filtering as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td class="text-nowrap">{{ $item['date'] }}</td>
                    <td>{{ $item['name'] }}</td>
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
          <div class="tab-pane fade" id="tab-4">
            <table class="table table-hover align-middle text-center" id="stemming">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Waktu</th>
                  <th>Nama</th>
                  <th>Restaurant</th>
                  <th>Ulasan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($stemming as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td class="text-nowrap">{{ $item['date'] }}</td>
                    <td>{{ $item['name'] }}</td>
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
  </div>
</div>