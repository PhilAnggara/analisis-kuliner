@extends('layouts.app')
@section('title', 'Analisis Kuliner')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
  <div class="container-xxl">

    <div class="row py-3">
      <div class="col-12">
        <div class="card border-0 border-bottom bg-transparent">
          <div class="card-body px-0">
            <h3 class="fw-bold">Multiple</h3>
            {{-- <h6 class="card-subtitle text-muted">Subtitle</h6> --}}
          </div>
        </div>
      </div>
    </div>

    @livewire('multiple')
    
  </div>
</div>
@endsection

@push('addon-script')
  <script>
    Livewire.on('loadChart', report => {
      var options = {
        chart: {
          type: 'bar'
        },
        series: [{
          name: "%",
          data: [(report.accuracy*100).toFixed(1), (report.precision*100).toFixed(1), (report.recall*100).toFixed(1), (report.f1score*100).toFixed(1)]
        }],
        xaxis: {
          categories: ['Accuracy','Precision','Recall','F1-Score'],
        },
        yaxis: {
          max: 100,
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            distributed: true,
          }
        },
        theme: {
          palette: 'palette1' // upto palette10
        }
      };

      var chart = new ApexCharts(document.querySelector("#chart"), options).render();
    })
  </script>
@endpush