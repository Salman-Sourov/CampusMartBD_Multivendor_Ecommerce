@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

    {{-- ALL Order --}}
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">All Order</h6>

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
                                @if ($brands && count($brands) > 0)
                                    @foreach ($brands as $key => $item)
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

                                                {{-- <a class="btn toggle-class {{ $item->status == 'active' ? 'btn-inverse-success' : 'btn-inverse-danger' }}"
                                                    title="Status" data-id="{{ $item->id }}"
                                                    data-status="{{ $item->status }}">

                                                    <i
                                                        data-feather="{{ $item->status == 'active' ? 'toggle-left' : 'toggle-right' }}"></i>
                                                </a> --}}

                                                <button type="button" class="btn btn-inverse-warning"
                                                    data-bs-toggle="modal" data-bs-target="#editModal"
                                                    id="{{ $item->id }}" onclick="brandEdit(this.id)">
                                                    Edit
                                                </button>

                                                {{-- <button type="button" class="btn btn-inverse-danger"
                                                    data-id="{{ $item->id }}" id="delete">Delete</button> --}}

                                                <a href="javascript:void(0);"
                                                    class="btn btn-inverse-danger delete-btn"
                                                    data-id="{{ $item->id }}" title="Delete">Delete
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

@endsection