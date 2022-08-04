@extends('layouts.app')
@section('title', 'Analisis Kuliner')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
  <div class="container-xxl">

    <div class="row py-3">
      <div class="col-12">
        <div class="card border-0 border-bottom bg-transparent">
          <div class="card-body px-0">
            <h3 class="fw-bold">Otomatis</h3>
            {{-- <h6 class="card-subtitle text-muted">Subtitle</h6> --}}
          </div>
        </div>
      </div>
    </div>

    @livewire('otomatis')
    
  </div>
</div>
@endsection

@push('addon-script')
  <script>
    Livewire.on('loadChart', percentage => {
      var options = {
        chart: {
          type: 'donut',
          width: '100%',
          height:'400px',
        },
        labels: ['Positif', 'Netral', 'Negatif'],
        series: [percentage.positif, percentage.netral, percentage.negatif],
        colors:['#00E396', '#dbdbdb', '#FF4560'],
        legend: {
          position: 'top'
        },
        plotOptions: {
          pie: {
            donut: {
              size: '40%'
            }
          }
        }
      };

      var chart = new ApexCharts(document.querySelector("#chart"), options).render();
    })
  </script>
@endpush