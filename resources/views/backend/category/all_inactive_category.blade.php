@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
            </ol>
        </nav>


        {{-- ALL brand --}}
        <div class="row col">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Inactive Category ({{ count($inactive_category) }})</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Logo</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="brandTableBody">
                                    @if ($inactive_category && count($inactive_category) > 0)
                                        @foreach ($inactive_category as $key => $item)
                                            <tr data-id="{{ $item->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td><img src="{{ !empty($item->image) ? url($item->image) : url('upload/no_image.jpg') }}"
                                                        style="width:70px; height:40px;"> </td>
                                                <td>
                                                    @if ($item->status == 'active')
                                                        <span class="badge rounded-pill bg-success">Active</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">InActive</span>
                                                    @endif
                                                </td>
                                                <td>

                                                    <a class="btn toggle-class {{ $item->status == 'active' ? 'btn-inverse-success' : 'btn-inverse-danger' }}"
                                                        title="Status" data-id="{{ $item->id }}"
                                                        data-status="{{ $item->status }}">
                                                        <i
                                                            data-feather="{{ $item->status == 'active' ? 'toggle-left' : 'toggle-right' }}"></i>
                                                    </a>

                                                    <a class="btn btn-danger" title="Delete" href="javascript:void(0);"
                                                        data-id="{{ $item->id }}" data-action="delete">
                                                        <i data-feather="trash"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No data available</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Change Status --}}
    <script type="text/javascript">
        $(function() {
            // Add CSRF token to all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Toggle brand status on button click
            $('.toggle-class').click(function() {
                var $this = $(this);
                var status = $this.attr('data-status');
                var category_id = $this.data('id');
                console.log($('meta[name="csrf-token"]').attr('content'));


                $.ajax({
                    type: "POST", // Use POST for status change
                    dataType: "json",
                    url: '{{ route('category.change.status') }}',
                    data: {
                        'status': status,
                        'category_id': category_id,
                    },
                    success: function(data) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        if (!data.error) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Status Updated Successfully'
                            });

                            var $statusSpan = $this.closest('tr').find('.status-span');
                            if (data.status === 'inactive') {
                                $this.removeClass('btn-inverse-success').addClass(
                                    'btn-inverse-danger');
                                $this.find('i').attr('data-feather', 'toggle-right');
                                $statusSpan.removeClass('bg-success').addClass('bg-danger')
                                    .text('Inactive');
                            } else {
                                $this.removeClass('btn-inverse-danger').addClass(
                                    'btn-inverse-success');
                                $this.find('i').attr('data-feather', 'toggle-left');
                                $statusSpan.removeClass('bg-danger').addClass('bg-success')
                                    .text('Active');
                            }

                            $this.attr('data-status', data.status);
                            feather.replace(); // Re-initialize Feather icons
                            window.location.reload();
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: data.error
                            });
                        }
                    }
                });
            });
        });
    </script>

    {{-- Delete Category --}}
    <script type="text/javascript">
        $(document).on('click', '.btn-danger', function(e) {
            e.preventDefault(); // Prevent the default behavior
            var id = $(this).data('id'); // Get the data-id from the button
            var url = '{{ route('category.delete', ':id') }}';
            url = url.replace(":id", id); // Replace placeholder with actual ID

            // SweetAlert confirmation popup
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with AJAX request if the user confirms
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}" // Include CSRF token for security
                        },
                        success: function(response) {
                            if (response.success) {
                                // SweetAlert for success
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );

                                // Find the specific row (tr) and fade it out, then remove it
                                $('#brandTableBody tr').each(function() {
                                    var rowId = $(this).data(
                                        'id'); // Get the row's data-id
                                    if (rowId == id) {
                                        $(this).fadeOut(500, function() {
                                            $(this)
                                                .remove(); // Remove the item after fading out
                                        });
                                    }
                                });

                                toastr.success('Deleted Successfully.');
                            } else {
                                toastr.error('Failed to delete the item.');
                            }
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred while deleting the item.');
                            console.log(xhr); // Log the error for debugging
                        }
                    });
                }
            });
        });
    </script>



@endsection
