<div class="pl-4 pr-4">
  <form action="{{ route('entries.store') }}" method="post" id="create-form" enctype="multipart/form-data">
  @csrf
    <div class="row mb-3">
      <label for="sector_id"><strong>Sector :</strong></label>
      <select name="sector_id" id="sector_id" class="form-control select2bs4">
        <optgroup label="Income">
          @if(isset($sectors['incomes'][0]))
          @foreach($sectors['incomes'] as $key => $income)
          <option value="{{ $income->id }}">&nbsp;&nbsp;&nbsp;&nbsp;{{ $income->name }}</option>
          @endforeach
          @endif
        </optgroup>
        <optgroup label="Expense">
          @if(isset($sectors['expenses'][0]))
          @foreach($sectors['expenses'] as $key => $expense)
          <option value="{{ $expense->id }}">&nbsp;&nbsp;&nbsp;&nbsp;{{ $expense->name }}</option>
          @endforeach
          @endif
        </optgroup>
      </select>
    </div>
    <div class="row mb-3">
      <label for="title"><strong>Title :</strong></label>
      <x-input id="title" class="block mt-1 w-full" type="text" name="title" required />
    </div>
    <div class="row mb-3">
      <div class="col-md-4 pl-0">
        <label for="date"><strong>Date :</strong></label>
        <x-input id="date" class="block mt-1 w-full" type="date" name="date" value="{{ date('Y-m-d') }}" required />
      </div>
      <div class="col-md-4 pr-0">
        <label for="time"><strong>Time :</strong></label>
        <x-input id="time" class="block mt-1 w-full" type="time" name="time" value="{{ date('H:i') }}" required />
      </div>
      <div class="col-md-4 pr-0">
        <label for="amount"><strong>Amount :</strong></label>
        <x-input id="amount" class="block mt-1 w-full" type="number" name="amount" value="0" required />
      </div>
    </div>
    <div class="row mb-3">
      <button type="submit" class="btn btn-primary bg-info text-white"><i class="fa fa-save"></i>&nbsp; Save Entry</button>
    </div>
  </form>
</div>
<script type="text/javascript">
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });
</script>