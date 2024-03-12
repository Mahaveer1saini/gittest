@extends('front.layouts.app')
@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
                  @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                     @endif
                     @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                     @endif
        <div class="row">
            <div class="col-lg-3">
                @include('front\layouts\acconut\sidebar')
            </div>
            <div class="col-lg-9">
             @include('front\message')
             <form action="" method="post" id="editJodForm" name="editJodForm">
             @csrf
                <div class="card border-0 shadow mb-4 ">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1"> Edit Job </h3>
                        
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Title<span class="req">*</span></label>
                                    <input type="text" placeholder="Job Title" id="title" name="title" class="form-control" value="{{$jods->title}}">
                                    <p id="title-error" class="invalid-feedback"></p>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category" id="category" class="form-control">
                                       @if($categories->isNotEmpty())
                                        <option value="">Select a Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $jods->categories_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                        @endif
                                        <p class="invalid-feedback"></p>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                    <select name="jodtype" id="jodtype" class="form-control">
                                       @if($jodtype->isNotEmpty())
                                        <option value="">Job Nature</option>
                                        @foreach($jodtype as $jodtype)
                                            <option value="{{ $jodtype->id }}"{{ $jods->jodtype_id == $jodtype->id ? 'selected' : '' }}>
                                                {{ $jodtype->name }}</option>
                                        @endforeach
                                        @endif
                                        <p class="invalid-feedback"></p>
                                    </select>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                    <input type="number" min="1" placeholder="Vacancy" id="vacancy"  value="{{$jods->vacancy}}" name="vacancy" class="form-control">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Salary</label>
                                    <input type="text" placeholder="Salary" id="salary" name="salary" value="{{$jods->salary}}" class="form-control">
                                    <p class="invalid-feedback"></p>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location<span class="req">*</span></label>
                                    <input type="text" placeholder="location" id="location"  value="{{$jods->location}}" name="location" class="form-control">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Description<span class="req">*</span></label>
                                <textarea class="form-control" name="description" id="description"  value="{{$jods->description}}" cols="5" rows="5" placeholder="Description"></textarea>
                                <p class="invalid-feedback"></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Benefits</label>
                                <textarea class="form-control" name="benefits" id="benefits"  value="{{$jods->benefits}}" cols="5" rows="5" placeholder="Benefits"></textarea>
                                <p class="invalid-feedback"></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Responsibility</label>
                               <textarea class="form-control" name="responsibility"  value="{{$jods->responsibility}}"  id="responsibility" cols="5" rows="5" placeholder="Responsibility"></textarea>
                               <p class="invalid-feedback"></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Qualifications</label>
                                <textarea class="form-control" name="qualifications" id="qualifications"   value="{{$jods->qualifications}}" cols="5" rows="5" placeholder="Qualifications"></textarea>
                                <p class="invalid-feedback"></p>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">experience <span class="req">*</label>
                                <select class="form-select"  name="experience" id="experience">
                                    <option value="1" {{ $jods->experience == 1 ? 'selected' : '' }}>1 year</option>
                                    <option value="2" {{ $jods->experience == 2 ? 'selected' : '' }}>2 year</option>
                                    <option value="3" {{ $jods->experience == 3 ? 'selected' : '' }} >3 year</option>
                                    <option value="4" {{ $jods->experience == 4 ? 'selected' : '' }}>4 year</option>
                                    <option value="5" {{ $jods->experience == 5 ? 'selected' : '' }}>5 year</option>
                                    <option value="6" {{ $jods->experience == 6 ? 'selected' : '' }}>6 year</option>
                                    <option value="7" {{ $jods->experience == 7 ? 'selected' : '' }}>7 year</option>
                                    <option value="8" {{ $jods->experience == 8 ? 'selected' : '' }}>8 year</option>
                                    <option value="9" {{ $jods->experience == 9 ? 'selected' : '' }}>9 year</option>
                                    <option value="10" {{ $jods->experience == 10 ? 'selected' : '' }}>10 year</option>
                                    <option value="10_plus" {{ $jods->experience == '10_plus' ? 'selected' : '' }}>11 year</option>
                                    <p class="invalid-feedback"></p>
                                </select>
                            </div>
                            
                            

                            <div class="mb-4">
                                <label for="" class="mb-2">Keywords</span></label>
                                <input type="text" placeholder="keywords" id="keywords" name="keywords"   value="{{$jods->keywords}}" class="form-control">
                                <p class="invalid-feedback"></p>
                            </div>

                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Name<span class="req">*</span></label>
                                    <input type="text" placeholder="Company Name" id="company_name" name="company_name"   value="{{$jods->company_name}}" class="form-control">
                                    <p class="invalid-feedback"></p>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location</label>
                                    <input type="text" placeholder="Location" id="company_location"  value="{{$jods->company_location}}" name="company_location" class="form-control">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Website</label>
                                <input type="text" placeholder="company_website" id="company_website" value="{{$jods->company_website}}" name="company_website" class="form-control">
                                <p class="invalid-feedback"></p>
                            </div>
                        </div> 
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Save Job</button>
                        </div> 
                    </div> 
                   
                    </from>          
                </div>
           </div>
        </div>
</section>
@endsection
@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $("#editJodForm").submit(function(e) {
            e.preventDefault();
            $($button[type ='submit'].prop('disabled',true));

            $.ajax({
                url: '{{ route("account.updateJob", $jods->id) }}',
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {

                    $($button[type ='submit'].prop('disabled',false));
                    window.location.href = "{{ route('account.editJod') }}";
                    // Handle success, maybe redirect or show a success message
                    console.log(response);

                    // Redirect to the specified route after a successful form submission
                   
                },
                error: function(response) {
                    // Handle errors and display validation messages
                    var errors = response.responseJSON.errors;

                    $.each(errors, function(field, message) {
                        handleValidation(field, message[0]);
                    });

                    // Handle general error or other logic
                }
            });
        });

        function handleValidation(field, error) {
            $("#" + field).addClass('is-invalid');
            $("#" + field + '-error').html(error);
        }
    });
</script>
@endsection
