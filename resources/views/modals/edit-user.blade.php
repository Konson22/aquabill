<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="PUT" action="{{ route('settings.edit', $user->id) }}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-floating form-floating-outline mb-3">
              <input class="form-control" type="text" placeholder="Full name" name="name" id="name" value="{{$user->name}}" />
              <label for="name">Full name</label>
            </div>
            <div class="form-floating form-floating-outline mb-3">
                <input class="form-control" type="email" placeholder="example@gmail.com" name="email" id="email" value="{{$user->email}}" />
                <label for="email">E-mail address</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control @error('department') is-invalid @enderror" id="department" name="department" placeholder="department name" value="{{ $user->department }}">
              <label for="department">Department</label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
                <select id="role" name="role" class="form-select form-select-sm" aria-label="Choose User Role">
                    <option selected value="{{ $user->role }}">Change Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <label for="role">Role</label>
            </div>
            <div class="form-floating form-floating-outline mb-3">
                <input class="form-control" type="password" placeholder="Reset password" name="password" id="password" />
                <label for="password">Reset password</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Invoice</button>
          </div>
        </form>
      </div>
    </div>
  </div>