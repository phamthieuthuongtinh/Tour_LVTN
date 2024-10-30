@extends('layouts.app')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Quản lý Lịch Làm Việc</h3>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('staffs.add_task') }}" method="POST">
            @csrf
            <div class="card-body">
                <!-- Chọn loại tour -->
                <div class="form-group">
                    <label for="type_id">Chọn loại tour</label>
                    <select name="type_id" id="type_id" class="form-control">
                        <option value="">-- Chọn loại tour --</option>
                        @foreach ($type as $t)
                            <option value="{{ $t->id }}">{{ $t->type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="cate">Chọn nước du lịch</label>
                    <select name="cate" id="cate" class="form-control" disabled>
                        <option value="">-- Chọn nước du lịch --</option>
                        <option value="6">Ngoài nước</option>
                        <option value="5">Trong nước</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cate_id">Chọn địa điểm du lịch</label>
                    <select name="cate_id" id="cate_id" class="form-control" disabled>
                        <option value="">-- Chọn địa điểm du lịch --</option>
                        <!-- Danh sách tour sẽ được cập nhật động ở đây -->
                    </select>
                </div>
                <!-- Chọn tour -->
                <div class="form-group">
                    <label for="tour_id">Chọn tour</label>
                    <select name="tour_id" id="tour_id" class="form-control" disabled>
                        <option value="">-- Chọn tour --</option>
                        <!-- Danh sách tour sẽ được cập nhật động ở đây -->
                    </select>
                </div>

                <!-- Chọn ngày -->
                <div class="form-group">
                    <label for="departure_date">Chọn ngày làm việc</label>
                    <select name="departure_date" id="departure_date" class="form-control" disabled>
                        <option value="">-- Chọn ngày--</option>
                        <!-- Danh sách tour sẽ được cập nhật động ở đây -->
                    </select>
                </div>
                <input type="hidden" value="{{ $staff->id }}" name="staff_id">
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
        </form>
    </div>
    <div class="card-header" style="background-color: #c21aa6">
        <h3 class="card-title">Tất Cả Lịch Của Nhân Viên {{$staff->name}}</h3>
    </div>
    <div class="card">
        <div class="card-header border-0">
            <div class="card-tools">
                <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                </a>
                <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle" id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tour</th>
                        <th>Ngày khởi hành</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <style>
                    .deleted-tour {
                        background-color: #4d4d4d !important;
                    }

                    .disabled-link {
                        color: gray;
                        pointer-events: none;
                        text-decoration: none;
                    }
                </style>
                <tbody>
                    @foreach ($stafftours as $key => $stfftour)
                        <tr class="{{ $stfftour->status == 0 ? 'deleted-tour' : '' }}">
                            <td>{{ $key }}</td>
                            <td><a href="{{route('chi-tiet-tour',[$stfftour->tour->slug])}}">{{ $stfftour->tour->title }}</a></td>
                            <td>{{ $stfftour->departure_date }}</td>

                            


                            <td>

                                @if ($stfftour->status == 1)
                                    {{-- <a href="{{ route('departures.edit', [$depart->id]) }}" class="btn btn-warning">
                                        Sửa
                                    </a>
                                    <br>
                                    <br> --}}
                                    <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?');"
                                        action="{{ route('staffs.destroy_task', [$stfftour->id]) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger" title="Xóa">
                                            <i class="fas fa-times"></i> <!-- Biểu tượng "Times" -->
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" onsubmit="return confirm('Bạn có chắc khôi phục?');"
                                        action="{{ route('staffs.destroy_task', [$stfftour->id]) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-warning" title="Khôi phục">
                                            <i class="fa fa-recycle"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- JavaScript để cập nhật danh sách tour theo loại tour -->
    <script>
        var tours = @json($tour);
        var categories = @json($category);
        var departures = @json($departure);
        document.getElementById('type_id').addEventListener('change', function() {
            var typeId = this.value;
            var cateSelect = document.getElementById('cate');
            var cate2Select = document.getElementById('cate_id');
            var tourSelect = document.getElementById('tour_id');

            // Xóa các option cũ
            cateSelect.innerHTML = '<option value="">-- Chọn nước du lịch --</option>';
            cate2Select.innerHTML = '<option value="">-- Chọn địa điểm du lịch --</option>';
            tourSelect.innerHTML = '<option value="">-- Chọn tour --</option>';

            cate2Select.disabled = true;
            tourSelect.disabled = true;

            if (typeId) {
                cateSelect.disabled = false;
                cateSelect.innerHTML = `
                <option value="">-- Chọn nước du lịch --</option>
                <option value="5">Trong nước</option>
                <option value="6">Ngoài nước</option>
            `;
            }
        });

        document.getElementById('cate').addEventListener('change', function() {
            var selectedCountry = this.value;
            var cate2Select = document.getElementById('cate_id');

            // Xóa các option cũ
            cate2Select.innerHTML = '<option value="">-- Chọn địa điểm du lịch --</option>';
            cate2Select.disabled = true;

            if (selectedCountry) {
                // Lọc các danh mục theo `category_parent` tương ứng
                var filteredCategories = categories.filter(category => category.category_parent == selectedCountry);

                // Thêm các option vào dropdown
                filteredCategories.forEach(category => {
                    var option = document.createElement('option');
                    option.value = category.id;
                    option.text = category.title;
                    cate2Select.appendChild(option);
                });

                cate2Select.disabled = false;
            }
        });

        document.getElementById('cate_id').addEventListener('change', function() {
            var cateId = this.value;
            var typeId = document.getElementById('type_id').value;
            var tourSelect = document.getElementById('tour_id');

            // Xóa các option cũ
            tourSelect.innerHTML = '<option value="">-- Chọn tour --</option>';
            tourSelect.disabled = true;

            if (cateId && typeId) {
                // Lọc danh sách các tour theo `type_id` và `cate_id`
                var filteredTours = tours.filter(tour => tour.type_id == typeId && tour.category_id == cateId);

                // Thêm các option vào dropdown
                filteredTours.forEach(tour => {
                    var option = document.createElement('option');
                    option.value = tour.id;
                    option.text = tour.title;
                    tourSelect.appendChild(option);
                });

                tourSelect.disabled = false;
            }
        });
        document.getElementById('tour_id').addEventListener('change', function() {
            var tourId = this.value;
            var cateId = document.getElementById('cate_id').value;
            var typeId = document.getElementById('type_id').value;
            var departureSelect = document.getElementById('departure_date');

            // Xóa các option cũ
            departureSelect.innerHTML = '<option value="">-- Chọn ngày --</option>';
            departureSelect.disabled = true;

            if (cateId && typeId && tourId) {
                // Lọc danh sách các tour theo `type_id` và `cate_id`
                var filteredDepartures = departures.filter(departure => departure.tour_id == tourId);

                // Thêm các option vào dropdown
                filteredDepartures.forEach(departure => {
                    var option = document.createElement('option');
                    option.value = departure.departure_date;
                    option.text = departure.departure_date;
                    departureSelect.appendChild(option);
                });

                departureSelect.disabled = false;
            }
        });
    </script>
@endsection
