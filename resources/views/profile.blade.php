<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <!-- Link to your profile CSS and Bootstrap -->
  <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container light-style flex-grow-1 container-p-y mt-4">
    <h4 class="font-weight-bold py-3 mb-4 text-white">User - Profile</h4>
    <div class="card overflow-hidden">
      <div class="row no-gutters row-bordered row-border-light">
        <!-- Sidebar Navigation -->
        <div class="col-md-3 pt-0">
          <div class="list-group list-group-flush account-settings-links">
            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change Password</a>
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a>
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-delete">Delete Account</a>
          </div>
        </div>
        <!-- Tab Contents -->
        <div class="col-md-9">
          <div class="tab-content">
            <!-- General Tab -->
            <div class="tab-pane fade active show" id="account-general">
                <div class="card-body">
                    <form id="general-form" method="POST" action="{{ route('profile.update.general') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <!-- Using auth()->user()->name instead of username -->
                        <input type="text" class="form-control" name="username" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="confirmSubmission('general-form', 'Do you want to save the changes? Your current data will be overwritten.')">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- 2. Change Password Tab -->
            <div class="tab-pane fade" id="account-change-password">
              <div class="card-body">
                <form id="password-form" method="POST" action="{{ route('profile.update.password') }}">
                  @csrf
                  <div class="form-group">
                    <label class="form-label">Current Password</label>
                    <input type="password" class="form-control" name="current_password" required>
                  </div>
                  <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" class="form-control" name="new_password" required>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Repeat New Password</label>
                    <input type="password" class="form-control" name="new_password_confirmation" required>
                  </div>
                  <button type="button" class="btn btn-primary" onclick="confirmSubmission('password-form', 'Do you want to save the changes? Your current data will be overwritten.')">Save Changes</button>
                </form>
              </div>
            </div>
            <!-- 3. Info Tab -->
            <div class="tab-pane fade" id="account-info">
              <div class="card-body">
                <form id="info-form" method="POST" action="{{ route('profile.update.info') }}">
                  @csrf
                  <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea class="form-control" name="bio" rows="5">{{ auth()->user()->bio }}</textarea>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Birthday</label>
                    <input type="text" class="form-control" name="birthday" value="{{ auth()->user()->birthday }}">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Country</label>
                    <select class="custom-select" name="country">
                      <option value="USA" {{ auth()->user()->country == 'USA' ? 'selected' : '' }}>USA</option>
                      <option value="Canada" {{ auth()->user()->country == 'Canada' ? 'selected' : '' }}>Canada</option>
                      <option value="UK" {{ auth()->user()->country == 'UK' ? 'selected' : '' }}>UK</option>
                      <option value="Germany" {{ auth()->user()->country == 'Germany' ? 'selected' : '' }}>Germany</option>
                      <option value="France" {{ auth()->user()->country == 'France' ? 'selected' : '' }}>France</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" value="{{ auth()->user()->phone }}">
                  </div>
                  <button type="button" class="btn btn-primary" onclick="confirmSubmission('info-form', 'Do you want to save the changes? Your current data will be overwritten.')">Save Changes</button>
                </form>
              </div>
            </div>
            <!-- 4. Delete Account Tab -->
            <div class="tab-pane fade" id="account-delete">
              <div class="card-body">
                <p>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data you wish to retain.</p>
                <button type="button" class="btn btn-danger" onclick="confirmSubmission('delete-form', 'Do you want to delete your account? Your account will be permanently deleted.')">Delete Account</button>
                <form id="delete-form" method="POST" action="{{ route('profile.delete') }}" style="display:none;">
                  @csrf
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- (Optional) Other profile page elements -->
  </div>

  <!-- Confirmation Modal (Bootstrap) -->
  <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="background-color: #333; color: white;">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Confirm Changes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="confirmModalBody">
          <!-- Message will be inserted here -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-light" id="confirmYesBtn">Yes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Global variable to hold the current form ID
    let currentFormId = '';

    function confirmSubmission(formId, message) {
      currentFormId = formId;
      document.getElementById('confirmModalBody').innerText = message;
      $('#confirmModal').modal('show');
    }

    document.getElementById('confirmYesBtn').addEventListener('click', function() {
      // Submit the form and hide the modal
      document.getElementById(currentFormId).submit();
      $('#confirmModal').modal('hide');
    });
  </script>
</body>
</html>
