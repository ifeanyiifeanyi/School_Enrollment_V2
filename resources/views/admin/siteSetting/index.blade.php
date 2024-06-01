@extends('admin.layouts.adminLayout')

@section('title', 'SEO & SITE SETTINGS')

@section('css')
    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection

@section('admin')
    @php
        $siteSetting = $siteSetting ?? null;

    @endphp
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>

            <div class="section-body">
                <h2 class="section-title">All About General Settings</h2>
                <p class="section-lead">
                    You can adjust all general settings here
                </p>

                <div id="output-status"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item"><a href="#" class="nav-link" id="general-tab">General</a>
                                    </li>
                                    <li class="nav-item"><a href="#" class="nav-link" id="email-setup-tab">Email
                                            Setup</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="alert-container"></div>
                        {{-- General Settings Form --}}
                        <div id="general-form" class="{{ request('tab') === 'email-setup' ? 'hidden' : '' }}">
                            <form id="general-settings-form" method="POST" enctype="multipart/form-data">
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
                        {{-- Email Setup Form --}}
                        <div id="email-setup-form" class="{{ request('tab') !== 'email-setup' ? 'hidden' : '' }}">
                            <form id="email-settings-form" method="POST">
                                @csrf
                                <div class="card" id="settings-card">
                                    <div class="card-header">
                                        <h4>Email Setup</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted">Setup your email settings here.</p>
                                        <!-- SMTP Host -->
                                        <div class="form-group row align-items-center">
                                            <label for="smtp-host" class="form-control-label col-sm-3 text-md-right">SMTP
                                                Host</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="smtp_host" class="form-control"
                                                    id="smtp-host" value="{{ old('smtp_host', $smtp_host ?? '') }}">
                                            </div>
                                            @error('smtp_host')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- SMTP Port -->
                                        <div class="form-group row align-items-center">
                                            <label for="smtp-port" class="form-control-label col-sm-3 text-md-right">SMTP
                                                Port</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="smtp_port" class="form-control"
                                                    id="smtp-port" value="{{ old('smtp_port', $smtp_port ?? '') }}">
                                            </div>
                                            @error('smtp_port')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- SMTP Username -->
                                        <div class="form-group row align-items-center">
                                            <label for="smtp-username"
                                                class="form-control-label col-sm-3 text-md-right">SMTP Username</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="smtp_username" class="form-control"
                                                    id="smtp-username"
                                                    value="{{ old('smtp_username', $smtp_username ?? '') }}">
                                            </div>
                                            @error('smtp_username')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- SMTP Password -->
                                        <div class="form-group row align-items-center">
                                            <label for="smtp-password"
                                                class="form-control-label col-sm-3 text-md-right">SMTP Password</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="password" name="smtp_password" class="form-control"
                                                    id="smtp-password"
                                                    value="{{ old('smtp_password', $smtp_password ?? '') }}">
                                            </div>
                                            @error('smtp_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- Encryption -->
                                        <div class="form-group row align-items-center">
                                            <label for="encryption"
                                                class="form-control-label col-sm-3 text-md-right">Encryption</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="encryption" class="form-control"
                                                    id="encryption" value="{{ old('encryption', $encryption ?? '') }}">
                                            </div>
                                            @error('encryption')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer bg-whitesmoke text-md-right">
                                        <button class="btn btn-primary" type="button" id="email-save-btn">Save
                                            Changes</button>
                                        <button class="btn btn-secondary" type="button">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    {{-- <script>
  document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');

    const generalTab = document.getElementById('general-tab');
    const emailSetupTab = document.getElementById('email-setup-tab');
    const generalForm = document.getElementById('general-form');
    const emailSetupForm = document.getElementById('email-setup-form');

    if (tab === 'email-setup') {
      generalForm.classList.add('hidden');
      emailSetupForm.classList.remove('hidden');
      generalTab.classList.remove('active');
      emailSetupTab.classList.add('active');
    } else {
      generalForm.classList.remove('hidden');
      emailSetupForm.classList.add('hidden');
      generalTab.classList.add('active');
      emailSetupTab.classList.remove('active');
    }

    generalTab.addEventListener('click', function () {
      generalForm.classList.remove('hidden');
      emailSetupForm.classList.add('hidden');
      generalTab.classList.add('active');
      emailSetupTab.classList.remove('active');
    });

    emailSetupTab.addEventListener('click', function () {
      generalForm.classList.add('hidden');
      emailSetupForm.classList.remove('hidden');
      generalTab.classList.remove('active');
      emailSetupTab.classList.add('active');
    });

    document.getElementById('general-save-btn').addEventListener('click', function () {
      const formData = new FormData(document.getElementById('general-settings-form'));
      fetch('{{ route('site.setting.store', ['tab' => 'general']) }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        const alertContainer = document.getElementById('alert-container');
        alertContainer.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
      })
      .catch(error => {
        console.error('Error content: ', error);
      });
    });

    document.getElementById('email-save-btn').addEventListener('click', function () {
      const formData = new FormData(document.getElementById('email-settings-form'));
      fetch('{{ route('admin.email.setup', ['tab' => 'email-setup']) }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        const alertContainer = document.getElementById('alert-container');
        alertContainer.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
      })
      .catch(error => {
        console.error('Error:', error);
      });
    });
  });
