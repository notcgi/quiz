document.addEventListener('DOMContentLoaded', function() {
    let questionsData = [];

    // Hide the results sections initially
    document.getElementById('results').style.display = 'none';

    function loadQuizData() {
        fetch('/api/v1/quiz/')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (!Array.isArray(data.questions)) {
                    throw new TypeError('Expected an array of questions');
                }
                questionsData = data.questions;
                const quizContainer = document.getElementById('quiz');
                quizContainer.innerHTML = ''; // Clear previous quiz data
                data.questions.forEach(question => {
                    const questionElement = document.createElement('div');
                    questionElement.innerHTML = `<h2>${question.questionText}</h2>`;
                    const answersList = document.createElement('div');
                    question.answers.forEach(answer => {
                        const answerItem = document.createElement('p');
                        answerItem.innerHTML = `
                            <label>
                                <input type="checkbox" name="question_${question.id}" value="${answer.id}">
                                ${answer.answerText}
                            </label>
                        `;
                        answersList.appendChild(answerItem);
                    });
                    questionElement.appendChild(answersList);
                    quizContainer.appendChild(questionElement);
                });
            })
            .catch(error => {
                console.error('Error fetching quiz data:', error);
            });
    }

    loadQuizData();

    document.getElementById('quiz-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const results = {};

        questionsData.forEach(question => {
            results[question.id] = [];
        });

        formData.forEach((value, key) => {
            const questionId = key.split('_')[1];
            results[questionId].push({ id: parseInt(value) });
        });

        const formattedResults = {
            questions: Object.keys(results).map(questionId => ({
                id: parseInt(questionId),
                answers: results[questionId]
            }))
        };

        fetch('/api/v1/quiz/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formattedResults)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const correctQuestions = [];
                const incorrectQuestions = [];

                data.questions.forEach(question => {
                    const questionText = questionsData.find(q => q.id === question.id).questionText;
                    if (question.isCorrect) {
                        correctQuestions.push(questionText);
                    } else {
                        incorrectQuestions.push(questionText);
                    }
                });

                const correctList = document.getElementById('correct-questions');
                const incorrectList = document.getElementById('incorrect-questions');

                correctList.innerHTML = '';
                incorrectList.innerHTML = '';

                correctQuestions.forEach(text => {
                    const listItem = document.createElement('li');
                    listItem.textContent = text;
                    correctList.appendChild(listItem);
                });

                incorrectQuestions.forEach(text => {
                    const listItem = document.createElement('li');
                    listItem.textContent = text;
                    incorrectList.appendChild(listItem);
                });

                // Show the results sections and hide the form
                document.getElementById('results').style.display = 'block';
                document.getElementById('quiz-form').style.display = 'none';
            })
            .catch(error => {
                console.error('Error submitting quiz results:', error);
            });
    });

    // Add event listener for the reset button
    document.getElementById('reset-button').addEventListener('click', function() {
        // Hide the results section and show the form
        document.getElementById('results').style.display = 'none';
        document.getElementById('quiz-form').style.display = 'block';

        // Clear previous answers
        document.getElementById('quiz-form').reset();

        // Reload quiz data
        loadQuizData();
    });
});