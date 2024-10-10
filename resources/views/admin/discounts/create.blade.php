@extends('layouts.app')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Thêm Tour Giảm Giá</h3>
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

        <form action="{{ route('discounts.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <!-- Chọn loại tour -->
                <div class="form-group">
                    <label for="type_id">Chọn loại tour</label>
                    <select name="type_id" id="type_id" class="form-control">
                        <option value="">-- Chọn loại tour --</option>
                        @foreach($type as $t)
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

                <!-- Mức giảm giá -->
                <div class="form-group">
                    <label for="rate">Mức giảm giá (%)</label>
                    <input type="number" name="rate" class="form-control" id="rate" placeholder="Nhập mức giảm giá" min="1" max="100">
                </div>

                <!-- Thời gian bắt đầu -->
                <div class="form-group">
                    <label for="start">Ngày bắt đầu</label>
                    <input type="date" name="start" class="form-control" id="start">
                </div>

                <!-- Thời gian kết thúc -->
                <div class="form-group">
                    <label for="end">Ngày kết thúc</label>
                    <input type="date" name="end" class="form-control" id="end">
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
        </form>
    </div>

    <!-- JavaScript để cập nhật danh sách tour theo loại tour -->
    <script>
        var tours = @json($tour);
        var categories = @json($category);

        document.getElementById('type_id').addEventListener('change', function () {
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

        document.getElementById('cate').addEventListener('change', function () {
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

        document.getElementById('cate_id').addEventListener('change', function () {
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
    </script>
@endsection
