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
                                    <li class="nav-item"><a href="#" class="nav-link" id="flutterwave-tab">Flutterwave
                                            Setup</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link" id="paystack-tab">Paystack
                                            Setup</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="alert-container"></div>
                        {{-- General Settings Form --}}
                        @include('admin.siteSetting.generalsetting')


                        {{-- Email Setup Form --}}
                        @include('admin.siteSetting.emailsetting')


                        {{-- flutterwave Setup Form --}}
                        @include('admin.siteSetting.flutterwaveSetup')


                        {{-- paystack Setup Form --}}
                        @include('admin.siteSetting.paystackSetup')



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
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');

            const generalTab = document.getElementById('general-tab');
            const emailSetupTab = document.getElementById('email-setup-tab');
            const flutterwaveTab = document.getElementById('flutterwave-tab');
            const paystackTab = document.getElementById('paystack-tab');
            const generalForm = document.getElementById('general-form');
            const emailSetupForm = document.getElementById('email-setup-form');
            const flutterwaveSetupForm = document.getElementById('flutterwave-setup-form');
            const paystackSetupForm = document.getElementById('paystack-setup-form');

            function showForm(formToShow) {
                [generalForm, emailSetupForm, flutterwaveSetupForm, paystackSetupForm].forEach(form => form
                    .classList.add('hidden'));
                formToShow.classList.remove('hidden');
            }

            function activateTab(tabToActivate) {
                [generalTab, emailSetupTab, flutterwaveTab, paystackTab].forEach(tab => tab.classList.remove(
                    'active'));
                tabToActivate.classList.add('active');
            }

            if (tab === 'email-setup') {
                showForm(emailSetupForm);
                activateTab(emailSetupTab);
            } else if (tab === 'flutterwave') {
                showForm(flutterwaveSetupForm);
                activateTab(flutterwaveTab);
            } else if (tab === 'paystack') {
                showForm(paystackSetupForm);
                activateTab(paystackTab);
            } else {
                showForm(generalForm);
                activateTab(generalTab);
            }

            generalTab.addEventListener('click', function() {
                showForm(generalForm);
                activateTab(generalTab);
            });

            emailSetupTab.addEventListener('click', function() {
                showForm(emailSetupForm);
                activateTab(emailSetupTab);
            });

            flutterwaveTab.addEventListener('click', function() {
                showForm(flutterwaveSetupForm);
                activateTab(flutterwaveTab);
            });

            paystackTab.addEventListener('click', function() {
                showForm(paystackSetupForm);
                activateTab(paystackTab);
            });

            //  1. site settings post request
            document.getElementById('general-save-btn').addEventListener('click', function() {
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
                            alertContainer.innerHTML = '<div class="alert alert-success">' + data
                                .message + '</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const alertContainer = document.getElementById('alert-container');
                        alertContainer.innerHTML =
                            '<div class="alert alert-danger">An error occurred. Please try again.</div>';
                    });
            });

            //  2. email setting post request
            document.getElementById('email-save-btn').addEventListener('click', function() {
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
                            alertContainer.innerHTML = '<div class="alert alert-success">' + data
                                .message + '</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const alertContainer = document.getElementById('alert-container');
                        alertContainer.innerHTML =
                            '<div class="alert alert-danger">An error occurred. Please try again.</div>';
                    });
            });

            //  3. flutterwave setting post request
            document.getElementById('flutterwave-save-btn').addEventListener('click', function() {
                const formData = new FormData(document.getElementById('flutterwave-settings-form'));
                fetch('{{ route('admin.flutterwave.setup') }}', {
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
                            alertContainer.innerHTML = '<div class="alert alert-success">' + data
                                .message + '</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const alertContainer = document.getElementById('alert-container');
                        alertContainer.innerHTML =
                            '<div class="alert alert-danger">An error occurred. Please try again.</div>';
                    });
            });

            //  4. paystack setting post request
            document.getElementById('paystack-save-btn').addEventListener('click', function() {
                const formData = new FormData(document.getElementById('paystack-settings-form'));
                fetch('{{ route('admin.paystack.setup') }}', {
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
                            alertContainer.innerHTML = '<div class="alert alert-success">' + data
                                .message + '</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const alertContainer = document.getElementById('alert-container');
                        alertContainer.innerHTML =
                            '<div class="alert alert-danger">An error occurred. Please try again.</div>';
                    });
            });
        });
    </script>


@endsection
