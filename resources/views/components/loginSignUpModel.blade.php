<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-3 shadow-sm">

            <!-- Modal Header with Close Button -->
            <div class="d-flex justify-content-end p-2">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 pt-0">
                <!-- Tabs Nav -->
                <ul class="nav nav-tabs justify-content-center mb-4" id="authTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login"
                            type="button" role="tab" aria-controls="login" aria-selected="true">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup"
                            type="button" role="tab" aria-controls="signup" aria-selected="false">Sign Up</button>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content" id="authTabsContent">
                    <!-- Login Tab -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <div class="text-center mb-3">
                            <h5 class="fw-semibold text-uppercase">Login to your account</h5>
                        </div>
                        <form id="loginForm" class="d-grid gap-3"> @csrf
                          <div class="mb-3">
                            <input type="email" name="email" placeholder="Email" class="form-control">
                            <span class="invalid-feedback d-block small error-email"></span>
                          </div>
                          <div class="mb-3">
                            <input type="password" name="password" placeholder="Password" class="form-control">
                            <span class="invalid-feedback d-block small error-password"></span>
                          </div>
                            <button type="submit" class="btn btn-dark w-100 text-uppercase">Login</button>
                        </form>
                    </div>

                    <!-- Sign Up Tab -->
                    <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                        <div class="text-center mb-3">
                            <h5 class="fw-semibold text-uppercase">Create a new account</h5>
                        </div>
                        <form id="signupForm" class="d-grid gap-3">
                            @csrf

                            <div class="mb-2">
                                <input type="text" name="name" placeholder="Name" class="form-control">
                                <span class="invalid-feedback d-block small error-name"></span>
                            </div>

                            <div class="mb-2">
                                <input type="email" name="email" placeholder="Email" class="form-control">
                                <span class="invalid-feedback d-block small error-email"></span>
                            </div>

                            <div class="mb-2">
                                <input type="password" name="password" placeholder="Password" class="form-control">
                                <span class="invalid-feedback d-block small error-password"></span>
                            </div>

                            <div class="mb-2">
                                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                    class="form-control">
                                <span class="invalid-feedback d-block small error-password_confirmation"></span>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 text-uppercase">Sign Up</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .tab-pane {
        opacity: 0;
        transform: translateX(30px);
        transition: all 0.4s ease;
    }

    .tab-pane.active.show {
        opacity: 1;
        transform: translateX(0);
    }
</style>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#signupForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: "{{ route('auth.register') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                      if (response.success) {
                        toastr.success(response.message);
                        $('#signupForm')[0].reset();
                        $('#exampleModal').modal('hide');
                      }
                    },
                    error: function(xhr) {
                      if (xhr.status == 422) {
                        const errors = xhr.responseJSON.errors;
                        console.log(errors);
                        $('.error-name').text(errors.name);
                        $('.error-email').text(errors.email);
                        $('.error-password').text(errors.password);
                        $('.error-password_confirmation').text(errors.password);
                      } else {
                        toastr.error('Something went wrong');
                      }
                    }
                });
            })

            $('#loginForm').on('submit', function(event) {
              event.preventDefault();
              $.ajax({
                url: "{{ route('auth.login') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                  if (response.success) {
                    toastr.success(response.message);
                    location.reload();
                    $('#loginForm')[0].reset();
                    $('#exampleModal').modal('hide');
                  }
                },
                error: function(xhr) {
                  if (xhr.status == 422) {
                    const errors = xhr.responseJSON.errors;
                    console.log(errors);
                    $('.error-email').text(errors.email);
                    $('.error-password').text(errors.password);
                  } else {
                    toastr.error('Something went wrong');
                  }
                }
              })
            });
        })
    </script>
@endpush
