displayInitialPage();

function generateReasons() {
    
    let userInput = document.getElementById('reasons_user_input').value;

    displayLoading(userInput);

    fetch('https://www.extrareasons.com/api.php?user_input='+userInput)
        .then((response) => response.json())
        .then((data) => {
            displayResultsPage(data, userInput);
        })
        .catch((error) => console.log('error fetching the reasons:', error));
}

function displayInitialPage() {
    document.getElementById('reasons_user_input').value = '';
    document.getElementById('reasons-form').style.display = 'flex';
    document.getElementById('loading-div').style.display = 'none';
    document.getElementById('reasons-result').style.display = 'none';
}

function displayLoading(userInput) {
    document.getElementById('reasons-form').style.display = 'none';
    document.getElementById('reasons-result').style.display = 'none';
    let loadingDiv = document.getElementById('loading-div');
    
    loadingDiv.style.display = 'block';
    loadingDiv.innerHTML = `
    <p>Looking for reasons to ${userInput}</p>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    `;
}

function displayResultsPage(data, userInput) {
    document.getElementById('reasons-form').style.display = 'none';
    document.getElementById('loading-div').style.display = 'none';

    let resultDiv = document.getElementById('reasons-result');
    resultDiv.style.display = 'flex';
    resultDiv.innerHTML = `
    <h2>Here you have 5 reasons to ${userInput}</h2>
    <ul>
        <li>${data[0]}</li>
        <li>${data[1]}</li>
        <li>${data[2]}</li>
        <li>${data[3]}</li>
        <li>${data[4]}</li>
    </ul>
    <button onclick="displayInitialPage()">Look for other reasons</button>
    `;
}