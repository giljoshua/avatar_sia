<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Add New Customer</h2>
                    <a class="btn btn-primary" href="{{ route('customers.index') }}">Back</a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Error!</strong> Please check the form fields.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Customer Name">
                            </div>
                        </div>
                        
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" name="address" rows="3" placeholder="Customer Address"></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>