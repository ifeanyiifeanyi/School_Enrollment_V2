<form id="email-setup-form" method="POST" action="{{ route('admin.email.setup', ['tab' => 'email-setup']) }}">
    @csrf
    <div class="card" id="settings-card">
      <div class="card-header">
        <h4>Email Setup</h4>
      </div>
      <div class="card-body">
        <p class="text-muted">Setup your email settings here.</p>

        <!-- SMTP Host -->
        <div class="form-group row align-items-center">
          <label for="smtp-host" class="form-control-label col-sm-3 text-md-right">SMTP Host</label>
          <div class="col-sm-6 col-md-9">
            <input type="text" name="smtp_host" class="form-control" id="smtp-host"
              value="{{ old('smtp_host', $smtp_host ?? '') }}">
          </div>
          @error('smtp_host')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <!-- SMTP Port -->
        <div class="form-group row align-items-center">
          <label for="smtp-port" class="form-control-label col-sm-3 text-md-right">SMTP Port</label>
          <div class="col-sm-6 col-md-9">
            <input type="text" name="smtp_port" class="form-control" id="smtp-port"
              value="{{ old('smtp_port', $smtp_port ?? '') }}">
          </div>
          @error('smtp_port')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <!-- SMTP Username -->
        <div class="form-group row align-items-center">
          <label for="smtp-username" class="form-control-label col-sm-3 text-md-right">SMTP Username</label>
          <div class="col-sm-6 col-md-9">
            <input type="text" name="smtp_username" class="form-control" id="smtp-username"
              value="{{ old('smtp_username', $smtp_username ?? '') }}">
          </div>
          @error('smtp_username')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <!-- SMTP Password -->
        <div class="form-group row align-items-center">
          <label for="smtp-password" class="form-control-label col-sm-3 text-md-right">SMTP Password</label>
          <div class="col-sm-6 col-md-9">
            <input type="password" name="smtp_password" class="form-control" id="smtp-password"
              value="{{ old('smtp_password', $smtp_password ?? '') }}">
          </div>
          @error('smtp_password')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <!-- Encryption -->
        <div class="form-group row align-items-center">
          <label for="encryption" class="form-control-label col-sm-3 text-md-right">Encryption</label>
          <div class="col-sm-6 col-md-9">
            <input type="text" name="encryption" class="form-control" id="encryption"
              value="{{ old('encryption', $encryption ?? '') }}">
          </div>
          @error('encryption')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="card-footer bg-whitesmoke text-md-right">
        <button class="btn btn-primary" id="save-btn">Save Changes</button>
        <button class="btn btn-secondary" type="button">Reset</button>
      </div>
    </div>
  </form>
