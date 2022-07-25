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
                  <option>50</option>
                  <option>100</option>
                  <option>200</option>
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
                  <th>Nama</th>
                  <th>Rating</th>
                  <th>Restaurant</th>
                  <th>Ulasan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($reviews as $item)
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
      $('#termFrequency').DataTable(tableConfiguration);
      $('#inverseDocumentFrequency').DataTable(tableConfiguration);
      $('#tfidf').DataTable(tableConfiguration);
    });
  </script>
  
</div>