@extends('adminlte::page')

@section('title', 'Admin | List courses')

@section('content_header')
    <h1>List courses</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('admin.courses.create') }}" class="text-success">
                    <i class="fas fa-plus text-success"></i> Create new course
                </a>
            </h3>
            <form action="{{route('admin.courses.index')}}" method="GET">
                <div class="row justify-content-end">
                    <div class="col-3">
                        <div class="form-group">
                            <label>Class:</label>
                            <select class="form-control" style="width: 100%;" name="class_id">
                                <option value="">All</option>
                                @foreach($classes as $class)
                                    <option value="{{$class->id}}"
                                        @if(isset($params['class_id']) && $params['class_id'] == $class->id) selected @endif>
                                        {{ucfirst($class->name)}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Subject:</label>
                            <select class="form-control" style="width: 100%;" name="subject_id">
                                <option value="">All</option>
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}"
                                        @if(isset($params['subject_id']) && $params['subject_id'] == $subject->id) selected @endif>
                                        {{ucfirst($subject->name)}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Semester:</label>
                            <select class="form-control" style="width: 100%;" name="semester_id">
                                <option value="">All</option>
                                @foreach($semesters as $semester)
                                    <option value="{{$semester->id}}"
                                        @if(isset($params['semester_id']) && $params['semester_id'] == $semester->id) selected @endif>
                                        {{ucfirst($semester->name)}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-2">
                        <div class="form-group">
                            <label>Status:</label>
                            <select class="form-control" style="width: 100%;" name="status">
                                <option value="">All</option>
                                <option value="1" @if(isset($params['status']) && $params['status'] == 1) selected @endif>
                                    Active
                                </option>
                                <option value="0" @if(isset($params['status']) && $params['status'] == 0) selected @endif>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Quantity:</label>
                            <select class="form-control" style="width: 100%;" name="limit">
                                <option value="5" @if($params['limit'] == 5) selected @endif>5</option>
                                <option value="10" @if($params['limit'] == 10) selected @endif>10</option>
                                <option value="50" @if($params['limit'] == 50) selected @endif>50</option>
                                <option value="100" @if($params['limit'] == 100) selected @endif>100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="form-group mb-0 pt-4">
                            <a href="{{route('admin.courses.index')}}" class="btn btn-block btn-default">Clear</a>
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-end">
                    <div class="input-group col-8">
                        <input type="search" name="keyword" class="form-control" placeholder="Type your keywords here" 
                                value="@if(isset($params['keyword'])){{$params['keyword']}}@endif">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-info">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr style="background-color:#00a4c5e0;">
                        <th class="text-center">#</th>
                        <th class="text-center">Class</th>
                        <th class="text-center">Subject</th>
                        <th class="text-center">Trainer</th>
                        <th class="text-center">Semester</th>
                        <th class="text-center">Time</th>
                        <th class="text-center">Status</th>
                        <th colspan="3" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td class="text-center align-middle">{{ ($courses->currentPage() - 1)  * $courses->perpage() + $loop->iteration }}</td>
                            <td class="align-middle">{{ $course->class->name }}</td>
                            <td class="align-middle">{{ $course->subject->name }}</td>
                            <td class="align-middle">{{ $course->trainer->name }}</td>
                            <td class="align-middle">{{ $course->semester->name }}</td>
                            <td class="align-middle">From {{ date('d/m/Y', strtotime($course->start_date)) }} to {{date('d/m/Y', strtotime($course->end_date))}}</td>
                            @if ($course->status)
                                <td class="align-middle text-center">
                                    <span class="right badge badge-success">Active</span>
                                </td>
                            @else
                                <td class="align-middle text-center">
                                    <span class="right badge badge-danger">Disactive</span>
                                </td>
                            @endif
                            <td class="text-center align-middle"><a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-info"><i class="fas fa-lg fa-info-circle"></i></a></td>
                            <td class="text-center align-middle"><a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
                            <td class="text-center align-middle">
                                <form id="deleteElement-{{$course->id}}" action="{{ route('admin.courses.destroy',$course->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onClick="deleteAction(event, {{ $course->id }})" class="btn btn-danger"><i class="fas fa-trash text-white"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 justify-content-center">
                {{ $courses->links('vendor.pagination.custom-basic-admin', ['params' => $params]) }}
            </ul>
        </div>
    </div>
@stop

@section('css')

@stop


@section('js')
    
@stop