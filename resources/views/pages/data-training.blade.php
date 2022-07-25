@extends('layouts.app')
@section('title', 'Analisis Kuliner')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
  <div class="container-xxl">

    <div class="row py-3">
      <div class="col-12">
        <div class="card border-0 border-bottom bg-transparent">
          <div class="card-body px-0">
            <h3 class="fw-bold">Data Training</h3>
            <h6 class="card-subtitle text-muted">Data latih yang diambil dari TripAdvisor.</h6>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <div class="card-body">

            <table class="table table-hover align-middle text-center" id="myTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Waktu</th>
                  <th>Nama</th>
                  {{-- <th>Rating</th>
                  <th>Restaurant</th> --}}
                  <th>Ulasan</th>
                  <th>Sentimen</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td class="text-nowrap">{{ $item->date }}</td>
                    <td>{{ $item->name }}</td>
                    {{-- <td>
                      <i class="fa-solid fa-star text-warning"></i>
                      {{ $item->rating }}
                    </td>
                    <td>{{ $item->restaurant }}</td> --}}
                    <td class="text-start">{{ $item->review }}</td>
                    <td>
                      @if ($item->rating < 3)
                        <span class="badge rounded-pill bg-danger">Negatif</span>
                      @elseif ($item->rating == 3)
                        <span class="badge rounded-pill bg-light text-dark">Netral</span>
                      @else
                        <span class="badge rounded-pill bg-success">Positif</span>
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
    
  </div>
</div>
@endsection

@push('addon-script')
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable(tableConfiguration);
    });
  </script>
@endpush