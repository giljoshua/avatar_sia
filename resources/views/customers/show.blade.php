<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Customer Details</h2>
                    <a class="btn btn-primary" href="{{ route('customers.index') }}">Back</a>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>{{ $customer->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>ID:</strong> {{ $customer->id }}
                            </div>
                            <div class="col-md-6">
                                <strong>Name:</strong> {{ $customer->name }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <strong>Address:</strong> {{ $customer->address }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Gender:</strong> {{ $customer->gender }}
                            </div>
                            <div class="col-md-6">
                                <strong>Date of Birth:</strong> {{ $customer->dob }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Created At:</strong> {{ $customer->created_at->format('Y-m-d H:i:s') }}
                            </div>
                            <div class="col-md-6">
                                <strong>Updated At:</strong> {{ $customer->updated_at->format('Y-m-d H:i:s') }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>