<!-- Edit User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <div class="text-center mb-6">
          <h4 class="mb-2">Edit Customer Information</h4>
          <p class="mb-6">Updating customer details ..</p>
        </div>
        <form id="editUserForm" class="row g-5" method="POST" action="{{ route('customers.update', $customer->id) }}">
          @csrf
    @method('PUT')
          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $customer->first_name }}" placeholder="Type the name .." />
              <label for="first_name">First Name</label>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $customer->last_name }}" placeholder="Type last name .." />
              <label for="last_name">Last Name</label>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="email" name="email" class="form-control" value="{{ $customer->email }}" placeholder="xx@xx.xx" />
              <label for="email">Email</label>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <select id="category_id" name="category_id" class="form-select form-select-sm" aria-label="Choose Category">
            <option selected>Choose category</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ $customer->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
              <label for="category_id">Category</label>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" type="date" placeholder="Select a date" name="date" id="date" value="{{ $customer->date }}" />
                        <label for="date">Registration Date</label>
                    </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="input-group input-group-merge">
              <span class="input-group-text">SS (+211)</span>
              <div class="form-floating form-floating-outline">
                <input type="number" id="phone" name="phone" class="form-control" value="{{ $customer->phone }}" placeholder="Enter phone number" />
                <label for="phone">Phone Number</label>
              </div>
            </div>
          </div>
          <div class="col-12 text-center d-flex flex-wrap justify-content-center gap-4 row-gap-4">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
