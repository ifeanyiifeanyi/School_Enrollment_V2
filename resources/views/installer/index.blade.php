<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Installer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Application Installer</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('install.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="db_name" class="form-label">Database Name</label>
                                <input type="text" name="db_name" id="db_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="db_username" class="form-label">Database Username</label>
                                <input type="text" name="db_username" id="db_username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="db_password" class="form-label">Database Password</label>
                                <input type="password" name="db_password" id="db_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="db_port" class="form-label">Database Port</label>
                                <input type="number" name="db_port" id="db_port" class="form-control" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="link_storage" id="link_storage" class="form-check-input">
                                <label for="link_storage" class="form-check-label">Link Storage Folder</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Install</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
