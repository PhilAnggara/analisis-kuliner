@extends('layouts.app')
@section('title', 'Analisis Kuliner')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
  <div class="container-xxl">

    <div class="row py-3">
      <div class="col-12">
        <div class="card border-0 border-bottom bg-transparent">
          <div class="card-body px-0">
            <h3 class="fw-bold">Crawling Data</h3>
            <h6 class="card-subtitle text-muted">Proses pengambilan data dari TripAdvisor</h6>
          </div>
        </div>
      </div>
    </div>

    @livewire('crawling')

  </div>
</div>
@endsection

@push('addon-script')
  <script>
    Livewire.on('loadTable', () => {
      $('#myTable').DataTable(tableConfiguration);
    });
  </script>
@endpush