const pages = {};

pages.baseUrl = 'http://localhost/digital-wallet/wallet-server/connection/user/v1/APIs/';

pages.loadFor = (page) => {
    eval(`pages.${page}Page()`);
}

const displayMessage = (message, success) => {
    const message_container = document.getElementById('message-container');
    if (message_container) {
        message_container.innerText = message;
        message_container.style.color = success ? 'green' : 'red';
    }
}

pages.signupPage = () => {
    console.log('hey there');
    const signup_button = document.getElementById('signup-button');
    signup_button.addEventListener('click', handleSignup);
}

const handleSignup = async () => {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const phoneNumber = document.getElementById('phone').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const address = document.getElementById('address').value;
    const file = document.getElementById('id-document').files[0];

    if (password !== confirmPassword) {
        displayMessage("Passwords do not match.", false);
        return;
    }

    const formData = new FormData();
    formData.append('username', username);
    formData.append('email', email);
    formData.append('phoneNumber', phoneNumber);
    formData.append('password', password);
    formData.append('confirmPassword', confirmPassword);
    formData.append('address', address);
    formData.append('file', file);

    try {
        const response = await axios.post(`${pages.baseUrl}signup.php`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        if (response.data.success) {
            console.log(response.data.message);
            displayMessage(response.data.message, true);

            checkUserVerification(response.data.message);
        } else {
            displayMessage(response.data.message, false);
        }
    } catch (error) {
        console.error('Signup failed:', error);
        displayMessage('An error occurred during signup.', false);
    }
}

pages.loginPage = () => {
    const loginButton = document.getElementById('login-button')
    loginButton.addEventListener('click', handleLogin);
}

const handleLogin = async () => {
    const password = document.getElementById('password').value;
    const email = document.getElementById('email').value;
    const formData = new FormData();
    formData.append('password', password);
    formData.append('email', email);

    try {
        const response = await axios.post(`${pages.baseUrl}login.php`, formData,{
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        if (response.data.success) {
            console.log('Login successfully:');
            displayMessage('login successfully', true);
            checkUserVerification(response.data.message);
 
        } else {
            console.log('Login successfully:', response.data.message)
            console.log('hello');
            displayMessage(response.data.message, false);
        }
    } catch (error) {
        console.error('Login failed:', error);
        displayMessage('An error occurred during login.', false);
    }
}

const checkUserVerification = async (user_id) => {
    try {
        const response = await axios.get(`${pages.baseUrl}checkVerification.php?user_id=${user_id}`);

        if (response.data.message) {
            console.log(response.data.message);
            localStorage.setItem('user_id', user_id);
            window.location.href = 'html/home.html';
            

        } else {
            console.log(response.data);
            displayMessage("Your account is pending admin approval. Please wait for verification.", false);
        }
    } catch (error) {
        console.error('Error checking verification status:', error);
        displayMessage('Error checking verification status. Please try again later.', false);
    }
}


pages.homePage = () => {
    document.querySelector('.get-started').addEventListener('click', () => {
        window.location.href = '../html/services.html';
    });
}

pages.profilePage = () => {
    $button = document.getElementById('update-button');
    getProfile()
}
const getProfile = async () => {
    const user_id = localStorage.getItem('user_id');
    if (!user_id) {
        displayMessage('User not logged in.', false);
        return;
    }
    
    try {
        const response = await axios.get(`${pages.baseUrl}getProfile.php?user_id=1`);
        if (response.data.success) {
            console.log(response.data.message);
            document.getElementById('username').value = response.data.message.username;
            document.getElementById('address').value = response.data.message.address;
        } else {
            displayMessage(response.data.message, false);
        }
    } catch (error) {
        console.error('Error fetching profile:', error);
        displayMessage('An error occurred. Try again later.', false);
    }
}


   

pages.walletsPage = async () => {
    const create_wallet = document.getElementById('create-wallet')
    create_wallet.addEventListener('click', handleCreateWallet);
    const user_id = localStorage.getItem('user_id');
    if (!user_id) {
        displayMessage('User not logged in.', false);
        return;
    }
    try {
        const response = await axios.get(`${pages.baseUrl}getWallets.php?user_id=${user_id}`);
        if (response.data.success) {
            const wallet_container = document.querySelector('.wallet-list');
            response.data.message.forEach(wallet => {
                const wallet_card = document.createElement('div');
                wallet_card.classList.add('wallet-card');
                wallet_card.setAttribute('wallet_id', wallet.id);
                wallet_card.innerHTML = `
                    <div class="wallet-info">
                        <h2>Wallet Number: <span>${wallet.wallet_number}</span></h2>
                        <p>Balance: <span>$${wallet.balance}</span></p>
                    </div>
                    <div class="wallet-actions">
                        <button class="button deposit" onclick="window.location.href='deposit.html?wallet_id=${wallet.id}'">Deposit</button>
                        <button class="button withdraw" onclick="window.location.href='withdraw.html?wallet_id=${wallet.id}'">Withdraw</button>
                        <button class="button transfer" onclick="window.location.href='transfer.html?wallet_id=${wallet.id}'">Transfer</button>
                        <button class="button delete" onclick="deleteWallet(${wallet.id})">Delete</button>
                    </div>
                `;
                wallet_container.appendChild(wallet_card);
            });
        } else {
            displayMessage(response.data.message, false);
        }
    } catch (error) {
        console.error('Error fetching wallets:', error);
        displayMessage('An error occurred. Try again later.', false);
    }
};

const handleCreateWallet = async () => {
    const user_id = localStorage.getItem('user_id');
    if (!user_id) {
        console.log('whos that');
    }

    formData = new FormData();
    formData.append('user_id', user_id);

    try {
        const response = await axios.post(`${pages.baseUrl}createWallet.php`, formData, {
            headers: 'Content-type: mulipart/form-data'
        });
        console.log(response.data);
        displayMessage(response.data.message);
        location.reload();
    } catch(error) {
        console.error('error during creating wallet.',error)
    }
}
const deleteWallet = async (wallet_id) => {
    formData = new FormData();
    formData.append('wallet_id', wallet_id);

    try {
        const response = await axios.post(`${pages.baseUrl}deleteWallet.php`, formData, {
            headers: 'Content-type: multipart/form-data'
        })
        console.log(response.data);
        displayMessage(response.data.message);
        location.reload();
    } catch (error) {
        console.error('error during deleting wallet.', error);
    }
}
   
pages.faqsPage = () => {
    const faqs = document.querySelectorAll('.faq');
    faqs.forEach(faq => faq.addEventListener('click', showFaq));
}

const showFaq = (event) => {
    let answer = event.currentTarget.querySelector('.answer');
    answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
}

