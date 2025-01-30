<div class="modal fade" id="editDepartmentModal{{ $department->id }}" tabindex="-1" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="PUT" action="{{ route('settings.editDepartment', $department->id) }}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="editDepartmentModalLabel">Edit Department</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-floating form-floating-outline mb-3">
              <input class="form-control" type="text" placeholder="Full name" name="name" id="name" value="{{$department->name}}" />
              <label for="name">Department name</label>
            </div>
            <div class="form-floating form-floating-outline mb-3">
              <input class="form-control" type="text" placeholder="Department role" name="role" id="role" value="{{$department->role}}" />
              <label for="name">Department role</label>
            </div>
        
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Derpartment</button>
          </div>
        </form>
      </div>
    </div>
  </div>