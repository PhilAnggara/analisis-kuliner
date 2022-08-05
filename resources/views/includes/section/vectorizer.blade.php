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