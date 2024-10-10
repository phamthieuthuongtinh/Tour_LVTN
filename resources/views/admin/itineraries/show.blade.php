@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Tất Cả Ngày</h3>
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
   <!-- /.card-header -->
   <!-- form start -->
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
                            <th>Ngày</th>
                            <th>Địa điểm</th>
                            <th>Mô tả chính</th>
                            <th>Hình ảnh</th>
                     
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= $tour->so_ngay; $i++)
                            <tr>
                                <td>Ngày {{$i}}</td>
                                
                                @php
                                    $currentItinerary = $itineraries->where('day_number', $i)->first();
                                    $currentItineraryDetails = $itineraryDetails[$i] ?? [];
                                @endphp
                
                                @if ($currentItinerary)
                                    <td>{{ $currentItinerary->location }}</td>
                                    <td>{!! $currentItinerary->description !!}</td>
                                    
                                    <td><img width="100" height="100" src="{{ asset('upload/tours/' . $currentItinerary->image) }}" alt=""></td>
                                    <td>
                                        <a href="{{ route('itineraries.change',['tour_id' => $tour_id ,'day_number' => $i]) }}" class="btn btn-warning" title="Cập nhật"> 
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                @else
                                    <td>Không có thông tin</td>
                                    <td>Không có thông tin</td>
                                    <td>Không có thông tin</td>
                                    <td>
                                        <a href="{{ route('itineraries.add', ['day_number' => $i, 'tour_id' => $tour_id]) }}" class="btn btn-warning" title="Chính sửa">
                                            <i class="fas fa-edit"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endfor
                    </tbody>
                </table>
                
              </div>
            </div>
</div>
@endsection