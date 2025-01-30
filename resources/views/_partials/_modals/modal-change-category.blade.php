<div class="modal fade" id="changeCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
    <div class="modal-content p-8 p-md-12">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body pt-md-0 px-0">
        <div class="text-center mb-6">
          <h4 class="mb-2">Customer Category</h4>
          <p class="mb-10">Change category ..</p>
        </div>
        <form id="changeCategoryForm" action="{{ route('customers.update', $customer->id) }}" method="POST" class="row g-4 d-flex align-items-center">
    @csrf
    @method('PUT')
    <div class="col-sm-9">
        <select id="chooseCategory" name="category_id" class="form-select form-select-sm" aria-label="Choose Category">
            <option selected>Choose category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $customer->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">Change</button>
    </div>
</form>


      </div>
      <hr class="my-1">
    </div>
  </div>
</div>