const pages = {};

pages.baseUrl = 'http://localhost/digital-wallet/wallet-server/connection/user/v1/APIs/';

pages.loadFor = (page) => {
    eval (`pages.${page}Page()`)
}

pages.signupPage = () => {
    document.querySelector('.signup-button').addEventListener('click',handleSignup);
}
const handleSignup = () => {
    console.log('hello');
    const username = document.getElementById('username').value
    const email = document.getElementById('email').value
    const phoneNumber = document.getElementById('phone').value
    const password = document.getElementById('password').value
    const confirmPassword = document.getElementById('confirm-password').value
    const address = document.getElementById('address').value
    const fileUrl = document.getElementById('id-document').files[0];

    console.log(fileUrl);
    event.preventDefault(); 

    const formData = new FormData();
    formData.append('username', username);
    formData.append('email', email);
    formData.append('phoneNumber', phoneNumber);
    formData.append('password', password);
    formData.append('confirmPassword',confirmPassword)
    formData.append('address', address);
    formData.append('fileUrl', fileUrl);

    axios.post(`${pages.baseUrl}signup.php`, formData, {
        headers: {
            'Content-type': 'multipart/form-data',
        }
    }).then(response => {
        console.log('user registered successfully:', response.data);
    }).then(error => {
        console.error('error during registration', error);
    })
}
pages.homePage = () => {
    document.querySelector('.get-started').addEventListener('click', () => {
        window.location.href = '../html/services.html';
    })
}
pages.profilePage = () => {
    document.getElementById('username').value;
}