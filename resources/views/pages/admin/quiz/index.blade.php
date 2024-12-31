@extends('layouts.main')


@section('content')
   
   
   
<style>
  .ratings .fa {
    font-size: 15px; /* Adjust as needed */
}

.ratings .full-star {
    color: #ff9800;
}

.ratings .half-star {
    color: #ff9800;
}

.ratings .empty-star {
    color: gray;
}

</style>

   <!-- dashboard inner -->
   <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Quiz</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     <div class="row column1">
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                           @if(session('role') == 'admin')
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Quiz</h2>
                                 </div>
                                 <div class="heading1 margin_0" style="float: right;">
                                    <h2><a href="{{route('admin.quiz.create')}}" class="btn btn-primary">Create</a></h2>
                                 </div>
                              </div>
                              @endif

                              <div class="full price_table padding_infor_info">
                                 <div class="row">
                                    <!-- column contact --> 

                                    @if($quizzes->count() == 0)
                                    <div class="col-md-12">
                                       <div class="alert alert-warning" role="alert">
                                          No Quizes Found, Please <a href="{{route('admin.quiz.create')}}">Create one </a>
                                       </div>
                                    </div>
                                    @else
                                    @foreach ($quizzes as $quiz)

                                  


                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 profile_details margin_bottom_30">
                                    <span class="ribbon {{$quiz->is_active ? 'ribbon-active' : 'ribbon-inactive'}}" style="position: absolute; top: 0px; right: 16px; z-index: 1.5; font-size: 0.8em; padding: 5px 10px; text-align: center; background-color: {{$quiz->is_active ? 'green' : 'red'}}; color: white;">
                                                   {{$quiz->is_active ? 'Active' : 'Inactive'}}
                                    </span>
                                       <div class="contact_blog">
                                          <!-- <h4 class="brief">Questions : {{$quiz->questions->count()}}</h4> -->
                                          <div class="contact_inner">
                                             <div class="left">
                                                <h3>{{___($quiz->title)}}</h3>
                                                <p>{{___($quiz->description)}}</p>
                                             </div>
                                             <div class="right">
                                                <div class="profile_contacts">
                                                   <img class="img-responsive" src="{{ env_asset('images/layout_img/msg2.png') }}" alt="#" />
                                                </div>
                                             </div>
                                          </div>
                                          <div class="contact_inner">

                                             <div class="row">
                                                <div class="col-md-6">
                                                   <ul class="list-unstyled">
                                                      <li><i class="fa fa-clock-o"></i> : {{$quiz->duration}} {{___('Minutes')}}</li>
                                                      <li><i class="fa fa-question"></i> : {{$quiz->questions->count()}} {{___('Questions')}}  </li>
                                                   </ul>
                                                </div>
                                                <div class="col-md-6">
                                                   <ul class="list-unstyled">
                                                      <li><i class="fa fa-star"></i> : {{$quiz->questions->sum('points')}} {{___('Points')}}</li>
                                                      <li><i class="fa fa-users"></i> : {{$quiz->timings->count()}} {{___('Attended')}}  </li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-12">
                                                   <ul class="list-unstyled">
                                                      @if ($quiz->average_completion_time)
                                                         <li>{{___('Average completion time')}} : {{$quiz->average_completion_time}}</li>
                                                      @endif
                                                   </ul>
                                                </div>
                                             </div>
                                             <div class="bottom_list">
                                                <div class="left_rating">
                                                    
                                                <p class="ratings">
                                                   @for ($i = 0; $i < 5; $i++)
                                                      <a href="#">
                                                            @if ($i < floor($quiz->difficulty))
                                                               <!-- Full star -->
                                                               <span class="fa fa-star full-star"></span>
                                                            @elseif ($i < $quiz->difficulty)
                                                               <!-- Half star -->
                                                               <span class="fa fa-star-half-o half-star"></span>
                                                            @else
                                                               <!-- Empty star -->
                                                               <span class="fa fa-star-o empty-star"></span>
                                                            @endif
                                                      </a>
                                                   @endfor
                                                </p>

                                                </div>
                                                <div class="right_button row">
                                               
                                                @if(session('role') == 'admin')
                                                <form action="{{route('admin.quiz.destroy', $quiz->id)}}" method="POST" class="m-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs"> <i class="fa fa-trash">
                                                   </i> 
                                                   <!-- Delete -->
                                                   </button>
                                                </form>

                                                   <a href="{{route('admin.quiz.edit', $quiz->id)}}" class="btn btn-secondary btn-xs m-1">
                                                    <i class="fa fa-edit">
                                                   </i> 
                                                   <!-- Edit -->
                                                   </a>
                                                   <a href="{{route('admin.quiz.create', ['clone' => $quiz->id])}}" class="btn btn-secondary btn-xs m-1">
                                                    <i class="fa fa-clone">
                                                   </i>  
                                                   <!-- Clone -->
                                                   </a>

                                                   @else
                                                   
                                                   @if(App\Models\QuizTiming::where('quiz_id', $quiz->id)->where('user_id', session('user.id'))->whereNotNull('start_time')->exists() && $quiz->result)
                                                   <a href="{{route('quiz.show', $quiz->slug)}}" class="btn btn-warning btn-xs m-1">
                                                      <i class="fa fa-trophy"> </i> 
                                                      <!-- Result -->
                                                      </a>
                                                   @elseif(App\Models\QuizTiming::where('quiz_id', $quiz->id)->where('user_id', session('user.id'))->whereNotNull('start_time')->exists()&& !$quiz->result)
                                                      <a href="{{route('quiz.show', $quiz->slug)}}" class="btn btn-danger btn-xs m-1">
                                                      <i class="fa fa-exclamation-triangle"> </i> 
                                                      <!-- interrupted -->
                                                      </a>
                                                   @else
                                                      <a href="{{route('quiz.show', $quiz->slug)}}" class="btn btn-success btn-xs m-1">
                                                      <i class="fa fa-clock-o"> </i> 
                                                      <!-- Start -->
                                                      </a>
                                                   @endif

                                                   @endif


                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    @endforeach
                                    @endif


                                  
                                    <!-- end column contact blog -->
                                 
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- end row -->
                     </div>

                     @endsection
