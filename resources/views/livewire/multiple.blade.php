<div>

  @if (!$success)

    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <div class="card-body">

            <form wire:submit.prevent="process">
              <div class="input-group">
                <select wire:model="selectedCategory" class="form-select bg-transparent" required>
                  <option value="" selected disabled>-- Pilih kategori --</option>
                  @foreach ($categories as $category)
                    <option>{{ $category->name }}</option>
                  @endforeach
                </select>
                <select wire:model="partisi" class="form-select bg-transparent" required>
                  <option value="" selected disabled>-- Data Partisi --</option>
                  <option value="90">90% data training, 10% data testing</option>
                  <option value="80">80% data training, 20% data testing</option>
                  <option value="70">70% data training, 30% data testing</option>
                  <option value="60">60% data training, 40% data testing</option>
                  <option value="50">50% data training, 50% data testing</option>
                </select>
                <button class="btn btn-outline-primary" type="submit">
                  <i class="fa-solid fa-play"></i>
                  Proses
                </button>
              </div>   
            </form>   

          </div>
        </div>
      </div>
    </div>

  @else

    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Reviews</h5>
          <div class="card-body">
            <table class="table table-hover align-middle text-center" id="reviews">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Waktu</th>
                  <th>Nama</th>
                  <th>Restaurant</th>
                  <th>Ulasan</th>
                  <th>Label</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($reviews as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td class="text-nowrap">{{ $item['date'] }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['restaurant'] }}</td>
                    <td class="text-start">{{ $item['review'] }}</td>
                    <td>
                      @if ($item['rating'] > 4)
                        <span class="badge rounded-pill bg-success">Positif</span>
                      @elseif ($item['rating'] == 4)
                        <span class="badge rounded-pill bg-light text-dark">Netral</span>
                      @else
                        <span class="badge rounded-pill bg-danger">Negatif</span>
                      @endif
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
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Term Frequency</h5>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle text-center" id="termFrequency">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Kata / Term</th>
                    @foreach ($stemming as $item)
                      <th>D{{ $loop->iteration }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  @foreach ($termFrequency as $tf)
                    <tr>
                      <th>{{ $loop->iteration }}</th>
                      <td>{{ $tf['kata'] }}</td>
                      @foreach ($tf['data'] as $i)
                        <td>{{ $i }}</td>
                      @endforeach
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Inverse Document Frequency</h5>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle text-center" id="inverseDocumentFrequency">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Kata / Term</th>
                    <th>Nilai DF</th>
                    <th>Nilai IDF</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($inverseDocumentFrequency as $idf)
                    <tr>
                      <th>{{ $loop->iteration }}</th>
                      <td>{{ $idf['kata'] }}</td>
                      <td>{{ $idf['df'] }}</td>
                      <td>{{ number_format($idf['idf'], 5, '.', '') }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">TF-IDF</h5>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle text-center" id="tfidf">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Kata / Term</th>
                    @foreach ($stemming as $item)
                      <th>D{{ $loop->iteration }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  @foreach ($tfidf as $item)
                    <tr>
                      <th>{{ $loop->iteration }}</th>
                      <td>{{ $item['kata'] }}</td>
                      @foreach ($item['data'] as $i)
                        @if ($i == 0)
                          <td>0</td>
                        @else
                          <td>{{ number_format($i, 5, '.', '') }}</td>
                        @endif
                      @endforeach
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Kernel</h5>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle text-center" id="kernel">
                <thead>
                  <tr>
                    <th></th>
                    @foreach ($kernel as $item)
                      <th>D{{ $loop->iteration }}</th>
                    @endforeach
                    <th>Kelas</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($kernel as $item)
                    <tr>
                      <th>D{{ $loop->iteration }}</th>
                      @foreach ($item['data'] as $i)
                        @if ($i == 0)
                          <td>0</td>
                        @else
                          <td>{{ number_format($i, 5, '.', '') }}</td>
                        @endif
                      @endforeach
                      <th>{{ $item['kelas'] }}</th>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Kelas</th>
                    @foreach ($kernel as $item)
                      <th>{{ $item['kelas'] }}</th>
                    @endforeach
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Hessian Matrix</h5>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle text-center" id="hessian">
                <thead>
                  <tr>
                    <th></th>
                    @foreach ($hessian as $item)
                      <th>D{{ $loop->iteration }}</th>
                    @endforeach
                    <th>Kelas</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($hessian as $item)
                    <tr>
                      <th>D{{ $loop->iteration }}</th>
                      @foreach ($item['data'] as $i)
                        @if ($i == 0)
                          <td>0</td>
                        @else
                          <td>{{ number_format($i, 5, '.', '') }}</td>
                        @endif
                      @endforeach
                      <th>{{ $item['kelas'] }}</th>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Kelas</th>
                    @foreach ($hessian as $item)
                      <th>{{ $item['kelas'] }}</th>
                    @endforeach
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Nilai Eror</h5>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle text-center" id="eror">
                <thead>
                  <tr>
                    <th></th>
                    <th>Nilai Eror</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($error as $item)
                    <tr>
                      <th>D{{ $loop->iteration }}</th>
                      <td>{{ number_format($item, 5, '.', '') }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th>Nilai Eror</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Delta</h5>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle text-center" id="delta">
                <thead>
                  <tr>
                    <th></th>
                    <th>Delta</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($delta as $item)
                    <tr>
                      <th>D{{ $loop->iteration }}</th>
                      <td>{{ number_format($item, 5, '.', '') }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th>Delta</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Alpha</h5>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle text-center" id="alpha">
                <thead>
                  <tr>
                    <th></th>
                    <th>Alpha</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($alpha as $item)
                    <tr>
                      <th>D{{ $loop->iteration }}</th>
                      <td>{{ number_format($item, 5, '.', '') }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th>Alpha</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Klasifikasi</h5>
          <div class="card-body">
            <table class="table table-hover align-middle text-center" id="clasification">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Waktu</th>
                  <th>Nama</th>
                  <th>Restaurant</th>
                  <th>Ulasan</th>
                  <th>Aktual</th>
                  <th>Sistem</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($dataTesting as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td class="text-nowrap">{{ $item['date'] }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['restaurant'] }}</td>
                    <td class="text-start">{{ $item['review'] }}</td>
                    <td>
                      @if ($item['rating'] > 4)
                        <span class="badge rounded-pill bg-success">Positif</span>
                      @elseif ($item['rating'] == 4)
                        <span class="badge rounded-pill bg-light text-dark">Netral</span>
                      @else
                        <span class="badge rounded-pill bg-danger">Negatif</span>
                      @endif
                    </td>
                    <td>
                      @if ($result[$loop->index] > 0)
                        <span class="badge rounded-pill bg-success">Positif</span>
                      @elseif ($result[$loop->index] == 0)
                        <span class="badge rounded-pill bg-light text-dark">Netral</span>
                      @else
                        <span class="badge rounded-pill bg-danger">Negatif</span>
                      @endif
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
      <div class="col-6">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Confusion Matrix</h5>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle text-center">
                <thead>
                  <tr>
                    <td>Aktual / Sistem</td>
                    <th>Positif</th>
                    <th>Netral</th>
                    <th>Negatif</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($confusionMatrix as $item)
                    <tr>
                      @if ($loop->iteration == 1)
                        <th>Positif</th>
                      @elseif ($loop->iteration == 2)
                        <th>Netral</th>
                      @else
                        <th>Negatif</th>
                      @endif
                      @foreach ($item as $i)
                        <td>{{ $i }}</td>
                      @endforeach
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card mb-4 shadow-sm">
          <div class="card-body">

            <div id="chart"></div>

          </div>
        </div>
      </div>
    </div>
      
  @endif

  <div wire:loading wire:target="process">
    <div class="load-awesome">
      <div class="la-ball-atom la-3x">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>
    </div>
  </div>

  <script>

    $(document).ready(function() {
      $('#reviews').DataTable(tableConfiguration);
      $('#caseFolding').DataTable(tableConfiguration);
      $('#tokenizing').DataTable(tableConfiguration);
      $('#filtering').DataTable(tableConfiguration);
      $('#stemming').DataTable(tableConfiguration);
      $('#clasification').DataTable(tableConfiguration);
      $('#termFrequency').DataTable(tableConfiguration);
      $('#inverseDocumentFrequency').DataTable(tableConfiguration);
      $('#tfidf').DataTable(tableConfiguration);
      $('#kernel').DataTable(tableConfiguration);
      $('#hessian').DataTable(tableConfiguration);
      $('#eror').DataTable(tableConfiguration);
      $('#delta').DataTable(tableConfiguration);
      $('#alpha').DataTable(tableConfiguration);
    });
    $(document).on('shown.bs.tab', 'button[data-bs-toggle="tab"]', function (e) {
      $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    });

    var accuracy = 90;
    var precision = 80;
    var recall = 75;
    var f1score = 85;

  </script>
  
</div>