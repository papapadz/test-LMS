@extends('layouts.main')

@section('content')
<br>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    {{$course->course_name}} - Online Course <a class="btn border-danger btn-sm float-right" href="{{route('homepage')}}"><i class="fa fa-home"></i> Home</a>
                </div>
                <div class="card-body">

                    <div class="card-body" id="content">
                        {!! $course->content !!}
                        <br>
                            @if($attempts['passed'])
                                @if($course->needs_verification)
                                    @if($attempts['verified'])
                                        <a target="_blank" class="text-white btn btn-lg btn-success" href="{{ $attempts['certificate_url'] }}">
                                            <i class="fa fa-trophy" aria-hidden="true"></i>  view certificate
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-warning" disabled>PETRO is still verifying results</button>
                                    @endif
                                @else
                                    <a target="_blank" class="text-white btn btn-lg btn-success" href="{{ $attempts['certificate_url'] }}">
                                        <i class="fa fa-trophy" aria-hidden="true"></i>  view certificate
                                    </a>
                                @endif
                            @elseif($attempts['attempts']<count($course->passingRates) || $empCourse)
                                <a class="btn btn-info btn-lg" href="{{ $url }}">
                                    @if($empCourse)
                                        Resume {{ $empCourse->module->module_name }}
                                    @else
                                        Start Course
                                    @endif
                                </a>
                            @else
                                <a class="btn btn-info btn-lg" href="{{ $url }}">Start Course</a>
                            @endif
                    </div>
                </div>
            </div>
            <br>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 
                            @if($empCourse!=null && $empCourse->finished_date!=null) 100% @elseif($empCourse==null) 0% 
                                @elseif($empCourse->module->module_order <count($modules)) {{ ($empCourse->module->module_order/count($modules)) *100 }}%
                                @elseif($attempts['attempts']<count($course->passingRates)) {{ ($empCourse->module->module_order/count($modules)) *100 }}% 
                                @else 100% 
                            @endif" aria-valuemin="0" aria-valuemax="100">
                            @if($empCourse!=null && $empCourse->finished_date!=null)
                                Completed
                            @elseif($empCourse==null)
                                Not yet started
                            @elseif($empCourse->module->module_order <count($modules))    
                                {{ $empCourse->module->module_order }} of {{ count($modules) }}
                            @elseif($attempts['attempts']<count($course->passingRates))
                                {{ $empCourse->module->module_order }} of {{ count($modules) }}
                            @else
                                Completed
                            @endif
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($modules as $module)
                        <li class="list-group-item @if($empCourse!=null && $empCourse->module->module_order==$loop->iteration && $attempts['attempts']<count($course->passingRates)) bg-primary @endif" @if($loop->iteration>5) hidden @endif>
                            <span class="badge badge-info">{{ $loop->iteration }}</span> 
                            @if($empCourse!=null)
                                @if($empCourse->finished_date!=null || $loop->iteration<$empCourse->module->module_order || $attempts['attempts']>=count($course->passingRates) && $empCourse->module->module_order == $loop->iteration)
                                    <a href="{{route('module', ['course' => $course->course_slug, 'module' => $module->module_slug])}}">{{$module->module_name}}</a>
                                    <i class="fa fa-check-circle text-success float-right"></i>
                                @else
                                    {{$module->module_name}}
                                @endif
                            @else
                                {{$module->module_name}}
                            @endif
                        </li>
                    @endforeach
                    @if($attempts['passed'] || ($empCourse!=null && $empCourse->finished_date!=null))
                    <li class="list-group-item bg-primary">
                        <a class="text-white" href="{{ url($course->course_slug.'/'.'summary') }}"><i class="fa fa-list-ul" aria-hidden="true"></i> Summary</a>
                    </li>
                    @endif
                    @if(count($modules)>5)
                        <li id="view-all-button" class="list-group-item"><button class="btn btn-sm" onclick="loadAll()">View all</button></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function loadAll() {
        $('#view-all-button').remove()
        $('li.list-group-item').prop('hidden',false)
    }
</script>
@endsection