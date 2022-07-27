<div>

  @if (!$success)

    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <div class="card-body">

            <form wire:submit.prevent="process">
              <div class="input-group">
                <select wire:model="selectedCategory" class="form-select bg-transparent" required>
                  <option value="" selected disabled>-- Pilih kategori --</option>
                  @foreach ($categories as $category)
                    <option>{{ $category->name }}</option>
                  @endforeach
                </select>
                <select wire:model="partisi" class="form-select bg-transparent" required>
                  <option value="" selected disabled>-- Data Partisi --</option>
                  <option>80 : 20</option>
                  <option>70 : 30</option>
                  <option>60 : 40</option>
                </select>
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

  @else

    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm">
          <div class="card-body">

            <div id="chart"></div>

          </div>
        </div>
      </div>
    </div>
      
  @endif

  <script>
    document.addEventListener('livewire:load', function () {
      var options = {
        
      };

      var chart = new ApexCharts(document.querySelector("#chart"), options).render();
    })
  </script>
  
</div>