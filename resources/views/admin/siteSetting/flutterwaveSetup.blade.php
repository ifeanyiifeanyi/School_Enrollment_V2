                    {{-- Flutterwave Setup Form --}}
                    <div id="flutterwave-setup-form" class="{{ request('tab') !== 'flutterwave' ? 'hidden' : '' }}">
                        <form id="flutterwave-settings-form" method="POST">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h4>Flutterwave Setup</h4>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">Setup your Flutterwave settings here.</p>
                                    <!-- FLW Public Key -->
                                    <div class="form-group row align-items-center">
                                        <label for="flw-public-key" class="form-control-label col-sm-3 text-md-right">FLW Public Key</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" name="flw_public_key" class="form-control" id="flw-public-key" value="{{ old('flw_public_key', $flw_public_key ?? '') }}">
                                        </div>
                                        @error('flw_public_key')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- FLW Secret Key -->
                                    <div class="form-group row align-items-center">
                                        <label for="flw-secret-key" class="form-control-label col-sm-3 text-md-right">FLW Secret Key</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" name="flw_secret_key" class="form-control" id="flw-secret-key" value="{{ old('flw_secret_key', $flw_secret_key ?? '') }}">
                                        </div>
                                        @error('flw_secret_key')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- FLW Secret Hash -->
                                    <div class="form-group row align-items-center">
                                        <label for="flw-secret-hash" class="form-control-label col-sm-3 text-md-right">FLW Secret Hash</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" name="flw_secret_hash" class="form-control" id="flw-secret-hash" value="{{ old('flw_secret_hash', $flw_secret_hash ?? '') }}">
                                        </div>
                                        @error('flw_secret_hash')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer bg-whitesmoke text-md-right">
                                    <button class="btn btn-primary" type="button" id="flutterwave-save-btn">Save Changes</button>
                                    <button class="btn btn-secondary" type="button">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
