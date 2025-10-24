@extends('agent.agent_dashboard')
@section('agent')

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
            </ol>
        </nav>


        {{-- ALL Inactive Product --}}
        <div class="row col">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Inactive Category ({{ count($inactive_product) }})</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Product Name</th>
                                        <th>Image</th>
                                        <th>Sale Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="brandTableBody">
                                    @if ($inactive_product && count($inactive_product) > 0)
                                        @foreach ($inactive_product as $key => $item)
                                            <tr data-id="{{ $item->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td><img src="{{ asset($item->thumbnail) }}"
                                                        style="width:70px; height:40px;">
                                                </td>
                                                <td>{{ $item->sale_price }}</td>
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
                var product_id = $this.data('id');
                console.log('Token:', $('meta[name="csrf-token"]').attr('content'));

                $.ajax({
                    type: "POST", // Use POST for status change
                    dataType: "json",
                    url: '{{ route('product.change.status') }}',
                    data: {
                        'status': status,
                        'product_id': product_id,
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
                            setTimeout(function() {
                                window.location
                                    .reload(); // Reload the page to see the new brand
                            }, 100);
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

    {{-- Delete Product --}}
    <script type="text/javascript">
        $(document).on('click', '.btn-danger', function(e) {
            e.preventDefault(); // Prevent the default behavior
            var id = $(this).data('id'); // Get the data-id from the button\
            console.log(id);
            var url = '{{ route('product.delete', ':id') }}';
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
                        type: 'POST', // Using POST method with _method for DELETE simulation
                        url: url, // Ensure the URL is correct (dynamically passed)
                        success: function(response) {
                            console.log('Response received:',
                                response); // For debugging, check the response

                            if (response.success) {
                                // SweetAlert for success
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );
                                $('#brandTableBody tr[data-id="' + id + '"]').fadeOut(500,
                                    function() {
                                        $(this)
                                            .remove(); // Remove the item after fading out
                                    });

                                toastr.success('Deleted Successfully.');
                            } else {
                                toastr.error(response.message || 'Failed to delete the item.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error details:', xhr, status,
                                error); // Log the error for debugging
                            toastr.error('An error occurred while deleting the item.');
                        }
                    });

                }
            });
        });
    </script>

@endsection
