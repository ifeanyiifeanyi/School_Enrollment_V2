{{-- Paystack Setup Form --}}
<div id="paystack-setup-form" class="{{ request('tab') !== 'paystack' ? 'hidden' : '' }}">
    <form id="paystack-settings-form" method="POST">
        @csrf
        <div class="card" id="settings-card">
            <div class="card-header">
                <h4>Paystack Setup</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">Setup your Paystack settings here.</p>
                <!-- Paystack Public Key -->
                <div class="form-group row align-items-center">
                    <label for="paystack-public-key" class="form-control-label col-sm-3 text-md-right">Paystack Public
                        Key</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" name="paystack_public_key" class="form-control" id="paystack-public-key">
                    </div>
                    @error('paystack_public_key')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Paystack Secret Key -->
                <div class="form-group row align-items-center">
                    <label for="paystack-secret-key" class="form-control-label col-sm-3 text-md-right">Paystack Secret
                        Key</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" name="paystack_secret_key" class="form-control" id="paystack-secret-key">
                    </div>
                    @error('paystack_secret_key')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Merchant Email -->
                <div class="form-group row align-items-center">
                    <label for="merchant-email" class="form-control-label col-sm-3 text-md-right">Merchant Email</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="email" name="merchant_email" class="form-control" id="merchant-email">
                    </div>
                    @error('merchant_email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer bg-whitesmoke text-md-right">
                <button class="btn btn-primary" type="button" id="paystack-save-btn">Save Changes</button>
                <button class="btn btn-secondary" type="button">Reset</button>
            </div>
        </div>
    </form>
</div>
