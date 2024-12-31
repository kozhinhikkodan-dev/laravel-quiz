@extends('layouts.main')


@section('content')


<!-- dashboard inner -->
<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>Create new Quiz</h2>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row column1">
            <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>Quiz</h2>
                        </div>
                    </div>
                    <div class="full price_table padding_infor_info">
                        <div class="row">
                            <!-- column contact -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile_details margin_bottom_30">

                                <form method="post" action="{{ route('admin.quiz.store') }}">
                                    @csrf



                                    <div class="row">
                                        <div class="form-group col-md-8">
                                            <label for="title">Quiz Title</label>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ $quiz ? $quiz->title : old('title') }}">
                                            <small class="form-text text-muted">Unique title needed.</small>
                                            @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="title">Duration (minutes)</label>
                                            <input type="text" name="duration" id="duration" class="form-control" value="{{ $quiz ? $quiz->duration : old('duration') }}">
                                            <small class="form-text text-muted">Input the duration in minutes. e.g. 30</small>
                                            @error('duration')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-2">
                                            <label for="difficulty">Difficulty Level</label>
                                            <select name="difficulty" id="difficulty" class="form-control">
                                                <option {{ $quiz && $quiz->difficulty == 1 ? 'selected' : '' }} value="1">1</option>
                                                <option {{ $quiz && $quiz->difficulty == 1.5? 'selected' : '' }} value="1.5">1.5</option>
                                                <option {{ $quiz && $quiz->difficulty == 2 ? 'selected' : '' }} value="2">2</option>
                                                <option {{ $quiz && $quiz->difficulty == 2.5? 'selected' : '' }} value="2.5">2.5</option>
                                                <option {{ $quiz && $quiz->difficulty == 3 ? 'selected' : '' }} value="3">3</option>
                                                <option {{ $quiz && $quiz->difficulty == 3.5? 'selected' : '' }} value="3.5">3.5</option>
                                                <option {{ $quiz && $quiz->difficulty == 4 ? 'selected' : '' }} value="4">4</option>
                                                <option {{ $quiz && $quiz->difficulty == 4.5? 'selected' : '' }} value="4.5">4.5</option>
                                                <option {{ $quiz && $quiz->difficulty == 5 ? 'selected' : '' }} value="5">5</option>
                                            </select>
                                            <small class="form-text text-muted">1 to 5 , 1 - easy , 5 - difficult</small>
                                            @error('difficulty')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control">{{ $quiz ? $quiz->description : old('description') }}</textarea>
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div id="questions-container">




                                        @if($quiz)
                                        @foreach ($quiz->questions as $key => $question)

                                        <div class="question-block p-5 mb-3" style="background-color: #6b7e900f !important;">
                                            <hr>
                                            <div class="form-group">
                                                <label for="question">Question <span class="question-number">#{{$key+1}}</span></label>
                                                <input type="text" name="questions[{{$key}}][question]" class="form-control" value="{{ $question->question }}">
                                                @error('questions.*.question')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-2">
                                                <label>Options</label>

                                                <!-- <input type="text" name="questions[{{$key}}][options][0]" class="form-control mt-3" placeholder="Option 1" > -->
                                                <!-- <input type="text" name="questions[{{$key}}][options][1]" class="form-control mt-3" placeholder="Option 2" >
                                                        <input type="text" name="questions[{{$key}}][options][2]" class="form-control mt-3" placeholder="Option 3" >
                                                        <input type="text" name="questions[{{$key}}][options][3]" class="form-control mt-3" placeholder="Option 4" > -->

                                                @foreach ($question->options as $optionKey => $option)
                                                <input type="text" value="{{$option}}" name="questions[{{$key}}][options][{{$optionKey}}]" class="form-control mt-3" placeholder="Option {{$optionKey+1}}">
                                                @endforeach

                                                <select name="questions[{{$key}}][correct_option]" class="form-control mt-3">
                                                    <option value="" disabled selected>Select correct answer</option>
                                                    <option value="1" {{ $question->correct_option == 1 ? 'selected' : '' }}>Option 1</option>
                                                    <option value="2" {{ $question->correct_option == 2 ? 'selected' : '' }}>Option 2</option>
                                                    <option value="3" {{ $question->correct_option == 3 ? 'selected' : '' }}>Option 3</option>
                                                    <option value="4" {{ $question->correct_option == 4 ? 'selected' : '' }}>Option 4</option>
                                                </select>

                                                <div class="form-group mt-3">
                                                    <label for="question">Question Point</label>
                                                    <input type="number" min="1" max="10" value="{{$question->points}}" name="questions[{{$key}}][points]" class="form-control">
                                                    @error('questions.*.points')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group mt-3">
                                                    <label for="question">Explanation</label>
                                                    <textarea name="questions[{{$key}}][explanation]" class="form-control">{{$question->explanation}}</textarea>
                                                    @error('questions.*.explanation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <button type="button" class="btn btn-danger question-delete mt-2">Delete</button>

                                            </div>
                                        </div>

                                        @endforeach
                                        @else
                                        <div class="question-block p-5 mb-3" style="background-color: #6b7e900f !important;">
                                            <hr>
                                            <div class="form-group">
                                                <label for="question">Question <span class="question-number">#1</span></label>
                                                <input type="text" name="questions[0][question]" class="form-control">
                                                @error('questions.*.question')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-2">
                                                <label>Options</label>

                                                <input type="text" name="questions[0][options][0]" class="form-control mt-3" placeholder="Option 1">
                                                @error('questions.*.options.*')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <input type="text" name="questions[0][options][1]" class="form-control mt-3" placeholder="Option 2">
                                                <input type="text" name="questions[0][options][2]" class="form-control mt-3" placeholder="Option 3">
                                                <input type="text" name="questions[0][options][3]" class="form-control mt-3" placeholder="Option 4">

                                                <select name="questions[0][correct_option]" class="form-control mt-3">
                                                    <option value="" disabled selected>Select correct answer</option>
                                                    <option value="1">Option 1</option>
                                                    <option value="2">Option 2</option>
                                                    <option value="3">Option 3</option>
                                                    <option value="4">Option 4</option>
                                                </select>

                                                <div class="form-group mt-3">
                                                    <label for="question">Question Point</label>
                                                    <input type="number" min="1" max="10" name="questions[0][points]" class="form-control">
                                                    @error('questions.*.points')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group mt-3">
                                                    <label for="question">Explanation</label>
                                                    <textarea name="questions[0][explanation]" class="form-control"></textarea>
                                                    @error('questions.*.explanation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <button type="button" class="btn btn-danger question-delete mt-2">Delete</button>

                                            </div>
                                        </div>


                                        @endif
                                        <div class="btn-group btn-group-toggle my-3" data-toggle="buttons">
                                            <label class="btn btn-outline-success {{ old('status', 'active') == 'active' ? 'active' : '' }}">
                                                <input type="radio" name="status" id="statusActive" value="active" {{ old('status', 'active') == 'active' ? 'checked' : '' }}> Active
                                            </label>
                                            <label class="btn btn-outline-danger {{ old('status', 'active') == 'inactive' ? 'active' : '' }}">
                                                <input type="radio" name="status" id="statusInactive" value="inactive" {{ old('status', 'active') == 'inactive' ? 'checked' : '' }}> Inactive
                                            </label>
                                        </div>


                                    </div>

                                    <button type="button" id="add-question" class="btn btn-secondary">Add Question</button>
                                    <button type="submit" class="btn btn-primary">Create Quiz</button>
                                </form>



                                <script>
                                    document.getElementById('add-question').addEventListener('click', function() {
                                        var questionsContainer = document.getElementById('questions-container');
                                        var questionBlocks = questionsContainer.querySelectorAll('.question-block');
                                        var newIndex = questionBlocks.length;

                                        var newQuestionBlock = questionBlocks[0].cloneNode(true);
                                        newQuestionBlock.querySelectorAll('input, select').forEach(element => {
                                            element.value = '';
                                            element.name = element.name.replace(/\[\d+\]/, `[${newIndex}]`);
                                        });

                                        newQuestionBlock.querySelector('.question-number').textContent = `#${newIndex + 1}`;
                                        questionsContainer.appendChild(newQuestionBlock);
                                    });

                                    document.getElementById('questions-container').addEventListener('click', function(event) {
                                        if (event.target.classList.contains('question-delete')) {
                                            event.target.parentNode.parentNode.remove();

                                            var questionBlocks = document.querySelectorAll('.question-block');

                                            questionBlocks.forEach(function(questionBlock, index) {
                                                questionBlock.querySelector('.question-number').textContent = `#${index + 1}`;
                                                questionBlock.querySelectorAll('input').forEach(input => input.name = input.name.replace(/\[\d+\]/, `[${index}]`));
                                                questionBlock.querySelectorAll('select').forEach(select => select.name = select.name.replace(/\[\d+\]/, `[${index}]`));
                                            });
                                        }
                                    });
                                </script>


                            </div>
                            <!-- end column contact blog -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>

        @endsection