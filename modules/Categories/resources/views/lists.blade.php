@extends('layouts.backend')
@section('content')
<p><a href="{{route('admin.categories.create')}}" class="btn btn-primary">Thêm mới</a></p>
@if (session('msg'))
<div class="alert alert-success">{{session('msg')}}</div>
@endif
<table id="datatable" class="table table-bordered">
    <thead>
        <tr>
            <th>Tên</th>
            <th>Link</th>
            <th>Thời gian</th>
            <th>Sửa</th>
            <th>Xóa</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Tên</th>
            <th>Link</th>
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
                pageLength:5,
                serverSide: true,
                ajax: "{{ route('admin.categories.data') }}",
                columns: [{
                        data: 'name',
                    },
                    {
                        data:'link'
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
@endsection