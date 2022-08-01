@extends('layouts.app')
@section('title', 'Analisis Kuliner')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
  <div class="container-xxl">

    <div class="row py-3">
      <div class="col-12">
        <div class="card border-0 border-bottom bg-transparent">
          <div class="card-body px-0">
            <h3 class="fw-bold">Testing</h3>
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
    
  </div>
</div>
@endsection

@push('addon-script')
  <script>
    $(document).ready(function() {
      $('#stemming').DataTable(tableConfiguration);
      $('#termFrequency').DataTable(tableConfiguration);
      $('#inverseDocumentFrequency').DataTable(tableConfiguration);
      $('#tfidf').DataTable(tableConfiguration);
      $('#kernel').DataTable(tableConfiguration);
      $('#hessian').DataTable(tableConfiguration);
      $('#eror').DataTable(tableConfiguration);
      $('#delta').DataTable(tableConfiguration);
      $('#alpha').DataTable(tableConfiguration);
    });
  </script>
@endpush