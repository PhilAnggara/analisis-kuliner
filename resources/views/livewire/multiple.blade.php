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

    @include('includes.section.reviews')
    @include('includes.section.preprocessing')
    @include('includes.section.vectorizer')
    @include('includes.section.svm')
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
                  <th>Prediksi</th>
                  <th></th>
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
                      @if ($item['class'] > 0)
                        <span class="badge rounded-pill bg-light text-success">Positif</span>
                      @elseif ($item['class'] == 0)
                        <span class="badge rounded-pill bg-light text-dark">Netral</span>
                      @else
                        <span class="badge rounded-pill bg-light text-danger">Negatif</span>
                      @endif
                    </td>
                    <td>
                      @if ($result[$loop->index] > 0)
                        <span class="badge rounded-pill bg-light text-success">Positif</span>
                      @elseif ($result[$loop->index] == 0)
                        <span class="badge rounded-pill bg-light text-dark">Netral</span>
                      @else
                        <span class="badge rounded-pill bg-light text-danger">Negatif</span>
                      @endif
                    </td>
                    <td>
                      @if ($item['class'] > $result[$loop->index])
                        <i class="fa-solid fa-circle-caret-down text-warning"></i>
                      @elseif ($item['class'] < $result[$loop->index])
                        <i class="fa-solid fa-circle-caret-up text-warning"></i>
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
                    <td>Aktual \ Prediksi</td>
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
    
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <div class="card-body text-center">
            <p class="fst-italic text-muted mb-0">
              Waktu eksekusi : {{ number_format($totalExecutionTime, 5, ',') }} detik
            </p>
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
      $('#termFrequency').DataTable(tableConfiguration2);
      $('#inverseDocumentFrequency').DataTable(tableConfiguration2);
      $('#tfidf').DataTable(tableConfiguration2);
      $('#kernel').DataTable(tableConfiguration2);
      $('#hessian').DataTable(tableConfiguration2);
      $('#eror').DataTable(tableConfiguration2);
      $('#delta').DataTable(tableConfiguration2);
      $('#alpha').DataTable(tableConfiguration2);
      $('#clasification').DataTable(tableConfiguration);
    });
    $(document).on('shown.bs.tab', 'button[data-bs-toggle="tab"]', function (e) {
      $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    });

  </script>
  
</div>