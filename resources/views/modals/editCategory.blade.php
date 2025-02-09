<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-header">
            <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-floating form-floating-outline mb-3">
              <input class="form-control" type="text" placeholder="Category name" name="name" id="name" value="{{$category->name}}" />
              <label for="name">Category name</label>
            </div>
            <div class="form-floating form-floating-outline mb-3">
              <input class="form-control" type="text" placeholder="Category name" name="tariff" id="tariff" value="{{$category->tariff}}" />
              <label for="name">Tariff</label>
            </div>
          
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>