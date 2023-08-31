@extends('layouts.backend')
@section('content')
    <p><a href="{{ route('admin.users.create') }}" class="btn btn-primary">Thêm mới</a></p>
    @if (session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif
    <table id="datatable" class="table table-bordered">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>Nhóm</th>
                <th>Thời gian</th>
                <th>Sửa</th>
                <th></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>Nhóm</th>
                <th>Thời gian</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </tr>
        </tfoot>

    </table>
    @include('parts.backend.delete')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#datatable").DataTable({
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.users.data') }}",
                columns: [{
                        data: 'name',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'group_id',
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: 'edit',
                    },
                    {
                        data: 'delete',
                    }
                ]
            });


        });
    </script>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#datatable').on('click', '.btn-remove', function() {
                const id = $(this).data('id');
                const urlDelete = $('#urlDelete').val(); // Lấy giá trị id từ thuộc tính data-id

             

                if (confirm('Bạn có chắc chắn muốn xóa?')) {
        
                    //    console.log(urlDelete +id);
                    $.ajax({
                       
                        url: urlDelete + id,

                        type: 'DELETE',

                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            // Xử lý kết quả sau khi xóa
                            alert('Dữ liệu đã được xóa thành công.');
                            location.reload();
                            // Tùy chỉnh thêm các hành động khác sau khi xóa
                        },
                        error: function(xhr, status, error) {
                            alert('Có lỗi xảy ra khi xóa dữ liệu.');
                            // Xử lý lỗi nếu có
                        }
                    });
                }
            });
        });
    </script>
@endpush
