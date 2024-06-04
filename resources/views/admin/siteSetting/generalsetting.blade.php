<div id="general-form" class="{{ request('tab') === 'email-setup' ? 'hidden' : '' }}">
    <form id="general-settings-form" method="POST" enctype="multipart/form-data" action="{{ route('site.setting.store') }}">
        @csrf
        <div class="card" id="settings-card">
            <div class="card-header">
                <h4>General Settings</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">General settings such as, site title, site description,
                    address and so on.</p>
                <!-- Site Title -->
                <div class="form-group row align-items-center">
                    <label for="site-title" class="form-control-label col-sm-3 text-md-right">Site
                        Title</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" name="site_title" class="form-control" id="site-title"
                            value="{{ old('site_title', $siteSetting->site_title ?? '') }}">
                    </div>
                    @error('site_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Site Color -->
                <div class="form-group row align-items-center">
                    <label for="site-color" class="form-control-label col-sm-3 text-md-right">Site
                        Color</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" name="site_color" class="form-control" id="site-color"
                            value="{{ old('site_color', $siteSetting->site_color ?? '') }}">
                    </div>
                    @error('site_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Phone Number -->
                <div class="form-group row align-items-center">
                    <label for="phone" class="form-control-label col-sm-3 text-md-right">Site
                        Phone Number</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="tel" name="phone" class="form-control" id="phone"
                            value="{{ old('phone', $siteSetting->phone ?? '') }}">
                    </div>
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Email Address -->
                <div class="form-group row align-items-center">
                    <label for="email" class="form-control-label col-sm-3 text-md-right">Site
                        Email Address</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="email" name="email" class="form-control" id="email"
                            value="{{ old('email', $siteSetting->email ?? '') }}">
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Address -->
                <div class="form-group row align-items-center">
                    <label for="address" class="form-control-label col-sm-3 text-md-right">Site
                        Address</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" name="address" class="form-control" id="address"
                            value="{{ old('address', $siteSetting->address ?? '') }}">
                    </div>
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Form Price -->
                <div class="form-group row align-items-center">
                    <label for="form-price" class="form-control-label col-sm-3 text-md-right">Form
                        Price</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="number" name="form_price" class="form-control" id="form-price"
                            value="{{ old('form_price', $siteSetting->form_price ?? '') }}">
                    </div>
                    @error('form_price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Site Description -->
                <div class="form-group row align-items-center">
                    <label for="site-description"
                        class="form-control-label col-sm-3 text-md-right">Site Description</label>
                    <div class="col-sm-6 col-md-9">
                        <textarea class="form-control" name="site_description" id="site-description">{{ old('site_description', $siteSetting->site_description ?? '') }}</textarea>
                    </div>
                    @error('site_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- About Us -->
                <div class="form-group row align-items-center">
                    <label for="about" class="form-control-label col-sm-3 text-md-right">About
                        Us</label>
                    <div class="col-sm-6 col-md-9">
                        <textarea class="form-control" name="about" id="about">{{ old('about', $siteSetting->about ?? '') }}</textarea>
                    </div>
                    @error('about')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Site Logo -->
                <div class="form-group row align-items-center">
                    <label class="form-control-label col-sm-3 text-md-right">Site Logo</label>
                    <div class="col-sm-6 col-md-9">
                        <div class="custom-file">
                            <input type="file" name="site_logo" class=""
                                id="site-logo">
                        </div>
                        <div class="form-text text-muted">
                            <img width="60px" src="{{ asset($siteSetting->site_icon ?? '') }}"
                                class="img-responsive img-fluid" alt="logo"><br>
                            The image must have a maximum size of 1MB
                        </div>
                        @error('site_logo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <hr>
                <!-- Favicon -->
                <div class="form-group row align-items-center">
                    <label class="form-control-label col-sm-3 text-md-right">Favicon</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="file" name="site_favicon" id="site_favicon">

                        <div class="form-text text-muted">
                            <img width="60px"
                                src="{{ asset($siteSetting->site_favicon ?? '') }}"
                                class="img-responsive img-fluid" alt="favicon"><br>
                            The image must have a maximum size of 1MB
                        </div>
                        @error('site_favicon')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- Google Analytics Code -->
                <div class="form-group row">
                    <label class="mt-3 form-control-label col-sm-3 text-md-right">Google Analytics
                        Code</label>
                    <div class="col-sm-6 col-md-9">
                        <textarea class="form-control codeeditor" name="google_analytics_code">{{ old('google_analytics_code', $siteSetting->google_analytics ?? '') }}</textarea>
                    </div>
                    @error('google_analytics_code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer bg-whitesmoke text-md-right">
                <button class="btn btn-primary" type="button" id="general-save-btn">Save
                    Changes</button>
                <button class="btn btn-secondary" type="button">Reset</button>
            </div>
        </div>
    </form>
</div>
