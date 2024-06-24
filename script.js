const signUplink = document.getElementById('signUplink');
const loginlink = document.getElementById('loginlink');
const signInform = document.getElementById('signIn');
const signUpform = document.getElementById('signUp');

signUplink.addEventListener('click', function(){
    signInform.style.display = "none";
    signUpform.style.display = "block";
})

loginlink.addEventListener('click', function(){
    signInform.style.display = "none";
    signUpform.style.display = "block";
})
