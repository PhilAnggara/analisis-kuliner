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
                  @if ($item['class'] > 0)
                    <span class="badge rounded-pill bg-light text-success">Positif</span>
                  @elseif ($item['class'] == 0)
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