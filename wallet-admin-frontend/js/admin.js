const pages = {};

pages.loadFor = (page) => {
    eval (`pages.${page}Page()`);
}
pages.baseUrl = "http://localhost//digital-wallet/wallet-server/connection/admin/v1/APIs/";

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
            checkAdmin(response.data.message);
 
        } else {
            console.log('Login rejected:', response.data.message)
            console.log(response.data.message)
            displayMessage(response.data.message, false);
        }
    } catch (error) {
        console.error('Login failed:', error);
        displayMessage('An error occurred during login.', false);
    }
}
const checkAdmin = async (user_id) => {

     try {
        const response = await axios.get(`${pages.baseUrl}checkAdmin.php?user_id=${user_id}`);

        if (response.data.success) {
            console.log(response.data);
            localStorage.setItem('user_id', user_id);
            window.location.href = '../html/adminPanel.html';
            

        } else {
            checkUserVerification(user_id);
        }
    } catch (error) {
        console.error('Error checking verification status:', error);
        displayMessage('Error checking verification status. Please try again later.', false);
    }
}
pages.userGrowthPage = async () => {
    try {
        const response = await axios.get(`${pages.baseUrl}getUsersTransactions.php`);
        const total_users = document.getElementById('total-users');
        const total_transactions = document.getElementById('total-transactions');
        total_users.innerHTML = response.data.message[0];
        total_transactions.innerHTML = response.data.message[1];
        
    } catch (error) {
        console.error('error during loading users');
    }
} 

const verifyUser = async (user_id) => {
    formData = new FormData();
    formData.append('user_id',user_id)
    try {
        const response = await axios.post(`${pages.baseUrl}verifyUser.php`,formData)
        console.log(response.data.message);
        location.reload()
    } catch (error) {
        console.error('error during acceptance');
    }
}

pages.verificationPage = () => {
    document.addEventListener("DOMContentLoaded", async () => {
    try {
       
        const response = await axios.get(`${pages.baseUrl}getPendingUsers.php`);
        const users = response.data.message;

         const userList = document.getElementById("user-list");
            let userEntriesHTML = '';

            users.forEach(user => {
                userEntriesHTML += `
                    <div class="user-entry">
                        <div class="user-details">
                            <p><strong>${user.username}</strong> (ID: ${user.user_id})</p>
                            <a class="doc-link" href="${user.id_url}" target="_blank">View Document</a>
                            <br>
                            <img class="user-image" src="${user.id_url}" alt="User Document Image">
                            <button class="accept-button" onclick="verifyUser(${user.user_id})">accept</button>
                        </div>
                    </div>
                `;
            });
            userList.innerHTML = userEntriesHTML;
    } catch (error) {
        console.error("Error fetching user documents:", error);
    }
});

}
