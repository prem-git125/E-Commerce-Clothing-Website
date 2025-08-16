@extends('layouts.app')

@section('content')
    <section class="section py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar Profile Card -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 rounded-3 text-center p-4">
                        <!-- Profile Avatar -->
                        <div class="mb-3 position-relative">
                            <!-- Hidden file input -->
                            <input type="file" id="profileImageInput" name="profile_url" accept="image/*" class="d-none">

                            <!-- Clickable profile image -->
                            <img src="{{ auth()->user()->profile_url ? Storage::url(auth()->user()->profile_url) : 'https://via.placeholder.com/120' }}"
                                alt="Profile Avatar" id="profileImagePreview"
                                class="rounded-circle img-fluid shadow-sm cursor-pointer"
                                style="width:120px; height:120px; object-fit:cover; cursor:pointer;">

                            <small class="text-muted d-block mt-2">Click image to update</small>
                        </div>

                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted small mb-3">{{ auth()->user()->email }}</p>
                    </div>
                </div>


                <!-- Main Content -->
                <div class="col-md-8">
                    <h3 class="mb-4">My Account</h3>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                data-bs-target="#overview" type="button" role="tab" aria-controls="overview"
                                aria-selected="true">
                                Profile Overview
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders"
                                type="button" role="tab" aria-controls="orders" aria-selected="false">
                                Orders
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address"
                                type="button" role="tab" aria-controls="address" aria-selected="false">
                                Address Book
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings"
                                type="button" role="tab" aria-controls="settings" aria-selected="false">
                                Account Settings
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content border border-top-0 p-4 bg-white shadow-sm rounded-bottom"
                        id="profileTabsContent">

                        <!-- Profile Overview -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel"
                            aria-labelledby="overview-tab">
                            <h5 class="mb-3">Profile Overview</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Name:</strong> {{ auth()->user()->name }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ auth()->user()->email }}</li>
                                <li class="list-group-item"><strong>Phone:</strong> +91 9876543210</li>
                            </ul>
                        </div>

                        <!-- Orders -->
                        <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                            <h5 class="mb-3">My Orders</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>#1001</td>
                                            <td>12 Aug 2025</td>
                                            <td><span class="badge bg-success">Delivered</span></td>
                                            <td>₹1500</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>#1002</td>
                                            <td>10 Aug 2025</td>
                                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                                            <td>₹800</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Address Book -->
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                            <h5 class="mb-3">Saved Addresses</h5>
                            <div class="card p-3 mb-3 shadow-sm border-0">
                                <h6>Home</h6>
                                <p class="mb-0">123, MG Road, Ahmedabad, Gujarat - 380001</p>
                            </div>
                            <div class="card p-3 mb-3 shadow-sm border-0">
                                <h6>Office</h6>
                                <p class="mb-0">456, IT Park, Gandhinagar, Gujarat - 382007</p>
                            </div>
                            <button class="btn btn-outline-primary btn-sm">+ Add New Address</button>
                        </div>

                        <!-- Account Settings -->
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <h5 class="mb-3">Account Settings</h5>
                            <form class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ auth()->user()->email }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" value="+91 9876543210">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" placeholder="Enter new password">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $("#profileImagePreview").on("click", function () {
        $("#profileImageInput").click();
    });

    $("#profileImageInput").on("change", function () {
        if (this.files && this.files[0]) {
            let reader = new FileReader();
            reader.onload = (e) => {
                $("#profileImagePreview").attr("src", e.target.result);
            };
            reader.readAsDataURL(this.files[0]);

            let formData = new FormData();
            formData.append("profile_url", this.files[0]);

            $.ajax({
                url: "{{ route('auth.profile.image.update') }}", 
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                beforeSend: function () {
                    $("#profileImagePreview").css("opacity", "0.6");
                },
                success: function (response) {
                    $("#profileImagePreview").css("opacity", "1");
                    $("#profileImagePreview").attr("src", response.image_url);
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Image Updated',
                        text: 'Your profile image has been successfully updated.',
                        confirmButtonText: 'OK'
                    }); 
                },
                error: function () {
                    alert("Image upload failed. Try again.");
                    $("#profileImagePreview").css("opacity", "1");
                }
            });
        }
    });
});
</script>
@endpush
