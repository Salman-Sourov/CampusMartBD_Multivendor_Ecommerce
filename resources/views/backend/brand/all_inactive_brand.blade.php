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
                        <h6 class="card-title">All Inactive Brand  ({{count($inactive_brands)}})</h6>

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
                                    @if ($inactive_brands && count($inactive_brands) > 0)
                                        @foreach ($inactive_brands as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td><img src="{{ !empty($item->logo) ? url($item->logo) : url('upload/no_image.jpg') }}"
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
                                                        title="Status" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                                                         <i data-feather="{{ $item->status == 'active' ? 'toggle-left' : 'toggle-right' }}"></i>
                                                     </a>
                                                    

                                                    {{-- <button type="button" class="btn btn-inverse-warning"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        id="{{ $item->id }}" onclick="brandEdit(this.id)">
                                                        Edit
                                                    </button> --}}

                                                    {{-- <a href="javascript:void(0);" class="btn btn-inverse-danger delete-btn"
                                                        data-id="{{ $item->id }}" title="Delete">Delete
                                                    </a> --}}


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
                var brand_id = $this.data('id');
                console.log($('meta[name="csrf-token"]').attr('content'));

    
                $.ajax({
                    type: "POST",  // Use POST for status change
                    dataType: "json",
                    url: '{{ route('brand.change.status') }}',
                    data: {
                        'status': status,
                        'brand_id': brand_id,
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
                                $this.removeClass('btn-inverse-success').addClass('btn-inverse-danger');
                                $this.find('i').attr('data-feather', 'toggle-right');
                                $statusSpan.removeClass('bg-success').addClass('bg-danger').text('Inactive');
                            } else {
                                $this.removeClass('btn-inverse-danger').addClass('btn-inverse-success');
                                $this.find('i').attr('data-feather', 'toggle-left');
                                $statusSpan.removeClass('bg-danger').addClass('bg-success').text('Active');
                            }
    
                            $this.attr('data-status', data.status);
                            feather.replace(); // Re-initialize Feather icons
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
    
    


@endsection
