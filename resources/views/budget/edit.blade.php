<div class="pl-4 pr-4">
  <form action="{{ route('sectors.update', $sector->id) }}" method="post" id="create-form" enctype="multipart/form-data">
  @csrf
  @method('PUT')
    <div class="row mb-3">
      <label for="type"><strong>Sector Type :</strong></label>
      <select name="type" id="type" class="form-control select2bs4">
        <option value="income" {{ $sector->type == 'income' ? 'selected' : '' }}>Income</option>
        <option value="expense" {{ $sector->type == 'expense' ? 'selected' : '' }}>Expense</option>
      </select>
    </div>
    <div class="row mb-3">
      <label for="name"><strong>Sector Name :</strong></label>
      <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $sector->name }}" required />
    </div>
    <div class="row mb-3">
      <button type="submit" class="btn btn-primary bg-info text-white"><i class="fa fa-save"></i>&nbsp; Update Sector</button>
    </div>
  </form>
</div>
<script type="text/javascript">
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });
</script>