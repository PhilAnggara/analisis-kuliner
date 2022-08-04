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
                <select wire:model="amount" class="form-select bg-transparent" required>
                  <option value="" selected disabled>-- Jumlah data --</option>
                  <option>5</option>
                  <option>10</option>
                  <option>20</option>
                  <option>50</option>
                  <option>100</option>
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
                  {{-- <th>Label</th> --}}
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
                    {{-- <td>
                      @if ($item['rating'] > 4)
                        <span class="badge rounded-pill bg-success">Positif</span>
                      @elseif ($item['rating'] == 4)
                        <span class="badge rounded-pill bg-light text-dark">Netral</span>
                      @else
                        <span class="badge rounded-pill bg-danger">Negatif</span>
                      @endif
                    </td> --}}
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
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover align-middle text-center" id="preProcessing">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Case Folding</th>
                    <th>Tokenizing</th>
                    <th>Filteringg</th>
                    <th>Stemming</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($reviews as $item)
                    <tr>
                      <th>{{ $loop->iteration }}</th>
                      <td class="text-start">{{ $case_folding[$loop->index]['review'] }}</td>
                      <td class="text-start">
                        @foreach ($tokenizing[$loop->index]['review'] as $i)
                          @if ($loop->first)
                            ['{{ $i }}',
                          @elseif ($loop->last)
                            '{{ $i }}']
                          @else
                            '{{ $i }}',
                          @endif
                        @endforeach
                      </td>
                      <td class="text-start">
                        @foreach ($filtering[$loop->index]['review'] as $i)
                          @if ($loop->first)
                            ['{{ $i }}',
                          @elseif ($loop->last)
                            '{{ $i }}']
                          @else
                            '{{ $i }}',
                          @endif
                        @endforeach
                      </td>
                      <td class="text-start">
                        @foreach ($stemming[$loop->index]['review'] as $i)
                          @if ($loop->first)
                            ['{{ $i }}',
                          @elseif ($loop->last)
                            '{{ $i }}']
                          @else
                            '{{ $i }}',
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
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Klasifikasi</h5>
          <div class="card-body">
            <table class="table table-hover align-middle text-center" id="klasifikasi">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Ulasan</th>
                  <th>Sentimen</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($reviews as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td class="text-start">{{ $item['review'] }}</td>
                    <td>
                      @if ($result[$loop->index] > 0)
                        <span class="badge rounded-pill bg-light text-success">Positif</span>
                      @elseif ($result[$loop->index] == 0)
                        <span class="badge rounded-pill bg-light text-dark">Netral</span>
                      @else
                        <span class="badge rounded-pill bg-light text-danger">Negatif</span>
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
      $('#preProcessing').DataTable(tableConfiguration);
      $('#klasifikasi').DataTable(tableConfiguration);
    });
  </script>
  
</div>