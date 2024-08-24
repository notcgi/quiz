document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/v1/quiz')
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
            const quizContainer = document.getElementById('quiz');
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

    document.getElementById('quiz-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const results = {};

        formData.forEach((value, key) => {
            const questionId = key.split('_')[1];
            if (!results[questionId]) {
                results[questionId] = [];
            }
            results[questionId].push({ id: parseInt(value) });
        });

        const formattedResults = {
            questions: Object.keys(results).map(questionId => ({
                id: parseInt(questionId),
                answers: results[questionId]
            }))
        };

        fetch('/api/v1/quiz', {
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
                console.log('Quiz results submitted successfully:', data);
            })
            .catch(error => {
                console.error('Error submitting quiz results:', error);
            });
    });
});