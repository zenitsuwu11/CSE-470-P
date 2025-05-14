<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Profile</title>
  <!-- Include Dashboard CSS for the nav bar styles and profile.css for the profile form styling -->
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Header Navigation -->
  <header>
    <!-- Top Navigation Bar -->
    <div class="header-top">
      <div class="logo">
        G-Hub(Admin-profile)
      </div>
      <div class="right-section">
        <div class="user_area">
          <span class="username">{{ auth('admin')->user()->name }}</span>
          <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout_button">Logout</button>
          </form>
        </div>
      </div>
    </div>
    <!-- Bottom Navigation Bar -->
    <div class="header-bottom">
      <nav class="secondary-nav">
        <ul>
          <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Profile Content -->
  <div class="container light-style flex-grow-1 container-p-y mt-4">
    <div class="card overflow-hidden">
      <div class="row no-gutters row-bordered row-border-light">
        <!-- Sidebar Navigation (Profile Tabs) -->
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
                <form id="admin-general-form" method="POST" action="{{ route('admin.profile.update.general') }}">
                  @csrf
                  <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="{{ auth('admin')->user()->name }}" required>
                  </div>
                  <div class="form-group">
                    <label class="form-label">E-mail</label>
                    <input type="email" class="form-control" name="email" value="{{ auth('admin')->user()->email }}" required>
                  </div>
                  <button type="button" class="btn btn-primary" onclick="confirmSubmission('admin-general-form', 'Do you want to save the changes? Your current data will be overwritten.')">Save Changes</button>
                </form>
              </div>
            </div>

            <!-- Change Password Tab -->
            <div class="tab-pane fade" id="account-change-password">
              <div class="card-body">
                <form id="admin-password-form" method="POST" action="{{ route('admin.profile.update.password') }}">
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
                  <button type="button" class="btn btn-primary" onclick="confirmSubmission('admin-password-form', 'Do you want to save the changes? Your current data will be overwritten.')">Save Changes</button>
                </form>
              </div>
            </div>

            <!-- Info Tab -->
            <div class="tab-pane fade" id="account-info">
              <div class="card-body">
                <form id="admin-info-form" method="POST" action="{{ route('admin.profile.update.info') }}">
                  @csrf
                  <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea class="form-control" name="bio" rows="5">{{ auth('admin')->user()->bio }}</textarea>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Birthday</label>
                    <input type="text" class="form-control" name="birthday" value="{{ auth('admin')->user()->birthday }}">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Country</label>
                    <select class="custom-select" name="country">
                      <option value="USA" {{ auth('admin')->user()->country == 'USA' ? 'selected' : '' }}>USA</option>
                      <option value="Canada" {{ auth('admin')->user()->country == 'Canada' ? 'selected' : '' }}>Canada</option>
                      <option value="UK" {{ auth('admin')->user()->country == 'UK' ? 'selected' : '' }}>UK</option>
                      <option value="Germany" {{ auth('admin')->user()->country == 'Germany' ? 'selected' : '' }}>Germany</option>
                      <option value="France" {{ auth('admin')->user()->country == 'France' ? 'selected' : '' }}>France</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" value="{{ auth('admin')->user()->phone }}">
                  </div>
                  <button type="button" class="btn btn-primary" onclick="confirmSubmission('admin-info-form', 'Do you want to save the changes? Your current data will be overwritten.')">Save Changes</button>
                </form>
              </div>
            </div>

            <!-- Delete Account Tab -->
            <div class="tab-pane fade" id="account-delete">
              <div class="card-body">
                <p>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data you wish to retain.</p>
                <button type="button" class="btn btn-danger" onclick="confirmSubmission('admin-delete-form', 'Do you want to delete your account? Your account will be permanently deleted.')">Delete Account</button>
                <form id="admin-delete-form" method="POST" action="{{ route('admin.profile.delete') }}" style="display:none;">
                  @csrf
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
    let currentFormId = '';
    function confirmSubmission(formId, message) {
      currentFormId = formId;
      document.getElementById('confirmModalBody').innerText = message;
      $('#confirmModal').modal('show');
    }
    document.getElementById('confirmYesBtn').addEventListener('click', function() {
      document.getElementById(currentFormId).submit();
      $('#confirmModal').modal('hide');
    });
  </script>
</body>
</html>
