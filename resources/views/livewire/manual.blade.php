<div>

  <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm">
        <div class="card-body">

          <form wire:submit.prevent="process">
            <div class="row mb-3">
              <div class="col">
                <textarea wire:model="review" class="form-control bg-transparent" placeholder="Masuka komentar..." rows="3" required></textarea>
              </div>
            </div>
            <div class="d-flex justify-content-end">
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

  @if (!$success)
    
  @else
  
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <h5 class="card-header text-white bg-primary text-center">Preprocessing</h5>
          <div class="card-body">
            <table class="table table-hover align-middle text-center" id="preprocessing">
              <thead>
                <tr>
                  <th>Tahapaan</th>
                  <th>Hasil</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th class="text-nowrap text-muted">Case Folding</th>
                  <td class="text-start">{{ $case_folding }}</td>
                </tr>
                <tr>
                  <th class="text-nowrap text-muted">Tokenizing</th>
                  <td class="text-start">
                    @foreach ($tokenizing as $item)
                      @if ($loop->first)
                        ['{{ $item }}',
                      @elseif ($loop->last)
                        '{{ $item }}']
                      @else
                        '{{ $item }}',
                      @endif
                    @endforeach
                  </td>
                </tr>
                <tr>
                  <th class="text-nowrap text-muted">Filtering</th>
                  <td class="text-start">
                    @foreach ($filtering as $item)
                      @if ($loop->first)
                        ['{{ $item }}',
                      @elseif ($loop->last)
                        '{{ $item }}']
                      @else
                        '{{ $item }}',
                      @endif
                    @endforeach
                  </td>
                </tr>
                <tr>
                  <th class="text-nowrap text-muted">Stemming</th>
                  <td class="text-start">
                    @foreach ($stemming as $item)
                      @if ($loop->first)
                        ['{{ $item }}',
                      @elseif ($loop->last)
                        '{{ $item }}']
                      @else
                        '{{ $item }}',
                      @endif
                    @endforeach
                  </td>
                </tr>
              </tbody>
            </table>
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
      $('#preprocessing').DataTable(tableConfiguration);
    });
  </script>
  
</div>