</script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');

    const generalTab = document.getElementById('general-tab');
    const emailSetupTab = document.getElementById('email-setup-tab');
    const generalForm = document.getElementById('general-form');
    const emailSetupForm = document.getElementById('email-setup-form');

    if (tab === 'email-setup') {
        generalForm.classList.add('hidden');
        emailSetupForm.classList.remove('hidden');
        generalTab.classList.remove('active');
        emailSetupTab.classList.add('active');
    } else {
        generalForm.classList.remove('hidden');
        emailSetupForm.classList.add('hidden');
        generalTab.classList.add('active');
        emailSetupTab.classList.remove('active');
    }

    generalTab.addEventListener('click', function () {
        generalForm.classList.remove('hidden');
        emailSetupForm.classList.add('hidden');
        generalTab.classList.add('active');
        emailSetupTab.classList.remove('active');
    });

    emailSetupTab.addEventListener('click', function () {
        generalForm.classList.add('hidden');
        emailSetupForm.classList.remove('hidden');
        generalTab.classList.remove('active');
        emailSetupTab.classList.add('active');
    });

    document.getElementById('general-save-btn').addEventListener('click', function () {
        const formData = new FormData(document.getElementById('general-settings-form'));
        fetch('{{ route('site.setting.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const alertContainer = document.getElementById('alert-container');
            if (data.errors) {
                let errorsHtml = '<div class="alert alert-danger"><ul>';
                for (const error in data.errors) {
                    errorsHtml += '<li>' + data.errors[error][0] + '</li>';
                }
                errorsHtml += '</ul></div>';
                alertContainer.innerHTML = errorsHtml;
            } else {
                alertContainer.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const alertContainer = document.getElementById('alert-container');
            alertContainer.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
        });
    });

    document.getElementById('email-save-btn').addEventListener('click', function () {
        const formData = new FormData(document.getElementById('email-settings-form'));
        fetch('{{ route('admin.email.setup', ['tab' => 'email-setup']) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const alertContainer = document.getElementById('alert-container');
            if (data.errors) {
                let errorsHtml = '<div class="alert alert-danger"><ul>';
                for (const error in data.errors) {
                    errorsHtml += '<li>' + data.errors[error][0] + '</li>';
                }
                errorsHtml += '</ul></div>';
                alertContainer.innerHTML = errorsHtml;
            } else {
                alertContainer.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const alertContainer = document.getElementById('alert-container');
            alertContainer.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
        });
    });
});

    </script>
@endsection
