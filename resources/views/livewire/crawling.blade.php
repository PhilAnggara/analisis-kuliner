<div>
  
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm">
        <div class="card-body">

          <div class="input-group">
            <span class="input-group-text">Pilih periode : </span>
            <input type="month" class="form-control bg-transparent">
            <input type="month" class="form-control bg-transparent">
            <button wire:click="getData" class="btn btn-outline-primary" type="button">
              <i class="fa-solid fa-arrow-down-to-square"></i>
              Ambil Data
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>

  @if ($success)
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <table class="table table-hover align-middle text-center" id="myTable">
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

</div>
