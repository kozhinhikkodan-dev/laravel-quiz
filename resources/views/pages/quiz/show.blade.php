@extends('layouts.main')

@section('content')

<!-- Dashboard inner -->
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="page_title">
                <h2 class="display-4">Quiz</h2>
            </div>
        </div>
    </div>
    <!-- Quiz Content -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title">{{ $quiz->title }}</h3>
                </div>
                <div class="card-body">
                    <div class="quiz-container" style="font-size: 1.2rem;">
                        <!-- Quiz Info -->
                        <h4 class="text-center">Quiz: {{ $quiz->title }}</h4>
                        <p class="text-center"><strong>Number of Questions:</strong> {{ $quiz->questions->count() }}</p>
                        <p class="text-center"><strong>Total Points:</strong> {{ $quiz->questions->sum('points') }}</p>
                        <p class="text-center"><strong>Duration:</strong> {{ $quiz->duration }} minutes</p>

                        <!-- Start Quiz Button -->
                        <div class="text-center">

                            @if(App\Models\QuizTiming::where('quiz_id', $quiz->id)->where('user_id', session('user.id'))->whereNotNull('start_time')->exists() && true)

                                @if($quiz->result)
                                <div class="alert alert-success" role="alert">Quiz Attended</div>
                                <button id="view-result" class="btn btn-secondary mt-2">View Result</button>
                                <div id="result-container" style="display: none;" class="mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Result</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="chart">
                                                        <canvas id="doughnutChart"></canvas>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                    <!-- @php
                                                    dump($quiz->result);
                                                    @endphp -->
                                                    <div class="progress-wrapper">
                                                        <div class="progress-info">
                                                            <div class="progress-label">
                                                                <span>Score</span>
                                                                <span class="badge badge-info float-right">{{ $quiz->score }} / {{ $quiz->questions->sum('points')}}</span>
                                                            </div>
                                                            <div class="progress-percentage">
                                                                <span class="progress-number">{{ number_format(($quiz->score / $quiz->questions->sum('points')) * 100, 2) }}%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ number_format(($quiz->score / $quiz->questions->sum('points')) * 100, 2) }}%" aria-valuenow="{{ $quiz->score }}" aria-valuemin="0" aria-valuemax="{{ $quiz->questions->sum('points')}}"></div>
                                                        </div>
                                                    </div>
                                                    <div class="progress-wrapper mt-5">
                                                        <div class="progress-info">
                                                            <div class="progress-label">
                                                                <span>Attended Questions</span>
                                                                <span class="badge badge-info float-right">{{ $quiz->submission() ? count(json_decode($quiz->submission()->answers)) : 0 }} / {{ $quiz->questions->count() }}</span>
                                                            </div>
                                                            <div class="progress-percentage">
                                                                <span class="progress-number">{{ number_format(($quiz->submission() ? count(json_decode($quiz->submission()->answers)) : 0) / $quiz->questions->count() * 100, 2) }}%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ number_format(($quiz->submission() ? count(json_decode($quiz->submission()->answers)) : 0) / $quiz->questions->count() * 100, 2) }}%" aria-valuenow="{{ $quiz->submission() ? count(json_decode($quiz->submission()->answers)) : 0 }}" aria-valuemin="0" aria-valuemax="{{ $quiz->questions->count() }}"></div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-5">
                                                        <p class="text-center">Completed in <strong>{{ $quiz?->result?->time_used }}</strong></p>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            <div class="row mt-5">
                                                <div class="col-md-12 d-flex justify-content-center">
                                                    <div class="w-50" style="text-align: left;">
                                            <div id="question-container">
    

    <ul class="correct-answers">
        @foreach ($quiz->questions as $qindex => $question)
            @php
                // Retrieve the user's answer for this question
                $userAnswerData = collect($quiz->result->user_answers)->firstWhere('question_id', $question->id);
                $userAnswerValue = $userAnswerData ? (int) $userAnswerData->answer : null;
                $correctOption = (int) $question->correct_option;
            @endphp

            <li class="mb-3">
                <div class="question text-left">Q {{ $qindex + 1 }}: {{ $question->question }}</div>
                <div class="options">
                    @foreach ($question->options as $idx => $opt)
                        @php
                            $idx++; // Increment for 1-based index
                        @endphp
                        <div class="option {{ $idx === $correctOption ? 'text-success' : ($idx === $userAnswerValue ? 'text-warning' : 'text-danger') }} d-flex align-items-center">
                            <i class="mr-2 {{ $idx === $correctOption && $idx === $userAnswerValue ? 'fa fa-check-circle' : 'fa fa-times-circle' }}"></i>
                            <span>{{ $opt }}</span>
                            @if ($idx === $correctOption && $idx === $userAnswerValue)
                                <span class="ml-auto">+{{ $question->points }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if ($question->explanation)
                    <div class="alert alert-success mt-2">{{ $question->explanation }}</div>
                @endif
            </li>
        @endforeach
    </ul>
</div>
</div>


                                            </div>
                                            <div class="col-md-3"></div>



                                        </div>
                                    </div>
                                </div>
                                @else
                                    <!-- display alert quiz interupted ,  -->
                                    <div class="alert alert-danger" role="alert">Quiz interrupted</div>
                                @endif
                              
                            @else
                            <div class="text-center">

                            <!-- <select id="language-select" class="form-control d-inline-block" style="width: 150px;border-radius: 25px !important;padding: 5px 10px !important;">
                                <option value="" disabled selected>
                                    <img class="img-responsive flag" src="{{ asset('flags/' . app()->getLocale() . '.png') }}" alt="{{ app()->getLocale() }}" style="width: 20px;vertical-align: middle;margin-right: 5px;" />
                                    {{ config('app.languages')[app()->getLocale()] ?? 'English' }}
                                </option>
                                @foreach(config('app.languages') as $langCode => $language)
                                    <option value="{{ $langCode }}">
                                        <img class="img-responsive flag" src="{{ asset('flags/' . $langCode . '.png') }}" alt="{{ $language }}" style="width: 20px;vertical-align: middle;margin-right: 5px;" />
                                        {{ $language }}
                                    </option>
                                @endforeach
                            </select> -->
                            <button id="start-quiz" class="btn btn-primary btn-lg d-inline-block" style="border-radius: 25px !important;padding: 5px 10px !important;">Start Quiz</button>
                            @endif
                        </div>
                        <p id="quiz-message" class="alert alert-warning mt-3 text-center" style="display: none;">Do not refresh the page once the quiz starts!</p>
                    </div>

                    <!-- Quiz Timer and Content -->
                    <div id="quiz-content" style="display: none;">

                        <div id="question-indicator" class="text-center">
                            <ul class="list-inline">
                                @foreach ($quiz->questions as $index => $question)
                                    <li class="list-inline-item" data-question-id="{{ $question->id }}" style="display: inline-block; width: 25px; height: 25px; border-radius: 50%; margin: 0 5px;">
                                        <i class="fa fa-2x fa-like-circle text-secondary"></i>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                      
                        
                        <div class="text-center" id="timer" style="font-size: 2rem;"></div>


                        <div id="question-container" class="text-left my-3" style="margin: 0 auto; width: fit-content;"></div>
                        <!-- Navigation Buttons -->
                        <div class="text-center">
                            <div class="d-flex justify-content-center">
                                <button id="prev-btn" class="btn btn-secondary mx-2" style="display: none;"><i class="fa fa-long-arrow-left mr-2"></i>Previous</button>
                                <button id="next-btn" class="btn btn-secondary mx-2" style="display: none;">Next<i class="fa fa-long-arrow-right ml-2"></i></button>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button id="submit-btn" class="btn btn-xs btn-danger mx-2" style="display: none;"><i class="fa fa-share mr-2"></i>Submit</button>
                            </div>
                        </div>
                    </div> <!-- End Quiz Content -->
                </div>
            </div>
        </div>
    </div> <!-- End Row -->
</div> <!-- End Container -->

@push('scripts')
<script>

$(function() {
                                    //$('#language-select').change(function() {
                                       // if ($(this).val()) {
                                       //     $('#start-quiz').prop('disabled', false);
                                     //   } else {
                                    //        $('#start-quiz').prop('disabled', true);
                                  //      }
                                  //  });
                                });

  $(document).ready(function () {
                                        $('#view-result').click(function () {
                                            $('#result-container').slideToggle();
                                        });
                                    });

    $(document).ready(function () {

        @if($quiz->result)

                                  
         var ctxD = document.getElementById("doughnutChart").getContext('2d');
                                    var myDoughnutChart = new Chart(ctxD, {
                                        type: 'doughnut',
                                        data: {
                                            labels: ["Correct", "Incorrect","Not Attempted"],
                                            datasets: [{
                                                data: [{{$quiz->result->right_answers_count}}, {{ $quiz->result->wrong_answers_count}}, {{ $quiz->result->not_attempted_questions_count}}],
                                                backgroundColor: [
                                                    "#28a745",
                                                    "#dc3545",
                                                    "#ff9800",
                                                ]
                                            }]
                                        },
                                        options: {
                                            responsive: true
                                        }
                                    });

                                    @endif


        let timer; // Timer reference
        let currentQuestionIndex = 0; // Track the current question
        const questions = @json($quiz->questions); // Load questions from backend
        const totalQuestions = questions.length;

        // Elements
        const $quizContent = $('#quiz-content');
        const $startQuizBtn = $('#start-quiz');
        const $quizMessage = $('#quiz-message');
        const $timerDiv = $('#timer');
        const $questionContainer = $('#question-container');
        const $prevBtn = $('#prev-btn');
        const $nextBtn = $('#next-btn');
        const $submitBtn = $('#submit-btn');

        // Start quiz
        $startQuizBtn.click(function () {
            $('#sidebarCollapse').trigger('click');
            $startQuizBtn.hide();
            $quizMessage.show();
            $quizContent.show();
            startTimer({{ $quiz->duration }});
            loadQuestion(0);

            // Inform backend the quiz has started
            $.ajax({
                url: '/quiz/start',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                data: JSON.stringify({ quiz_id: {{ $quiz->id }} }),
                contentType: 'application/json',
            });
        });

        // Timer function
        function startTimer(duration) {
            let time = duration * 60; // Convert minutes to seconds
            timer = setInterval(function () {
                const minutes = Math.floor(time / 60);
                const seconds = time % 60;
                $timerDiv.text(`Time Remaining: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`);
                if (--time < 0) {
                    clearInterval(timer);
                    submitQuiz();
                }
            }, 1000);
        }



        // Load question
        function loadQuestion(index) {
            if (index < 0 || index >= totalQuestions) return;
            currentQuestionIndex = index;
            const question = questions[index];
            const options = question.options;
            const optionsHtml = options.map((opt, idx) => {
                const $hiddenInput = $(`input[type=hidden][data-q-id=${question.id}]`);
                const checked = $hiddenInput.length ? $hiddenInput.val() === `${idx}` : false;
                return `
                    <li class="answer-li" style="font-size: 1.2rem;margin-bottom: 1px;" data-q-id="${question.id}">
                        <input type="radio" name="answer" value="${idx}" id="option${idx}" ${checked ? 'checked' : ''}>
                        <label for="option${idx}">${opt}</label>
                    </li>
                `;
            }).join('');
            $questionContainer.html(`
                <p>Question ${index + 1}</p>
                <h4>${question.question}</h4>
                <ul>${optionsHtml}</ul>
            `);
            
            toggleNavigationButtons();
        }

        $('body').on('click', '.answer-li', function() {
                var $hiddenInput = $(`input[type=hidden][data-q-id=${$(this).data('q-id')}]`);
                if ($hiddenInput.length) {
                    var val = parseInt($(this).find('input:checked').val());
                    $hiddenInput.val(val+1);
                } else {
                    $hiddenInput = $(`<input type="hidden" data-answer-text="${$(this).find('label').text()}" data-q-id="${$(this).data('q-id')}" name="answers">`);
                    var val = parseInt($(this).find('input:checked').val());
                    $hiddenInput.val(val+1);
                    $('body').append($hiddenInput);
                }

                updateQuestionIndicator();
            });

        // Toggle navigation buttons
        function toggleNavigationButtons() {
            $prevBtn.toggle(currentQuestionIndex > 0);
            $nextBtn.toggle(currentQuestionIndex < totalQuestions - 1);
            $submitBtn.show();
        }

        // Navigation buttons
        $prevBtn.click(function () {
            loadQuestion(currentQuestionIndex - 1);
        });

        $nextBtn.click(function () {
            loadQuestion(currentQuestionIndex + 1);
        });

        // Submit quiz
        $submitBtn.click(function () {
            submitQuiz();
        });

        function submitQuiz() {
            clearInterval(timer);
            const answers = []; // Collect user's answers


            $('body').find('input[type=hidden][name=answers]').each(function() {
                console.log($(this).val());
                answers.push({
                    question_id: $(this).data('q-id'),
                    answer: $(this).val(),
                });
            });

            // Post answers to backend
            $.ajax({
                url: '/quiz/submit',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                data: JSON.stringify({ quiz_id: {{ $quiz->id }}, answers }),
                contentType: 'application/json',
                success: function (data) {
                    console.log(data);
                    const $questionContainer = $('#question-container');
                    const $correctAnswers = $('<ul>').addClass('correct-answers');

                    // todo : show the answer choosen by user  by checking in <input type="hidden" data-q-id="${$(this).data('q-id')}" name="answers">, as user answer after question options displayed, do not change options currently displayed and point gained by the question if answer is correct 
                    data.questions.forEach((question,qindex) => {
                        // const userAnswer = 
                        const userAnswerInput = $(`input[type=hidden][data-q-id=${question.id}]`);
                        const userAnswerValue = userAnswerInput.length ? parseInt(userAnswerInput.val()) : null;
                        const userAnswer = userAnswerInput.length ? userAnswerInput.data('answer-text') : '-';

                        const $question = $('<li>').addClass('mb-3');
                        let pointGained = 0;
                        $question.html(`
                            <div class="question">Q ${qindex + 1}: ${question.question}</div>
                            <div class="options">
                                ${question.options.map((opt, idx) => {
                                    
                                    const correct_option = parseInt(question.correct_option);
                                    
                                    idx = idx+1;

                                    let point = 0;
                                    // if(qindex == 0) {
                                    //     console.table([{
                                    //     'idx': idx, "user choice":userAnswerValue, 'question.correct_option - 1': correct_option
                                    // }]);
                                    // }
                                    
                                    if (idx == correct_option && correct_option == userAnswerValue) {
                                        pointGained = point = question.points;
                                    }

                                   
                                    // to do : fix syntax error, (idx == userAnswerValue && point == 0 ) matches do text-warning , else go for check  ${(idx === correct_option && correct_option === userAnswerValue ) then text-success else text-danger
                                    return `
                                        <div class="option ${idx === correct_option ? 'text-success' : idx == userAnswerValue ? 'text-warning' : 'text-danger'} d-flex align-items-center">
                                            <i class="mr-2 ${idx === correct_option && idx === userAnswerValue ? 'fa fa-check-circle' : 'fa fa-times-circle'}"></i>
                                            <span>${opt}</span>
                                            <span class="ml-auto">${point > 0 ? `+${point}` : ''}</span>
                                        </div>
                                    `
                                }).join('')}

                                ${question.explanation ? `<div class="alert alert-success mt-2">${question.explanation}</div>` : ``}

                            </div>
                        `);
                        $correctAnswers.append($question);
                    });

                    $questionContainer.html(`
                        <h3>Quiz Completed!</h3>
                        <p>Time Used: ${data.time_used}</p>
                        <p>Total Points: ${data.total_points}</p>
                        <h4>Correct Answers:</h4>
                    `);
                    $questionContainer.append($correctAnswers);
                    $prevBtn.hide();
                    $nextBtn.hide();
                    $submitBtn.hide();
                }
            });
        }
    });


    function updateQuestionIndicator() {
                                $('input[type=hidden][name=answers]').each(function() {
                                    const questionId = $(this).data('q-id');
                                    const $indicator = $(`li[data-question-id="${questionId}"] i`);

                                    if ($(this).val()) {
                                        $indicator.removeClass('fa-check-circle text-secondary').addClass('fa-check-circle text-success');
                                    } else {
                                        $indicator.removeClass('fa-check-circle text-success').addClass('fa-check-circle text-secondary');
                                    }
                                });
                            }

                            // $(document).ready(function() {
                            //     updateQuestionIndicator(); // Initial call to update indicators
                            //     // Call updateQuestionIndicator() whenever necessary, e.g., after loading a question or changing an answer
                            // });
</script>
@endpush

@endsection
