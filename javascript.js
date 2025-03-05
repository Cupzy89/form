document.querySelector('#loginForm').addEventListener('submit', function(e) {
  var username = document.querySelector('#username').value;
  var password = document.querySelector('#password').value;
  
  if (!username || !password) {
    alert('Masukkan username dan password!');
    e.preventDefault();
  }
});
