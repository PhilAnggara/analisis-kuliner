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