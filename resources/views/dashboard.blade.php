@extends('layouts.main')

@section('styles')
<style>
    .jumbotron{
        background-image: url("{{asset('images/new-bg.jpg')}}");
        background-size: cover;
        height: 100%;
        }
    #footer {
        position: relative;
    }
</style>
@endsection

@section('content')
<main role="main">
    @include('components.validation')
    <section class="jumbotron text-center">
            <div class="container">
                <font color="white"><h1 class="jumbotron-heading">Learning Management System</h1>
                <p class="lead text-muted"></p>
                <p>Eget lorem dolor sed viverra ipsum. Enim tortor at auctor urna. Libero enim sed faucibus turpis in eu. Laoreet non curabitur gravida arcu ac tortor dignissim. Pellentesque adipiscing commodo elit at imperdiet. Morbi leo urna molestie at elementum eu facilisis sed odio. Nec feugiat in fermentum posuere urna nec tincidunt praesent. Semper feugiat nibh sed pulvinar. Euismod quis viverra nibh cras pulvinar mattis nunc sed blandit. Etiam dignissim diam quis enim. Sagittis purus sit amet volutpat consequat mauris nunc congue. Eu facilisis sed odio morbi quis commodo. Pellentesque sit amet porttitor eget dolor morbi non arcu.</p>
                </font>
            </div>
        </section>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                @forelse($courses as $course)

                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <a href="course/{{$course->course_slug}}"><img src="@if($course->course_image) {{ asset('images/courses/'.$course->course_image) }} @else {{asset('images/noimage.jpg')}} @endif" width="100%" height="225"/></a>
                            <div class="card-body">
                                <h4><a href="course/{{$course->course_slug}}">{{$course->course_name}}</a></h4>
                                <p class="card-text">{{$course->course_description}}
                                </p>
                              
                                @if($course->enrollees->where('emp_id',Auth::user()->emp_id)->first())
                                    <a href="course/{{$course->course_slug}}"><button class="btn btn-success col-md-12">Resume Course</button></a>
                                @elseif(count($course->modules)>=1 && $course->is_active) 
                                    <a href="course/{{$course->course_slug}}"><button class="btn btn-info col-md-12">View Course</button></a>
                                @else
                                <button class="btn btn-warning col-md-12" disabled>Coming Soon!</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                        <tr>
                            <td colspan="2">No courses found</td>
                        </tr>
                    @endforelse



                </div>
            </div>
        </div>
</main>
@endsection
